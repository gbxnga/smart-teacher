<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use App\Push;
use Auth;
use Carbon\Carbon;
use App\User;

class CronController extends Controller
{
    public function index()
    {
        //$user = Auth::user(); 
        $dt = Carbon::now("Africa/Lagos");
        $day = $dt->format('l');
        
        $timetables = Timetable::where('day_name', $day)->whereNotNull('start_time')->whereNotNull('end_time')->get();
        $users = User::all();
        if ($users->count()>0)
        {
            foreach($users as $user)
            {
               PushController::send($user->id, "Morning! You have {$timetables->count()} classes today."); 
            }
        }
        //PushController::send($user->id, "Morning! You have {$timetables->count()} classes today.");
    }

    public function timetable()
    {
        $user = Auth::user(); 
        $dt = Carbon::now("Africa/Lagos");
        $day = $dt->format('l');
        $timetables = Timetable::where('day_name', $day)->get(); 

        $current_time = $dt->format('h:i A');
        $current_time_plus_10minutes = $dt->addMinutes(10)->format('h:i A');
                 
        foreach($timetables as $timetable)
        {
            if ($timetable->start_time == $current_time)
                // class starts now 
                PushController::send($user->id, "You have {$timetable->getSubjectName()} in {$timetable->getClassName()}({$timetable->getSectionName()}) Now!");
            else if ($timetable->start_time == $current_time_plus_10minutes)
                // class starts in 10 minutes
                PushController::send($user->id, "You have {$timetable->getSubjectName()} in {$timetable->getClassName()}({$timetable->getSectionName()}) 10 minutes!");
        }   

    }
}
