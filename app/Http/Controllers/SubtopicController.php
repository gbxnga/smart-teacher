<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
Use App\Subject;
Use App\Subtopic;

class SubtopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(Request $request, $id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);

        $subtopic = new Subtopic(array(
            'description' => $request->get('name'),
            'subject_id'=>$id
        ));
        $subtopic->save();
        return redirect()->route('subject.view', $id)->with('status', 'subtopic successfully created');

    }
}
