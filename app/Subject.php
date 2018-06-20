<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    public function getClassName()
    {
        if (!$this->class_id) return "None";
        $class = TheClass::find($this->class_id);
        return $class->name.' '.$class->section ;
    }
    public function getNumberOfAssignmentsForClass($class_id, $section_id)
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        $assignments = Assignment::where('subject_id', $this->id)->where('section_id', $section_id)->where('year', $current_year)->where('term', $current_term)->get();
        $count=0;
        foreach ($assignments as $assignment)
        {
            if ($assignment->belongsToClass($class_id)) $count++;
        }
        return $count;
    }

    public function getNumberOfAssignments()
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        return Assignment::where('subject_id', $this->id)->where('year', $current_year)->where('term', $current_term)->get()->count();
    }
    public function getNumberOfAssignmentsForClasss($id)
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        return Assignment::where('subject_id', $this->id)->where('year', $current_year)->where('term', $current_term)->get()->get()->count();
    }
}
