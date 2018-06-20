<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all();
        return view('school.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'year' => 'bail|required|string|min:4',
            'term' => 'required|integer|min:1',
        ]);
        $term = $request->get('term');
        $year = $request->get('year');

        $settings = Settings::all();
        foreach ($settings as $setting)
        {
            $setting->delete();
        }

        $setting = new Settings(
            [
                'term' => $term,
                'year' => $year,
            ]
        );
        $setting->save();
        return redirect()->back()->with('status','Settings Updated!');
    }
}
