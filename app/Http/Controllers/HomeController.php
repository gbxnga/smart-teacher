<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Student;
use Illuminate\Support\Facades\DB;
Use App\AssignmentMark;
Use App\Timetable;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function thestat($all = TRUE, $class_id = NULL, $section_id = NULL)
    {
        // get all students list
        if ($all) $students = Student::all();
        else $students = Student::where('class_id', $class_id)->where('section_id', $section_id)->get();


        // for each student get their average score 
        $arrays = [];
        foreach($students as $student)
        {
            $count = AssignmentMark::where('student_id', $student->id)->get()->count();
            // if student's assignment has ever been recored
            if ($count > 0)
            {
                //$sql = 'CALL `get_student_stat`('.$student->id.')';
                $firstDayOfWeek = \Carbon\Carbon::now()->startOfWeek();
                $lastDayOfWeek = \Carbon\Carbon::now()->endOfWeek();
                $sql = "CALL `get_student_stat_week`('$student->id', '$firstDayOfWeek', '$lastDayOfWeek')";
                //$sql = 'CALL `get_student_stat`('.$student->id.')';
                $student_stat = DB::select($sql);
                $arrays[] = $student_stat;
            }
            
        }
        $max = -9999999; //will hold max val
        $student_high = null; //will hold item with max val;
        foreach ($arrays as $k=>$v)
        {
            foreach($v as $key=>$value)
            {
                if($value->avg_score>$max)
                {
                    $max = $value->avg_score;
                    $student_high = $value;
                }
            }
        }
        // echo "max value is $max";
        // echo '<br/>highest :'. $student_high->total_score;

        $min = 9999999; //will hold max val
        $student_low = null; 
        foreach ($arrays as $k=>$v)
        {
            foreach($v as $key=>$value)
            {
                if($value->avg_score<$min)
                {
                    $min = $value->avg_score;
                    $student_low = $value;
                }
            }
        }

        if (is_null($student_high)) $student_high = $student_low;

        return array('student_low'=>$student_low, 'student_high'=>$student_high);
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = self::thestat(TRUE, NULL, NULL);
        $student_low = $students['student_low'];
        $student_high = $students['student_high'];
        //print_r($student_low);exit();
        // echo "min value is $min";

        // echo '<br/>highest :'. $student_low->total_score;
        date_default_timezone_set("Africa/Lagos");
        $day= date('l');
        $timetables = Timetable::where('day_name', $day)->whereNotNull('start_time')->whereNotNull('end_time')->get();
        
        return view('home', compact('student_high','student_low','timetables'));
    }

    public function upload_image(Request $request)
    {
        $user_id = \Auth::user()->id;
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            

        ]);
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');

            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
    
            $destinationPath = public_path('/images');
    
            $image->move($destinationPath, $input['imagename']);
    
            $image_name = $input['imagename'];

            $user = User::where('id', $user_id)->get()->first();
            if ($user)
            {
                $user->photo = $image_name;
                $user->save();

                return redirect()->back()->with('status','Image Uploaded Successfully');
            }


        }

        return redirect()->back()->with('status','could not upload image');
    }
}
