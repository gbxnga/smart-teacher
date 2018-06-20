@extends('layouts.theapp')

@section('title')
Timetable - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper" style="min-height: 717px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> Academics <small></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
        <?php
            if (isset($edit) && !empty($edit)){
                $editmode = true;
            }else {$editmode = false;}
            ?>
            <div class="col-md-12">
            @if (session('status'))
                        <div class="callout callout-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (count($errors) > 0) 
                        @foreach ($errors->all() as $error)

                            <div class="callout callout-danger">{{ $error }}</div>

                        @endforeach 
                    @endif
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <form action="{{action('TimetableController@timetable_form')}}" method="post" accept-charset="utf-8">
                        <div class="box-body">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">                            
                        <div class="row">
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Class</label>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($classes as $class)
                                                <option 
                                                <?php
                                                if ($editmode)
                                                {
                                                    if ($clas->id == $class->id) echo 'selected="selected" ';
                                                }
                                                ?>
                                                value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                          </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($sections as $section)
                                                <option 
                                                <?php
                                                if ($editmode)
                                                {
                                                    if ($sec->id == $section->id) echo 'selected="selected" ';
                                                }
                                                ?>
                                                value="{{$section->id}}">{{$section->name}}</option>
                                            @endforeach
                                        
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subject</label>
                                        <select id="subject_id" name="subject_id" class="form-control">
                                        @foreach ($subjects as $subject)
                                                <option 
                                                <?php
                                                if ($editmode)
                                                {
                                                    if ($sub->id == $subject->id) echo 'selected="selected" ';
                                                }
                                               
                                                ?>
                                                value="{{$subject->id}}">{{$subject->name}} {{$subject->getClassName()}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">Search</button>
                        </div>
                    </form>
                </div>
                @if ($editmode)
                <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i> Class Timetable</h3>
                            @if ($records->count()>0)
                            <div style="margin-top:15px" class="callout callout-info">Timetable for this class and subject already saved. You are now editing</div> 
                            @endif
                        </div>
                        <div class="box-body">
                            <form role="form"
                            @if ($records->count()>0)
                                action="{{route('timetable.update')}}"
                            @else
                                action="{{route('timetable.create')}}"
                            @endif
                             class="addmarks-form" method="post" >
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                                <input type="hidden" name="subject_id" value="{{$request->subject_id}}"> 
                                <input type="hidden" name="class_id" value="{{$request->class_id}}"> 
                                <input type="hidden" name="section_id" value="{{$request->section_id}}">                                    
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Day   </th>
                                                    <th>
                                                        Start Time  </th>
                                                    <th>
                                                        End Time  </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <th>
                                                            Monday                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="stime_Monday" class="form-control timepicker" id="stime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Monday")
                                                                                    value="{{$record->start_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">10</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="etime_Monday" class="form-control timepicker" id="etime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Monday")
                                                                                    value="{{$record->end_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Tuesday                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="stime_Tuesday" class="form-control timepicker" id="stime_" 
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Tuesday")
                                                                                    value="{{$record->start_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">10</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="etime_Tuesday" class="form-control timepicker" id="etime_"  
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Tuesday")
                                                                                    value="{{$record->end_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Wednesday                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="stime_Wednesday" class="form-control timepicker" id="stime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Wednesday")
                                                                                    value="{{$record->start_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">10</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="etime_Wednesday" class="form-control timepicker" id="etime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Wednesday")
                                                                                    value="{{$record->end_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Thursday                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="stime_Thursday" class="form-control timepicker" id="stime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Thursday")
                                                                                    value="{{$record->start_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">10</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="etime_Thursday" class="form-control timepicker" id="etime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Thursday")
                                                                                    value="{{$record->end_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Friday                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">09</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="stime_Friday" class="form-control timepicker" id="stime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Friday")
                                                                                    value="{{$record->start_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="bootstrap-timepicker"><div class="bootstrap-timepicker dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">10</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">AM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" name="etime_Friday" class="form-control timepicker" id="etime_"
                                                                        @if ($records->count()>0)
                                                                            @foreach($records as $record)
                                                                                @if ($record->day_name == "Friday")
                                                                                    value="{{$record->end_time}}"
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            value=""
                                                                        @endif
                                                                        
                                                                        >
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    
                                                 </tbody>
                                        </table>
                                    </div>
                                    <button type="submit" class="btn btn-success pull-right" name="save_exam" value="save_exam">Save</button>
                                </form>
                            </div>
                    </div>
                </div> 
                @endif
            </div> 
                </section>
</div>
@endsection