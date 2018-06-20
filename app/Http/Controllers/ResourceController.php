<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
Use App\Resource as TheResource;
Use App\TheClass;
Use App\Subject;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = TheResource::all();
        $subjects = Subject::all();
        $classes = TheClass::all();
        return view('resources.index', compact('resources','classes','subjects'));
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
        $this->validate($request, [
            'file' => 'bail|required|max:3000|mimes:doc,docx,jpeg,png,jpg,gif,svg', //a required, max 10000kb, doc or docx fil
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'subject_id' => 'required|integer|min:1',
        ]);
        if ($request->hasFile('file'))
        {
            $file = $request->file('file');

            $file_size = $request->file('file')->getClientSize();

            $input['filename'] = time().'.'.$file->getClientOriginalExtension();
    
            $destinationPath = public_path('/resources');
    
            $file->move($destinationPath, $input['filename']);
    
            $file_name = $input['filename'];
        }
        else
            return back()->with('status','Couldnt Upload File');

        $resource = new TheResource(array(
            'subject_id' => $request->get('subject_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'file_name' => $file_name,
            'size' => $file_size,
        ));
        $resource->save();
        return back()->with('status', 'File Uploaded Successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource, $id)
    {
        $resource = TheResource::whereId($id)->firstOrFail();
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/resources/".$resource->file_name;

        $headers = array(
                'Content-Type: image',
                );

        return response()->download($file, $resource->name.'_'.$resource->file_name, $headers);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource,$id)
    {
        $resource = TheResource::whereId($id)->firstOrFail();
        $resource->delete();
        return back()->with('status', 'Resource successfully deleted!');
    }
}
