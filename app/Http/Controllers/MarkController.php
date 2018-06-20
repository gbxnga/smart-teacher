<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\TheClass;
use App\Student;
use App\Mark;
Use App\Subject;
Use App\Section;
use Auth;
use App\Settings;

class MarkController extends Controller
{
    public function index()
    {
        $classes = TheClass::all();
        $edit = array('editmode'=>'false');
        return view('mark.index', compact('classes', 'edit'));
    }
    public function selectClassForm()
    {
        $classes = TheClass::all();
        $sections = Section::all();
        $edit = array('editmode'=>'false');
        return view('mark.create', compact('classes', 'edit','sections'));
    }
    public function viewMarks(Request $request)
    {
        $class_id = $request->get('class_id');
        $exam = $request->get('exam');

        // check if score have been given for this class for this subject
        $sql = "SELECT m.id AS m_id,s.id AS s_id, sc.id AS sch_id, s.lastname, m.mark, sc.exam, sc.date FROM marks m 
        INNER JOIN exam_schedules sc ON (m.exam_schedule_id = sc.id) INNER JOIN students s ON (s.id = m.student_id) 
        WHERE  sc.exam = '$exam' AND sc.class_id =". $class_id;
        $marks_check = DB::select($sql);
        if (count($marks_check)>0)
        {
            // grab and display them for edit
            $marks = $marks_check;
        
            
        }

        $schedules = DB::select('SELECT * FROM exam_schedules WHERE exam = "'.$exam.'" AND class_id ='.$class_id);

        // grab a list of all students assigned in this class
        $subjects = DB::select("SELECT s.id AS subject_id, s.name AS subject FROM assigns a INNER JOIN subjects s ON (s.id = a.subject_id) INNER JOIN the_classes c ON (c.id = a.class_id) WHERE c.id = ".$class_id);
        //print_r($subjects);exit();
        $clas = TheClass::whereId($class_id)->firstOrFail();

        // list of students in this class
        $students = DB::select('SELECT *, CONCAT(firstname, \' \', lastname) AS name FROM students WHERE class_id = '.$class_id);
        $classes = TheClass::all();
        $edit = array('editmode'=>'true');
        return view('mark.index', compact('classes', 'edit', 'clas', 'subjects', 'request', 'schedules', 'students','marks'));
    }

    public function marksForm(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'exam' => 'required|string|max:4',
        ]);
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $exam = $request->get('exam');

        // check if score have been given for this class for this subject
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $markss = Mark::where('section_id', $section_id)->where('class_id', $class_id)->where('EXAM', $exam)->where('year', $current_year)->where('term', $current_term)->get();
        if ($markss->count()>0)
            $marks = $markss;

        // grab a list of all students assigned in this class
        $subjects = Subject::where('class_id', $class_id)->get();
        $clas = TheClass::whereId($class_id)->firstOrFail();
        $sec = Section::whereId($section_id)->firstOrFail();
        $sections = Section::all();

        // list of students in this class
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        $classes = TheClass::all();
        $edit = array('editmode'=>'true');
        return view('mark.create', compact('classes', 'sec', 'edit', 'clas', 'subjects', 'request', 'students','marks','sections'));
    }

    public function saveMark(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'exam' => 'required|string|max:4',
        ]);
        $exam = $request->get('exam');
        $submit = $request->get('submit');
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');

        $subjects = Subject::where('class_id', $class_id)->get();
        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        

        $subjects = json_decode(json_encode($subjects), true);
        $students = json_decode(json_encode($students), true);
        
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;

        foreach ($students as $student)
        {
            foreach ($subjects as $subject)
            {
                $mark = $request->get('mark_'.$subject['id'].'_'.$student['id']);
                $marks = new Mark(array(
                            'subject_id' => $subject['id'],
                            'student_id' => $student['id'],
                            'class_id' => $class_id,
                            'section_id' => $section_id,
                            'exam'=>$exam,
                            'mark' => $mark,
                            'year'=>$current_year,
                            'term'=>$current_term,
                ));
                $marks->save();         
            }                                        
        }

        return redirect('mark/create')->with('status', 'Marks saved');
    }

    public function updateMark(Request $request)
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term; 
        
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'exam' => 'required|string|max:4',
        ]);
        $exam = $request->get('exam');
        $submit = $request->get('submit');
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');

        $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();
        $subjects = Subject::where('class_id', $class_id)->get();

        $marks = Mark::where('section_id', $section_id)->where('class_id', $class_id)->where('EXAM', $exam)->where('year', $current_year)->where('term', $current_term)->get();

        $subjects = json_decode(json_encode($subjects), true);
        $students = json_decode(json_encode($students), true);
        $marks = json_decode(json_encode($marks), true);



        foreach ($students as $student)
        {
            foreach ($subjects as $subject)
            {
                $mark = $request->get('mark_'.$subject['id'].'_'.$student['id']);
                if (!empty($mark) )
                {                 
                    $marks = new Mark(array(
                            'subject_id' => $subject['id'],
                            'student_id' => $student['id'],
                            'class_id' => $class_id,
                            'section_id' => $section_id,
                            'exam'=>$exam,
                            'mark' => $mark,
                            'year'=>$current_year,
                            'term'=>$current_term,
                    ));
                    $marks->save();
                }

                foreach ($marks as $mark)
                {
                    if (($subject['id'] == $mark['subject_id']) && ($student['id'] == $mark['student_id'] ) )
                    {
                        $updated_mark = $request->get('mark_'.$subject['id'].'_'.$student['id'].'_'.$mark['id']);
                        $mk = Mark::whereId($mark['id'])->firstOrFail();

                        // update only if initial mark and new arent equal
                        if ($mk->mark != $updated_mark)
                        {
                            $mk->mark = $updated_mark;
                            $mk->save();
                        }
                    }
                }         
            }                                        
        }
        return redirect('/mark/create')->with('status', 'Marks Updated');

    }
}
