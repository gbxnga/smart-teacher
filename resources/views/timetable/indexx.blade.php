@extends('layouts.theapp')

@section('title')
Timetable - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">  
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
                        <h3 class="box-title">
                            <i class="fa fa-search"></i> Select Criteria</h3>
                        <div class="box-tools pull-right">
                            <a href="{{action('TimetableController@form')}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Add Timetable">
                                <i class="fa fa-plus"></i> Add                            </a>
                        </div>
                    </div>

                    <form action="{{route('timetable')}}" method="post" accept-charset="utf-8">
                        <div class="box-body">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">                            
                        <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select id="section_id" name="section_id" class="form-control">
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
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
                @if ($editmode)
                <div style="displa:none"  class="box box-success" id="timetable">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i> Timetable for <stron>{{$clas->name}} ({{$sec->name}})</strong></h3>
                        </div>
                        <div class="box-body">
                            <div class="row print">
                                <div class="col-md-12">
                                    <div class="col-md-offset-4 col-md-4">
                                        <center><b>Class: </b> <span class="cls"></span></center> 
                                    </div>
                                </div>
                            </div>
                                                            <div class="table-responsive">
								<div class="download_label">Class Timetable</div>
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                              
                                              <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                  <label><input type="search" class="" placeholder="Search..." aria-controls="DataTables_Table_0"></label>
                                                </div><table class="table table-bordered example dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <?php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];?>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="
                                                    Subject: activate to sort column descending" style="width: 76px;">
                                                    Subject </th>
                                                    @foreach ($days as $day)
                                                    <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="" style="width: 76px;">
                                                    {{$day}}</th>
                                                    @endforeach
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($subjects as $subject)
                                                                                            
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                                                                
                                                    <tr role="row" class="odd">
                                                        <th class="">{{$subject->name}}</th>
                                                            @foreach ($days as $day)
                                                                @foreach ($timetables as $timetable)
                                                                        @if ($timetable->day_name == $day && $timetable->subject_id == $subject->id)
                                                                
                                                                        <td class="text text-center">
                                                                                <div class="attachment-block clearfix">
                                                                                        <strong class="text-green">{{$timetable->start_time}}</strong>
                                                                                        <b class="text text-center">-</b>
                                                                                        <strong class="text-green">{{$timetable->end_time}}</strong><br>
                                                                                </div>
                                                                        </td>
                                                                        @endif
                                                                    @endforeach
                                                            @endforeach
                                                     </tr>                                                                                                        
                                                                                                        
                                                @endforeach                                                        
                                                </tbody>
                                    </table> </div>
                                </div>
                    </div>
                </div>
                @endif
                <!-- end if editmode -->
            </div>  
                </section>
</div>
@endsection