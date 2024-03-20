<?php

namespace App\Http\Controllers;

use App\Mail\NewDiaryEmail;
use Illuminate\Http\Request;

use App\Models\Diary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NewDiaryPosted;

class DiariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            if(Auth::user()->role_id == 1){
                $diaries = Diary::all();
                return $this->generateDatatables($diaries);
            } else if(Auth::user()->role_id == 2){
                $supervisorId = Auth::user()->id;

                $diaries = Diary::where(function ($query) use ($supervisorId) {
                    $query->where('supervisor_id', $supervisorId)
                        ->orWhere('author_id', $supervisorId);
                })->get();
                return $this->generateDatatables($diaries);
            } else {
                $diaries = Diary::where('author_id','=',Auth::user()->id)->get();
                return $this->generateDatatables($diaries);
            }
        };
        
        return view('admin.diaries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisors = User::where('role_id','=',2)->get();
        return view('admin.diaries.create')->with('supervisors',$supervisors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'plantoday' => 'required',
                'eod' => 'required',
                'roadblocks' => 'required',
                'summary' => 'required',
                'plantomorrow' => 'required',
                'supervisor' => 'required',
                'photo' => 'required|mimes:jpg,jpeg,png,gif',
            ]);

            $now = new \DateTime('NOW');
            $date = $now->format('m-d-Y_H.i.s.u');

            if($request->hasFile('photo')){
                $photoNameAndExtension = $request->file('photo')->getClientOriginalName();
                $photoFilename = str_replace(' ','_',pathinfo($photoNameAndExtension, PATHINFO_FILENAME));
                $photoExtension = $request->file('photo')->getClientOriginalExtension();
                $diary_photo = $photoFilename.'-'.$date.'.'.$photoExtension;
                $photoUrl = $request->file('photo')->storeAs('public/uploads/diary-photo', $diary_photo);
            } else {
                $diary_photo = 'No Data';
            }
    
            $diary = Diary::create([
                'plan_today' => $request->plantoday,
                'end_today' => $request->eod,
                'roadblocks' => $request->roadblocks,
                'summary' => $request->summary,
                'plan_tomorrow' => $request->plantomorrow,
                'author_id' => Auth::user()->id,
                'supervisor_id' => $request->supervisor,
                'photo' => $diary_photo,
                'status' => 0
            ]);

            $ptd = str_replace(['<div>','</div>','<ul>','</ul>','<p>','</p>','<strong>','</strong>'],'',$request->plantoday);
            $eod = str_replace(['<div>','</div>','<ul>','</ul>','<p>','</p>','<strong>','</strong>'],'',$request->eod);
            $rb = str_replace(['<div>','</div>','<ul>','</ul>','<p>','</p>','<strong>','</strong>'],'',$request->roadblocks);
            $sum = str_replace(['<div>','</div>','<ul>','</ul>','<p>','</p>','<strong>','</strong>'],'',$request->summary);
            $ptm = str_replace(['<div>','</div>','<ul>','</ul>','<p>','</p>','<strong>','</strong>'],'',$request->plantomorrow);

            $ptdNewLine = str_replace('</li>','\n',$ptd);
            $eodNewLine = str_replace('</li>','\n',$eod);
            $rbNewLine = str_replace('</li>','\n',$rb);
            $sumNewLine = str_replace('</li>','\n',$sum);
            $ptmNewLine = str_replace('</li>','\n',$ptm);

            $planToday = str_replace('<li>','-',$ptdNewLine);
            $endOfDay = str_replace('<li>','-',$eodNewLine);
            $roadblocks = str_replace('<li>','-',$rbNewLine);
            $summary = str_replace('<li>','-',$sumNewLine);
            $planTomorrow = str_replace('<li>','-',$ptmNewLine);

            $htmlContent = "*{Plan Today:}* ".$planToday."\n*{End of Day Report:}* ".$endOfDay."\n*{Roadblocks:}* ".$roadblocks."\n*{Summary:}* ".$summary."\n*{Plans for Tomorrow:} *".$planTomorrow;

            if($diary){
                $trainee = User::where('id','=',$diary->author_id)->first();
                $supervisor = User::where('id','=',$diary->supervisor_id)->first();
                $diary = [
                    'trainee' => $trainee->name,
                    'supervisor' => $supervisor->name,
                    'sup_email' => $supervisor->email,
                    'url' => route('approval-request.public',$diary->id),
                    'content' => $htmlContent
                ];
                
                Mail::to($diary['sup_email'])->send(new NewDiaryEmail($diary));

                Notification::route('slack', config('notifications.slack_webhook'))->notify(new NewDiaryPosted($diary));
            }
    
            $diaries = Diary::all();
            
            return view('admin.diaries.index')->with('diaries',$diaries);
            // return redirect()->route('success')->with('success', 'Data saved successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $diary = Diary::where('id','=',$id)->first();
        $user = User::where('id','=',$diary->author_id)->first();
        $date = $user->created_at->format('M d, Y');
        $name = $user->name;
        $sup = User::where('id','=',$diary->supervisor_id)->first();
        $supervisor = $sup->name;
        $title = 'EOD Report by ' . $name . ' on ' . $date;
        $diary_details = [
            'diary' => $diary,
            'name' => $name,
            'title' => $title,
            'supervisor' => $supervisor,
            'signature' => $sup->signature
        ];
        return view('admin.diaries.show')->with('diary',$diary_details);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $diary = Diary::where('id','=',$id)->first();
        $user = User::where('id','=',$diary->author_id)->first();
        $date = $user->created_at->format('M d, Y');
        $name = $user->name;
        $sup = User::where('id','=',$diary->supervisor_id)->first();
        $supervisor = $sup->name;
        $title = 'EOD Report by ' . $name . ' on ' . $date;
        $diary_details = [
            'diary' => $diary,
            'name' => $name,
            'title' => $title,
            'supervisor' => $supervisor,
            'signature' => $sup->signature
        ];
        return view('admin.diaries.print')->with('diary',$diary_details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diary = Diary::findOrFail($id);
        $supervisors = User::where('role_id','=',2)->get();
        
        return view('admin.diaries.edit')->with([
            'diary' => $diary,
            'supervisors' => $supervisors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'plantoday' => 'required',
                'eod' => 'required',
                'roadblocks' => 'required',
                'summary' => 'required',
                'plantomorrow' => 'required',
                'supervisor' => 'required'
            ]);
    
            $diary = Diary::findOrFail($id);
            
            $diary->update([
                'plan_today' => $request->plantoday,
                'end_today' => $request->eod,
                'roadblocks' => $request->roadblocks,
                'summary' => $request->summary,
                'plan_tomorrow' => $request->plantomorrow,
                'author_id' => Auth::user()->id,
                'supervisor_id' => $request->supervisor,
            ]);
    
            $diaries = Diary::all();
            $message = 'EOD Report has been updated!';
            
            return view('admin.diaries.index')->with([
                'diaries'=>$diaries,
                'success' => $message
            ]);
            // return redirect()->route('success')->with('success', 'Data saved successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteDiary = Diary::findOrFail($id);
        
        $deleteDiary->destroy($id);
        
        if($deleteDiary){
            return response()->json(['message' => 'Diary deleted successfully']);
        } else {
            return response()->json(['error' => 'Deletion failed!']);
        }
    }

    public function generateDatatables($request)
    {
        return DataTables::of($request)
                ->addIndexColumn()
                ->addColumn('title', function($data){
                    $date = $data->created_at->format('F j, Y');
                    $author = User::where('id','=',$data->author_id)->first();
                    if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
                        return $title = 'EOD Report for '.$date.' by '.$author->name;
                    } else {
                        return $title = 'EOD Report for '.$date;
                    }
                })
                ->addColumn('status', function($data){
                    $status = '';
                    if($data->status == 0){
                        $status = '<span class="badge badge-danger">Pending</span>';                        
                    } else {
                        $status = '<span class="badge badge-success">Approved</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($data){
                    $actionButtons = '<a href="'.route("diaries.show",$data->id).'" data-id="'.$data->id.'" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="'.route("diaries.edit",$data->id).'" data-id="'.$data->id.'" class="btn btn-sm btn-warning editDiary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button data-id="'.$data->id.'" class="btn btn-sm btn-danger" onclick="confirmDeleteDiary('.$data->id.')">
                                    <i class="fas fa-trash"></i>
                                    </button>';
                    return $actionButtons;
                })
                ->rawColumns(['action','status','title','author'])
                ->make(true);
    }
}
