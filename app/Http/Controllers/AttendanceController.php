<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\Timetable;
Use App\Subject;
Use App\TheClass;
Use App\Attendance;
Use App\Section;
Use App\Student;
use Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function getClasses()
    {
        $classes = TheClass::all();
        
        return $classes;
    }
    public function index_report()
    {
        $sections = Section::all();
        $classes = $this->getClasses();
        $edit = array('editmode'=>'false');
        return view('attendance.report', compact('classes','edit','sections'));
    }
    public function index ()
    {
        $classes = $this->getClasses();
        $sections = Section::all();
        $edit = array('editmode'=>'false');
        return view('attendance.index', compact('classes','edit', 'sections'));
    }
    public function date ()
    {
        $sections = Section::all();
        $classes = $this->getClasses();
        $edit = array('editmode'=>'false');
        return view('attendance.date', compact('classes','edit','sections'));
    }

    public function date_list(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $date = $request->get('date');

        // grab a list of all students in this class
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        $attendances = DB::table('attendances')->where('class_id', $class_id)->where('section_id', $section_id)->where('attendance_date', date('Y-m-d',strtotime($date)))->get();
        $clas = TheClass::whereId($class_id)->firstOrFail();
        
        $classes = $this->getClasses();

        $sec = Section::whereId($section_id)->firstOrFail();
        $sections = Section::all();
        
        $edit = array('editmode'=>'true');
        return view('attendance.date', compact('classes','edit', 'students', 'clas','request', 'attendances','sections','sec'));
    }

    public function form (Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $date = $request->get('date');
        //$students = Students::whereClass_id($class_id);

        // check if attendance already inputed
        $attendances = DB::table('attendances')->where('class_id', $class_id)->where('section_id', $section_id)->where('attendance_date', date('Y-m-d',strtotime($date)))->get();
        //print_r($attendances);exit();
        if (count($attendances)>0)
        {
            
            // grab the attendance list for edit
        }
        //$students = DB::select("SELECT * FROM students WHERE class_id =".$class_id);
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        $clas = TheClass::whereId($class_id)->firstOrFail();
        $sec = Section::whereId($section_id)->firstOrFail();
        
        $classes = $this->getClasses();
        $sections = Section::all();

        $edit = array('editmode'=>'true');
        return view('attendance.index', compact('classes','edit', 'students', 'clas','request', 'attendances','sections','sec'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required|integer|max:255',
            'date' => 'required|date',
        ]);
        $class_id = $request->get('class_id');
        $date = $request->get('date');

        // grab a list of all students in this class
        //$students = DB::select("SELECT id FROM students WHERE class_id =".$class_id);
        $attendances = DB::table('attendances')->where('class_id', $class_id)->where('attendance_date', date('Y-m-d',strtotime($date)))->get();
       
        //$students = $students->toArray();
        $students = json_decode(json_encode($students), true);
        $attendances = json_decode(json_encode($attendances), true);

        // compare
        foreach ($students as $v)
        {
            foreach ($v as $s_id){
                if ($request->get(''.$s_id.'_V') !== 'P')
                {
                    foreach ($attendances as $attendance)
                    {
                        if ($attendance['student_id'] === $s_id['id'])
                        {
                            $type = $request->get(''.$s_id['id'].'_'.$attendance['id'].'_'.'V');
                            $at = Attendance::whereId($attendance['id'])->firstOrFail();
                            $at->type = $type;
                            $at->save();
                        }
                    }
                }
            }
            
        }
        return redirect(action('AttendanceController@index'))->with('status', 'Attendance successfully saved');

    }

    public function save (Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required|integer|min:1',
            'section_id' => 'required|integer|min:1',
        ]);
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');

        // grab a list of all students in this class
        $students = DB::select("SELECT id FROM students WHERE class_id =".$class_id);
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get(['id']);

        //$students = $students->toArray();
        $students = json_decode(json_encode($students), true);
        // compare
        foreach ($students as $v)
        {
            foreach ($v as $s_id){
                if ($request->get(''.$s_id.'_V') != 'P')
                {
                    // register attendance
                    $attendance = new Attendance(array(
                        'class_id' => $request->get('class_id'),
                        'section_id' => $request->get('section_id'),
                        'student_id' => $s_id,
                        'type' => $request->get(''.$s_id.'_V'),

                        // convert date to acceptable mysql format
                        'attendance_date' => date('Y-m-d',strtotime($request->get('date'))),
                    ));
                    $attendance->save();
                }
            }
            
        }
        return redirect()->route('attendance.index')->with('status', 'Attendance successfully saved');
    }

    public function report(Request $request)
    {
        $this->validate($request, [
            'section_id' => 'required|integer|min:1',
            'class_id' => 'required|integer|max:255',
            'month' => 'required|string|max:2',
        ]);
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $month = $request->get('month');

        // grab a list of all students in this class
        //$students = DB::select("SELECT * FROM students WHERE class_id =".$class_id);
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        $clas = TheClass::whereId($class_id)->firstOrFail();

        $classes = $this->getClasses();

        $att = array();
        foreach ($students as $student) // for each of the students in this class
        {
            for($i=1;$i<31;$i++) // pick each day of the month
            {
                if (strlen($i) === 1) $i = '0'.$i;
                $year = date('Y');
                $the_day = $i.'-'.$month.'-'.$year;

                // was student absent on this day ??
                $sql = 'SELECT * FROM `attendances` where DATE_FORMAT(attendance_date, "%d-%m-%Y") = "'.$the_day.'" AND student_id ='.$student->id;
                $attendances = DB::select($sql);

                if (count($attendances)>0) // if yes, log the record in an array
                {
                    foreach ($attendances as $attendance)
                    {
                        $att[$student->id][$i] = $attendance->type;
                    }
                }
            }
                                            
        }
        $sec = Section::whereId($section_id)->firstOrFail();
        $sections = Section::all();
        
        $edit = array('editmode'=>'true');
        return view('attendance.report', compact('classes','edit', 'students', 'sections','sec', 'clas','request'))->with('att', json_encode($att,true));

    }

}
