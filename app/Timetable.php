<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $guarded = ['id'];

    public function getSubjectName()
    {
        $subject = Subject::find($this->subject_id);
        return $subject->name;
    }
    public function getClassName()
    {
        $class = TheClass::find($this->class_id);
        if (!$class) return "None";
        return $class->name;
    }
    public function getSectionName()
    {
        $section = Section::find($this->section_id);
        if (!$section) return "None";
        return $section->name;
    }

}
