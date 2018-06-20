<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    protected $guarded = ['id'];

    public function getNumberOfAssignments()
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        return Assignment::where('subtopic_id',$this->id)->where('year', $current_year)->where('term', $current_term)->get()->count();
    }

    public function getAssignments()
    {
        $settings = Settings::all()->first();
        $current_year = $settings->year;
        $current_term = $settings->term;
        return Assignment::where('subtopic_id',$this->id)->where('year', $current_year)->where('term', $current_term)->get();
    }
}
