<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $guarded = ['id'];
    public function getClass()
    {

        $class = TheClass::find($this->class_id);
        if (!$class) return "None";
        return $class->name.' '.$class->section ;
    }
    public function getSubject()
    {
        $subject = Subject::find($this->subject_id);
        $class_name = $subject->getClassName();
        return $subject->name.' - '.$class_name;
    }
}
