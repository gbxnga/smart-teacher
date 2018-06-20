<?php

namespace App\Http\Controllers;

use Validator;
use App\Assignment;
use Illuminate\Http\Request;
use App\Assignment as TheAssignment;
use App\TheClass;
use App\Subject;
use App\Subtopic;
use App\Student;
Use App\Section;
Use App\Settings;

class AssignmentController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $sections = Section::all();
        $assignments = TheAssignment::where('year', $current_year)->where('term', $current_term)->get();
        $classes = TheClass::all();
        $subjects = Subject::all();
        $subtopics = Subtopic::all();
        return view('assignment.create', compact('assignments','classes','subjects','subtopics','sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;

        $this->validate($request, [
            'section_id' => 'bail|required|string|min:1',
            'subject_id' => 'required|string|min:1',
            'subtopic_id' => 'required|string|min:1',
            'max' => 'required|integer|min:0',
            'min' => 'required|integer|min:0',
            'description' => 'required|string|max:200',
        ]);
        $assignment = new Assignment(array(
            'section_id' => $request->get('section_id'),
            'subject_id' => $request->get('subject_id'),
            'subtopic_id' => $request->get('subtopic_id'),
            'description' => $request->get('description'),
            'max' => $request->get('max'),
            'min' => $request->get('min'),
            'year'=> $current_year,
            'term'=> $current_term,
        ));
        $assignment->save();
        return redirect()->route('assignment.form.create')->with('status', 'Assignment Successfully registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $assignment = Assignment::whereId($id)->firstOrFail();

        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $assignments = TheAssignment::where('year', $current_year)->where('term', $current_term)->get();

        $classes = TheClass::all();
        $subjects = Subject::all();
        $subtopics = Subtopic::all();
        $sections = Section::all();
        $edit = array('editmode'=>'true');
        return view('assignment.create', compact('assignment','assignments','classes','subjects','subtopics', 'edit', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $this->validate($request, [
            'section_id' => 'bail|required|string|min:1',
            'subject_id' => 'bail|required|string|min:1',
            'subtopic_id' => 'bail|required|string|min:1',
            'max' => 'required|integer|min:0',
            'min' => 'required|integer|min:0',
            'description' => 'required|string|max:200',
        ]);
        $assignment = Assignment::whereId($id)->firstOrFail();
        $assignment->section_id = $request->get('section_id');
        $assignment->subject_id = $request->get('subject_id');
        $assignment->subtopic_id = $request->get('subtopic_id');
        $assignment->description = $request->get('description');
        $assignment->max = $request->get('max');
        $assignment->min = $request->get('min');
        $assignment->save();
        return redirect()->route('assignment.form.create')->with('status', 'Assignment Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $assignment = Assignment::find($id);
        $assignment->delete();
        return redirect()->route('assignment.form.create')->with('status', 'Assignment Successfully deleted');
    }

}
