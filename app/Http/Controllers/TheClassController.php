<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use App\TheClass;
Use App\Student;
Use Validator;
Use App\Section;
Use App\Subject;
Use App\Assignment;
use App\AssignmentMark;
use App\Settings;

class TheClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function stat_sex($class_id, $section_id)
    {
        // total number in class
        $numOfStudentsInClass = Student::where('class_id',$class_id)->where('section_id', $section_id)->get()->count();
        $numOfMalesInClass = Student::where('class_id',$class_id)->where('section_id', $section_id)->where('gender','Male')->get()->count();
        $numOfFemalesInClass = Student::where('class_id',$class_id)->where('section_id', $section_id)->where('gender','Female')->get()->count();

        $percentage_male = ($numOfMalesInClass/$numOfStudentsInClass) * 100;
        $percentage_female = ($numOfFemalesInClass/$numOfStudentsInClass) * 100;

        $result = [];
        $color_array = array('#00c0ef','green','#0073b7','#3c8dbc','#00a65a','#dd4b39');
        
        $array1 = array('num'=>$numOfStudentsInClass,'label'=>'Male', 'data'=>$percentage_male, 'color'=> $color_array[array_rand($color_array,1)]);
        $array2 = array('num'=>$numOfStudentsInClass,'label'=>'Female', 'data'=>$percentage_female, 'color'=> $color_array[array_rand($color_array,1)]);

        $result[]= $array1;
        $result[]= $array2;
        
        return json_encode($result);
    }
    public function stat()
    {
        $classes = TheClass::all();
        $totalNumOfStudents = Student::count();
        $result = [];
        $color_array = array('#00c0ef','green','#0073b7','#3c8dbc','#00a65a','#dd4b39');
        foreach ($classes as $class)
        {
            $numOfStudentsInClass = $class->getNumberOfStudents();
            $percentage = ($numOfStudentsInClass / $totalNumOfStudents) * 100;
            $array = array('num'=>$numOfStudentsInClass,'label'=>$class->name.' '.$class->section, 'data'=>$percentage, 'color'=> $color_array[array_rand($color_array,1)]);

            $result[]= $array;
        }
        return json_encode($result);
    }
    public function index()
    {
        //$classes = DB::select('select name from the_classes GROUP BY name');
        $classes = TheClass::all();
        return view('class.index', compact('classes'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $class = new TheClass(array(
            'name' => $request->get('name')
        ));
        $class->save();
        return redirect()->route('classes')->with('status', 'Class successfully created');

    }
    public function delete($id)
    {
        $this->validate($request, [
            'id' => 'required|integer|max:255',
        ]);
        $class = TheClass::whereId($id)->firstOrFail();
        $class->delete();
        return redirect()->route('classes')->with('status', 'The class has been deleted!');
    }

    public function edit($id)
    {
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $classes = TheClass::all();
        $class = TheClass::whereId($id)->firstOrFail();
        $edit = array('editmode'=>'true');
        return view('class.index', compact('classes', 'class', 'edit'));
    }

    public function update(Request $request, $id)
    {        
        $array = array('id'=>$id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
        ])->validate();
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $class = TheClass::whereId($id)->firstOrFail();
        $class->name = $request->get('name');
        $class->save();
        return redirect()->route('classes')->with('status', 'Class details Successfully updated');
    }
    public function view($id, $section_id)
    {
        $array = array('id'=>$id,'section_id'=>$section_id);
        Validator::make($array, [
            'id' => 'required|integer|max:10',
            'section_id' => 'required|integer|min:1',
        ])->validate();

        $class = TheClass::find($id);
        $section = Section::find($section_id);
        
        $subjects = Subject::where('class_id',$id)->get();

        if ($subjects->count() < 1) return back()->with('status','There is no information for '.$class->name.' ('.$section->name.') yet');


        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $assignments = Assignment::where('section_id', $section_id)->where('year', $current_year)->where('term', $current_term)->get();


        // get statistics for best and least performing student in class
        $students = HomeController::thestat(FALSE, $class->id, $section->id);
        $student_low = $students['student_low'];
        $student_high = $students['student_high'];
        

        return view( 'class.view', compact('subjects', 'assignments', 'class','section', 'student_low', 'student_high') );
    }
    public function search(Request $request)
    {
        $classes = TheClass::all();
        $sections = Section::all();
        return view('class.search', compact('classes', 'sections'));
    }
}

