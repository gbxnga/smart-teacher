<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheClass extends Model
{
    protected $guarded = ['id'];

    public function getNumberOfStudents()
    {
        return Student::where('class_id',$this->id)->get()->count();
    }
    public function getNumberOfStudentsInSection($section_id)
    {
        // return $this->hasMany('App\Student', 'class_id')->where('section_id', $section_id)->count();
        return Student::where('class_id',$this->id)->where('section_id', $section_id)->get()->count();
    }
}
