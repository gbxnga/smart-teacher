<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\TheClass;
use App\Student;
Use App\Attendance;
Use App\AssignmentMark;
Use App\Assignment;
use Carbon\Carbon;
Use Validator;
Use App\Comment;
Use App\Section;
use App\Subject;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function delete($id)
    {
        Validator::make(['id'=>$id], [
            'id' => 'required|integer|max:10',
        ])->validate();
        $student = Student::whereId($id)->firstOrFail();
        $student->delete();
        return redirect('/student/search')->with('status', 'Student has been deleted!');
    }
    public function index()
    {
        //$classes = TheClass::all();
        //$students = array();
        $sections = Section::all();
        $classes = DB::select('select name from the_classes GROUP BY name');
        return view('student.index', compact('classes','sections'));
        
    }
    public function search_info(Request $request){
        $classes = DB::select('select name from the_classes GROUP BY name');
        $sql = 'SELECT *, c.name AS class_name, sections.name AS section_name, s.id AS stud_id FROM students s INNER JOIN the_classes c ON c.id = s.class_id INNER JOIN sections ON sections.id = s.section_id WHERE MATCH (firstname,lastname,father_name,mother_name,guardian_name)
                AGAINST (\''.$request->info.'\')';
        $students = DB::select($sql);
        $sections = Section::all();
        //echo $sql;
        return view('student.search', compact('classes','students','sql','sections'));
    }
    public function search(Request $request)
    {
        $classes = DB::select('select name from the_classes GROUP BY name');
        if ($request->section == 'All')
        {
            $sql = "SELECT  *,  c.name AS class_name, sections.name AS section_name, s.id AS stud_id FROM students s INNER JOIN the_classes c ON c.id = s.class_id INNER JOIN sections ON sections.id = s.section_id WHERE c.name = '$request->class_id'";
        }
        else
        {
            $sql = "SELECT  *, c.name AS class_name, sections.name AS section_name,  s.id AS stud_id FROM students s INNER JOIN the_classes c ON c.id = s.class_id INNER JOIN sections ON sections.id = s.section_id WHERE c.name = '$request->class_id' 
            AND s.section_id = '$request->section' ";
        }
        $students = DB::select($sql);
        $sections = Section::all();
        return view('student.search', compact('classes','students','sections'));
    }

    public function register_form()
    {
        $classes = TheClass::all();
        $sections = Section::all();
        return view('student.register', compact('classes', 'sections'));
    }
    public function register(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'bail|required|integer|min:1',
            'section_id' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'firstname' => 'required|string|max:255',
            

        ]);
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');

            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
    
            $destinationPath = public_path('/images');
    
            $image->move($destinationPath, $input['imagename']);
    
            $image_name = $input['imagename'];
        }


       
        $student = new Student(array(
            'class_id' => $request->get('class_id'),
            'section_id' => $request->get('section_id'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'image' => $image_name || NULL,
            'mobileno' => $request->get('mobileno'),
            'gender' => $request->get('gender'),
            'date_of_birth' => $request->get('date_of_birth'),
            'current_address' => $request->get('current_address'),
            'guardian_is' => $request->get('guardian_is'),
            'father_name' => $request->get('father_name'),
            'father_phone' => $request->get('father_phone'),
            'father_occupation' => $request->get('father_occupation'),
            'mother_name' => $request->get('mother_name'),
            'mother_phone' => $request->get('mother_phone'),
            'mother_occupation' => $request->get('mother_occupation'),
            'guardian_name' => $request->get('guardian_name'),
            'guardian_relation' => $request->get('guardian_relation'),
            'guardian_phone' => $request->get('guardian_phone'),
            'guardian_occupation' => $request->get('guardian_occupation'),
            'guardian_address' => $request->get('guardian_address'),
            'is_active' => $request->get('is_active')
        ));
        $student->save();
        return redirect('/student/register')->with('status', 'Student Successfully registered');
    }

    public function edit_form($id)
    {
        Validator::make(['id'=>$id], [
            'id' => 'required|integer|max:10',
        ])->validate();
        $student = Student::whereId($id)->firstOrFail();
        $classes = TheClass::all();
        $sections = Section::all();
        return view('student.edit', compact('student','classes', 'sections'));
    }
    public function update($id, Request $request)
    {
        
        // check if image isnt empty
        if (!empty($request->file('image'))){

            // validate image
            $this->validate($request, [
                'class_id' => 'bail|required|integer|min:1',
                'section_id' => 'required|integer|min:1',

                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);

            $image = $request->file('image');

            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/images');

            $image->move($destinationPath, $input['imagename']);

            $image_name = $input['imagename'];

            
        }

        $student = Student::whereId($id)->firstOrFail();
        $student->class_id = $request->get('class_id');
        $student->section_id = $request->get('section_id');
        $student->firstname = $request->get('firstname');
        $student->lastname = $request->get('lastname');
        //$student->image = $request->get('image');
        $student->mobileno = $request->get('mobileno');
        if (!empty($image_name) && ($image_name!== NULL)) $student->image = $image_name;
        $student->gender = $request->get('gender');
        $student->date_of_birth = $request->get('date_of_birth');
        $student->current_address = $request->get('current_address');
        $student->guardian_is = $request->get('guardian_is');
        $student->father_name = $request->get('father_name');
        $student->father_phone = $request->get('father_phone');
        $student->father_occupation = $request->get('father_occupation');
        $student->mother_name = $request->get('mother_name');
        $student->mother_phone = $request->get('mother_phone');
        $student->mother_occupation = $request->get('mother_occupation');
        $student->guardian_name = $request->get('guardian_name');
        $student->guardian_relation = $request->get('guardian_relation');
        $student->guardian_phone = $request->get('guardian_phone');
        $student->guardian_occupation = $request->get('guardian_occupation');
        $student->guardian_address = $request->get('guardian_address');
        $student->is_active = $request->get('is_active');
        $student->save();
        return redirect(action('StudentController@edit_form', $id))->with('status', 'Student Record Successfully updated');
    }

    public function show($id)
    {
        Validator::make(['id'=>(int)$id], [
            'id' => 'bail|required|integer|min:1',
        ])->validate();
        
        $student = Student::whereId($id)->firstOrFail();
        $classes = TheClass::all();
        $attendances = Attendance::where('student_id', $id)->get(['type', 'attendance_date']);
        //$attendance_week = Attendance::
        $attendance_week = Attendance::select('type', 'attendance_date', 'created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->created_at)->format('m'); // grouping by months
                        return Carbon::parse($date->created_at)->format('d'); // grouping by days
                    });
        $grades = AssignmentMark::where('student_id', $id)->get(['assignment_id', 'mark']);
        $theassignment = [];

        foreach ($grades as $grade)
        {          
            $assignment = Assignment::where('id', $grade->assignment_id)->first();
            //sprint_r($assignment);
            
            $final = array('subject'=>$assignment->getSubject(),'date'=>$grade->created_at, 'id'=>$grade->assignment_id,'mark'=>$grade->mark,'description'=>$assignment->description,'min'=>$assignment->min, 'max'=>$assignment->max);
            $theassignment[]= $final;
        }

        $theassignments = json_encode($theassignment, true);

        $final_json = [];
        //$total_wekdays;
        $current_month;
        
        $now = new \DateTime('now');
        $month = $now->format('m');
        

        $today = date("Y-m-d");
        $total_weekdays = self::getWorkdays('2018-'.$month.'-01', $today);

        if (substr($month,0,1)=="0") $month = substr($month,1);

        for($i = 1;$i <= $month;$i++)
        {
            $present = 0;
            $absent = 0;
            $late = 0;
            $late_excuse = 0;
            // pick a month
            foreach ($attendances as $attendance)
            {                
                // iterate to all attendance records
                $month_from_timestamp = substr($attendance->attendance_date,5,2);
                if (substr($month_from_timestamp,0,1)=="0") $month_from_timestamp = substr($month_from_timestamp,1);
                //echo $month_from_timestamp; echo $i.'<br/>';
                if ($month_from_timestamp  == $i)
                {                   
                    if ($attendance->type == 'A') $absent++;
                    else if ($attendance->type == 'L') $late++;
                    else if ($attendance->type == 'LE') $late_excuse++;

                    $themonth = date('M', strtotime($attendance->attendance_date)) ;                                      
                }                
            }
            $m = strlen($i == 1) ? (int)"0".$i : $i;
            $noww = new \DateTime('now');
            $monthh = $noww->format('m');

            $last_day_of_the_month = date('t',strtotime($i.'/1/2018'));
            $total_weekdays_this_month = self::getWorkdays('2018-'.$m.'-01', '2018-'.$m.'-'.$last_day_of_the_month.'');
            $present = $total_weekdays_this_month - $absent - $late_excuse - $late;
            $present = ($present/$total_weekdays_this_month)*100;
            $absent = ($absent/$total_weekdays_this_month)*100;
            $late = ($late/$total_weekdays_this_month)*100;
            $late_excuse = ($late_excuse/$total_weekdays_this_month)*100;
            
            $result = array( 'y'=>date('M',strtotime('2018-'.$m.'-01')),'a'=>round($present), 'b'=>round($absent), 'c'=>round($late), 'd'=>round($late_excuse));
            $final_json[] = $result;
        }
        $bars = json_encode($final_json,true);

        $comments = Comment::where('student_id', $id)->get(['id','comment']);


        $stats = self::thestat($student->id);
        return view('student.profile', compact('stats','student', 'classes', 'attendances','bars', 'theassignments','attendance_week', 'comments'));
    }

    private static function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
        if (!defined('SATURDAY')) define('SATURDAY', 6);
        if (!defined('SUNDAY')) define('SUNDAY', 0);
        // Array of all public festivities
        $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
        // The Patron day (if any) is added to public festivities
        if ($patron) {
          $publicHolidays[] = $patron;
        }
        /*
         * Array of all Easter Mondays in the given interval
         */
        $yearStart = date('Y', strtotime($date1));
        $yearEnd   = date('Y', strtotime($date2));
        for ($i = $yearStart; $i <= $yearEnd; $i++) {
          $easter = date('Y-m-d', easter_date($i));
          list($y, $m, $g) = explode("-", $easter);
          $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
          $easterMondays[] = $monday;
        }
        $start = strtotime($date1);
        $end   = strtotime($date2);
        $workdays = 0;
        for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
          $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
          $mmgg = date('m-d', $i);
          if ($day != SUNDAY &&
            !in_array($mmgg, $publicHolidays) &&
            !in_array($i, $easterMondays) &&
            !($day == SATURDAY && $workSat == FALSE)) {
              $workdays++;
          }
        }
        return intval($workdays);
    }

    public function comment(Request $request, $id)
    {
        Validator::make(['id'=>$id], [
            'id' => 'required|integer|min:1',
        ])->validate();
        $this->validate($request, ['comment' => 'required|string|max:255']);

        $comment = new Comment(array(
            'student_id'=>$id,
            'comment' => $request->comment
        ));
        $comment->save();

        return back()->with('status', 'Comment successfully added!');
    }

    public function delete_comment($id)
    {
        Validator::make(['id'=>$id], [
            'id' => 'required|integer|min:1',
        ])->validate();
        $comment = Comment::whereId($id)->firstOrFail();

        $comment->delete(); 
        return back()->with('status', 'Comment successfully Deleted!');       
    }

    private static function thestat($id)
    {
        // get all students list
        $student = Student::where('id',$id)->get()->first();


        // for each student get their average score 
        $arrays = [];
        $subjects = Subject::where('class_id', $student->class_id)->get();
        $themonths = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $break = false;
        $current_month = date('F');
        //exit($current_month);
        foreach ($themonths as $themonth)
        {
            if ($break) break;
            if ($themonth == $current_month) $break = true;
            $months[] = $themonth;
        }

        $theData = [];
        $colors = ['red','green','blue','orange','yellow', 'indigo', 'violet'];
        $break_next_loop = false;
        foreach($subjects as $subject)
        {           
            $array =[];
            $scores = [];
            
            //echo 'Subject: '.$subject->name.'<br/>';
            foreach ($months as $month)
            {
                $firstDay = \Carbon\Carbon::parse("first day of {$month}");
                $lastDay = \Carbon\Carbon::parse("last day of {$month}");
                $sql = "CALL `get_student_stat_by_week`('$student->id', '$firstDay', '$lastDay', '$subject->id')";
                $student_stat = DB::select($sql);
                //print_r($student_stat); exit();
                $scores[] =  (!empty($student_stat[0]->avg_score)) ? $student_stat[0]->avg_score : '0';
                //echo $month.' : '.$student_stat[0]->avg_score.'<br/>';


                //print_r($scores);
            }  
            // turn scores to string;
            $scores = implode(",",$scores);
            $element = array_rand($colors);
            $color = $colors[$element];
            unset($colors[$element]);// delete color to avoid repeat 
            $array['subject_id'] = $subject->id;
            $array['label'] = $subject->name;
            $array['data'] = $scores; 
            $array['pointHighlightStroke'] = $color;
            $array['fillColor'] = $color;
            $array['strokeColor'] = $color;
            $array['pointColor'] = $color;
            $array['pointStrokeColor'] = $color;
            $array['pointHighlightFill'] = $color; 
            $theData[] = $array;
            //echo '<br/>';          
        }
        /*print_r($theData);
        echo '<br/>'.$theData[0]['label'];
        $tt = $theData[0]['data'];
        foreach($tt as $t)
        {
            echo $t.'<br/>';
        }*/


        return $theData;
        
    }


}
