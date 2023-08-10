<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DataTables;

class UsersController extends Controller
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
            $users = User::all();
            return $this->generateDatatables($users);
        };
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
                'name' => 'required|string|max:255',
                'role' => 'required|numeric',
                'email' => 'required|email',
                'temp-password' => 'required|min:8',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'role_id' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->input('temp-password')),
            ]);
    
            $users = User::all();
            
            return view('admin.users.index')->with('users',$users);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit')->with('user',$user);
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
                'name' => 'required|string|max:255',
                'role' => 'required|numeric',
                'email' => 'required|email',
            ]);
    
            $user = User::findOrFail($id);
            
            $user->update([
                'name' => $request->name,
                'role_id' => $request->role,
                'email' => $request->email,
            ]);
    
            $users = User::all();
            
            return view('admin.users.index')->with([
                'users'=>$users,
                'user_name'=>$user->name
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
        $deleteUser = User::findOrFail($id);
        // dd($deleteUser,$deleteUser->name);
        $userName = $deleteUser->name;
        $deleteUser->destroy($id);
        
        if($deleteUser){
            return response()->json(['message' => $userName .' deleted successfully']);
        } else {
            return response()->json(['error' => 'Deletion failed!']);
        }
    }

    public function generateDatatables($request)
    {
        return DataTables::of($request)
                ->addIndexColumn()
                ->addColumn('role', function($data){
                    $role = '';
                    if($data->role_id == 1){
                        $role = '<span class="badge badge-primary">Administrator</span>';
                    } else if($data->role_id == 2){
                        $role = '<span class="badge badge-warning">Supervisor</span>';
                    } else {
                        $role = '<span class="badge badge-secondary">Trainee</span>';
                    }
                    return $role;
                })
                ->addColumn('action', function($data){
                    $actionButtons = '<a href="'.route("users.edit",$data->id).'" data-id="'.$data->id.'" class="btn btn-sm btn-warning editUser">
                                        <i class="fas fa-edit"></i>
                                      </a>
                                      <a href="" data-id="'.$data->id.'" class="btn btn-sm btn-danger" onclick="confirmDelete('.$data->id.')">
                                        <i class="fas fa-trash"></i>
                                      </a>';
                    return $actionButtons;
                })
                ->rawColumns(['action','role'])
                ->make(true);
    }
}
