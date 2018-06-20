<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\Timetable;
Use App\Subject;
Use App\TheClass;
Use App\Section;
use Auth;
use App\Timetable as TheTimetable;

class TimetableController extends Controller
{
    public function __construct() 
    {
       $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1', 
            'subject_id' => 'required|integer|min:1',        
        ]);
        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($days as $day)
        {
                $timetable = new Timetable(array(
                    'subject_id' => $request->get('subject_id'),
                    'section_id' => $request->get('section_id'),
                    'class_id' => $request->get('class_id'),
                    'start_time' => empty($request->get('stime_'.$day)) ? NULL : $request->get('stime_'.$day),
                    'end_time' => empty($request->get('etime_'.$day)) ? NULL : $request->get('etime_'.$day),
                    'day_name' => $day,
                ));
                $timetable->save();

        }
        return redirect(action('TimetableController@form'))->with('status', 'Timetable Saved');

    }

    public function update(Request $request)
    {   
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1', 
            'subject_id' => 'required|integer|min:1',        
        ]);
        // delete class timetable record
        $records = TheTimetable::where('subject_id', $request->get('subject_id'))->where('class_id', $request->get('class_id'))->where('section_id', $request->get('section_id'))->get();
        foreach ($records as $record)
        {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($days as $day)
            {
                if ($record->day_name == $day)
                {
                    $record->start_time = empty($request->get('stime_'.$day)) ? NULL : $request->get('stime_'.$day);
                    $record->end_time = empty($request->get('etime_'.$day)) ? NULL : $request->get('etime_'.$day);
                    $record->save();
                }
            }
        }
        
        return redirect(action('TimetableController@form'))->with('status', 'Timetable Updated');
    }

    public function index()
    {
        $classes = TheClass::all();
        $timetable = TheTimetable::all();
        $subjects = Subject::orderBy('class_id', 'asc')->get();
        $sections = Section::all();
        return view('timetable.indexx', compact('timetable','classes','sections','subjects'));
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1',        
        ]);
        
        $section_id = $request->get('section_id');
        $class_id = $request->get('class_id');

        $classes = TheClass::all();
        $timetables = TheTimetable::where('class_id', $request->get('class_id'))->where('section_id', $request->get('section_id'))->get();
        $subjects = Subject::where('class_id', $class_id)->orderBy('class_id', 'asc')->get();
        $sections = Section::all();

        $sec = Section::find($section_id);
        $clas = TheClass::find($class_id);

        $edit = array('editmode'=>'true');
        return view('timetable.indexx', compact('timetables','classes','sections','subjects','edit','sec','clas'));
    }

    public function form()
    {
        $classes = TheClass::all();
        $subjects = Subject::orderBy('class_id', 'asc')->get();
        $sections = Section::all();
        return view('timetable.create', compact('subjects','classes','sections'));
    }

    public function timetable_form(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1', 
            'subject_id' => 'required|integer|min:1',        
        ]);

        $section_id = $request->get('section_id');
        $class_id = $request->get('class_id');
        $subject_id = $request->get('subject_id');

        $sec = Section::find($section_id);
        $clas = TheClass::find($class_id);
        $sub = Subject::find($subject_id);

        // check if subject belongs to class
        $check = Subject::where('class_id', $class_id)->where('id',$subject_id)->get(['id'])->count();
        if ($check < 1) return redirect(action('TimetableController@form'))->with('status', 'The Subject Selected ('.$sub->name.', '.$sub->getClassName().') doesnt belong to the class ('.$clas->name.')');
        
        // check if record doesnt already exist
        // if true $records is passed to view for edit
        $records = TheTimetable::where('subject_id', $request->get('subject_id'))->where('class_id', $request->get('class_id'))->where('section_id', $request->get('section_id'))->get();


        $classes = TheClass::all();
        $subjects = Subject::orderBy('class_id', 'asc')->get();
        $sections = Section::all();

        $edit = array('editmode'=>'true');
        return view('timetable.create', compact('classes','sections','subjects','edit','sec','clas','sub', 'request', 'records'));
    }

}
