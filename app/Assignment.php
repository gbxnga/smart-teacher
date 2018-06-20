<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = ['id'];

    public function getClass()
    {
        if (!$this->class_id || $this->class_id == NULL) return "None";
        $class = TheClass::find($this->class_id);
        if (!$class) return "None";
        return $class->name;
    }
    public function getSubject($without = false)
    {
        $subject = Subject::find($this->subject_id);
        $class_name = $subject->getClassName();
        if ($without) return $subject->name;
        else return $subject->name.' - '.$class_name;
    }
    public function getSubtopic()
    {
        $subtopic = Subtopic::find($this->subtopic_id);
        return $subtopic->description;
    }

    public function getStudentMarks($id)
    {
        return AssignmentMark::where([
                ['assignment_id', '=', $this->id],['student_id','=',$id]]
            )->get(['mark']);
    }
    public function getSectionName()
    {
        if (!$this->section_id || $this->section_id == NULL || empty($this->section_id)) return "None";
        $section = Section::find($this->section_id);
        if (!$section) return "None";
        return $section->name;
    }

    public function belongsToClass($class_id)
    {
        // look for the subject 
        $subject = Subject::find($this->subject_id);

        // grab class id and check
        if ($subject->class_id == $class_id)
        return true;
        else return false;
        /*$class = TheClass::find($class_id);
        if (!$class) return false;

        if ($class_id == $class->id) return true;
        else return false;*/

    }
}
