<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    protected $guarded = ['id'];

    public function getAge()
    {
        if (empty($this->date_of_birth)) return '0';
        $dt = \Carbon\Carbon::now();
        $dob =  $this->date_of_birth;
        $dob = explode('/',$dob);
        $dob = \Carbon\Carbon::create($dob[2], $dob[0], $dob[1]);
        return $age = $dt->diffInYears($dob); 
    }

    public function getClassName()
    {
        $class = TheClass::find($this->class_id);
        $section = Section::find($this->section_id);

        return $class->name.' ('.$section->name.')';
        // return $this->class_id.' '.$this->section_id;
    }

    public function getFullname()
    {
        return $this->firstname.' '.$this->lastname;
    }
    public function getAttendanceForTheWeek()
    {
        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        $attendances =  Attendance::where('student_id', $this->id)
                                  ->where('attendance_date','<', $week_end)
                                  ->where('attendance_date','>', $week_start)
                                  ->get(['type']);

        $present = $late = $absent = $late_excuse = 0;
        foreach($attendances as $attendance)
        {
            if ($attendance->type == 'A') $absent++;
            else if ($attendance->type == 'L') $late++;
            else if ($attendnace->type == 'LE') $late_excuse++;
        }

        $present = 5 - $late - $absent - $late_excuse;

        return json_encode(array('present'=>$present, 'absent'=>$absent, 'late'=>$late, 'late_excuse'=>$late_excuse));
    }

    public function getSubjectAvg($subject_id)
    {
        // get his class
        $class = TheClass::whereId($this->class_id)->firstOrFail();

        // use the id to get all assignment
        // for that class
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $assignments = Assignment::where('section_id', $this->section_id)->where('subject_id', $subject_id)->where('year', $current_year)->where('term', $current_term)->get();

        // check marks if there are results for 
        // that assignment for this student
        $total = 0;
        $count = 0;
        foreach ($assignments as $assignment)
        {
            // all assignments in the section
            
            if ($assignment->belongsToClass($class->id))
            {
                // all assignments in the class

                $percentage = 0;
            
                $marks = AssignmentMark::where([['assignment_id','=',$assignment->id],['student_id','=',$this->id]])->get(['mark']);

                $marks = json_decode(json_encode($marks), true);
                foreach ($marks as $mark)
                {
                    $percentage = ($mark['mark']/$assignment->max)*100;
                    $total += $percentage; 
                    $count++;
                }
                            

            }

        }
        if ($count==0) return 0;
        $average = $total/$count;

        return number_format((float)$average, 1, '.', '') ."%";;
    }
}
