<?php

namespace App\Http\Controllers;

use App\AssignmentMark;
use Illuminate\Http\Request;

use Validator;
use App\Assignment as TheAssignment;
use App\TheClass;
use App\Subject;
use App\Subtopic;
use App\Student;
Use App\Section;

class AssignmentMarkController extends Controller
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
    public function create($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        // check if assignment already graded
        $grade = AssignmentMark::where('assignment_id', $id)->get();
        if (count($grade)>0)
            return redirect()->route('assignment.mark.edit', $id)->with('status', 'You have already graded this assignment. You can edit');
        $assignment = TheAssignment::whereId($id)->firstOrFail();
        $subject = Subject::find($assignment->subject_id);
        //print_r($subject);exit();
        $class = TheClass::find($subject->class_id);
        $students = Student::where('class_id', $class->id)->where('section_id', $assignment->section_id)->get(['id','image','firstname','lastname']);

        return view('assignment.mark', compact('assignment', 'students','class'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // get maximum possible score for assignment
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        
        // check if assignment already graded
        $grade = AssignmentMark::where('assignment_id', $id)->get();
        if (count($grade)>0)
            return redirect()->route('assignment.mark.edit', $id)->with('status', 'You have already graded this assignment. You can edit');
        $assignment = TheAssignment::whereId($id)->firstOrFail();
        $subject = Subject::find($assignment->subject_id);
        $class = TheClass::find($subject->class_id);
        // $students = Student::where('class_id', $assignment->class_id)->get(['id','firstname','lastname']);
        $students = Student::where('class_id', $class->id)->where('section_id', $assignment->section_id)->get(['id','firstname','lastname']);
        foreach ($students as $student)
        {
            $score = $request->get('mark_'.$student->id);
            $mark = new AssignmentMark(array(
                        'assignment_id' => $assignment->id,
                        'student_id' => $student->id,
                        'mark' => $score,
                    ));
            $mark->save();            
        }

        return redirect()->route('assignment.marks.view', $id)->with('status', 'Marks Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssignmentMark  $assignmentMark
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $grades = AssignmentMark::where('assignment_id', $id)->get();
        if (count($grades)<1)
            return redirect()->route('assignment.form.mark', $id)->with('status', 'Please Grade Marks before viewing them');
        $assignment = TheAssignment::whereId($id)->firstOrFail();
        $subject = Subject::find($assignment->subject_id);
        $class = TheClass::find($subject->class_id);
        $students = Student::where('class_id', $class->id)->where('section_id', $assignment->section_id)->get(['id','firstname','lastname','image']);
        return view('assignment.marks', compact('assignment', 'students', 'grades','class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignmentMark  $assignmentMark
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $assignment = TheAssignment::whereId($id)->firstOrFail();
        $subject = Subject::find($assignment->subject_id);
        $class = TheClass::find($subject->class_id);
        $students = Student::where('class_id', $class->id)->where('section_id', $assignment->section_id)->get(['id','image','firstname','lastname']);
        $marks = AssignmentMark::where('assignment_id', $id)->get(['student_id', 'mark']); 
        $edit = array('editmode'=>'true');
        return view('assignment.mark', compact('assignment','students','edit','marks','class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssignmentMark  $assignmentMark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        $assignment = TheAssignment::whereId($id)->firstOrFail();
        $subject = Subject::find($assignment->subject_id);
        $class = TheClass::find($subject->class_id);
        $marks = AssignmentMark::where('assignment_id', $id)->firstOrFail();
        $students = Student::where('class_id', $class->id)->where('section_id', $assignment->section_id)->get(['id']);

        // select each student mark

        foreach ($students as $student)
        {
            $mark = AssignmentMark::where(['assignment_id'=>$id, 'student_id'=>$student->id])->first();
            if ($mark)
            {
                $mark->mark = $request->get('mark_'.$student->id);
                $mark->save();  
            }
            else
            {
                // new entry
                $score = $request->get('mark_'.$student->id);
                $mark = new AssignmentMark(array(
                            'assignment_id' => $assignment->id,
                            'student_id' => $student->id,
                            'mark' => $score,
                        ));
                $mark->save(); 

            }          
        }

        return redirect()->route('assignment.marks.view', $id)->with('status', 'Marks Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssignmentMark  $assignmentMark
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentMark $assignmentMark)
    {
        //
    }

    public function performance($id, $section_id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|min:1',
        ])->validate();
        //$section_id =1;
        //$assignment = TheAssignment::whereId($id)->firstOrFail();
        //$subject = Subject::whereId($assignment->subject_id)->firstOrFail();
        //$class = TheClass::whereId($assignment->class_id)->firstOrFail();
        $subject = Subject::whereId($id)->firstOrFail();
        $students = Student::where('class_id', $subject->class_id)->where('section_id', $section_id)->get();
        $class = TheClass::find($subject->class_id);
        $subtopics = Subtopic::where('subject_id', $subject->id)->get();
        $section = Section::find($section_id);
        return view('assignment.performance', compact('subject','assignment', 'subtopics','students','class','section'));
    }
}
