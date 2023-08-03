<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentation;
use Illuminate\Support\Facades\Auth;


class DocumentationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.documentations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image file
        ]);

        if ($request->hasFile('doc_img')) {
            $imageFile = $request->file('doc_img');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // originalName-time.extension
            $filename = $originalName . "-" . time() . '.' . $imageFile->getClientOriginalExtension();
            
            $path = $imageFile->storeAs('public/uploads/images', $filename);
            
            if (Auth::check()) {
                $userId = Auth::id();
            }

            Documentation::create([
                'image' => $filename,
                'caption' => $request->caption,
                'author_id' => $userId
            ]);
    
            return view('admin.documentations.index')->with('uploadSuccess','The image '.$filename.' successfully uploaded!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
