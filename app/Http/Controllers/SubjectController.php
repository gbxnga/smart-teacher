<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\Subject;
Use App\Assignment;
Use App\Subtopic;
Use App\TheClass;
Use App\Resource;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $subject = Subject::whereId($id)->firstOrFail();
        $assignments = Assignment::where('subject_id', $id)->get();
        $subtopics = Subtopic::where('subject_id', $id)->get();
        $resources = Resource::where('subject_id', $id)->get();
        return view('subject.view', compact('subject','assignments', 'subtopics','resources'));
    }
    public function index()
    {
        $subjects = Subject::all();
        $classes = TheClass::all();
        return view('subject.index', compact('subjects', 'classes'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'class_id' => 'required|integer|min:1',
        ]);

        $subject = new Subject(array(
            'name' => $request->get('name'),
            'class_id' => $request->get('class_id')
        ));
        $subject->save();
        return redirect()->route('subjects')->with('status', 'subject successfully created');

    }
    public function delete($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $subject = Subject::whereId($id)->firstOrFail();
        $subject->delete();
        return redirect()->route('subjects')->with('status', 'The subject has been deleted!');
    }

    public function edit($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $subjects = Subject::all();
        $subject = Subject::whereId($id)->firstOrFail();
        $edit = array('editmode'=>'true');
        $classes = TheClass::all();
        return view('subject.index', compact('subjects', 'subject', 'edit', 'classes'));
    }

    public function update(Request $request, $id)
    {   
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();

        $this->validate($request, [
            'name' => 'required|string|max:50',
            'class_id' => 'required|integer|min:1',
        ]);     
        $subject = Subject::whereId($id)->firstOrFail();
        $subject->name = $request->get('name');
        $subject->class_id = $request->get('class_id');
        $subject->save();
        return redirect(action('SubjectController@index'))->with('status', 'Subject details Successfully updated');
    }

    public function subtopics($id)
    {
        $result = [];
        $subtopics = Subtopic::where('subject_id', $id)->get();
        foreach ($subtopics as $subtopic)
        {
            $array = array('id'=>$subtopic->id,'name'=>$subtopic->description);

            $result[]= $array;
        }
        return json_encode($result);
    }
}
