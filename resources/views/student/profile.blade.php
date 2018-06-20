@extends('layouts.theapp')

@section('title')
Student: {{$student->firstname}} {{$student->lastname}} - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper" style="min-height: 681px;">
<section class="content-header">
<h1>
    Student Information
    <small>{{$student->getFullname()}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('student.register')}}"><i class="fa fa-dashboard"></i>Students</a></li>
    <li class="active">{{$student->getFullname()}}</li>
</ol>
</section>
    <section class="content">
        <div class="row">
        <div class="col-md-12">
        @if (session('status'))
                        <div class="callout callout-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (count($errors) > 0) 
                        @foreach ($errors->all() as $error)

                            <div class="alert alert-danger">{{ $error }}</div>

                        @endforeach 
                    @endif
                    </div>
            <!-- /.col -->
            <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">{{$student->firstname}} {{$student->lastname}}</h3>
                <h5 class="widget-user-desc">Student</h5>
                </div>
                <div class="widget-user-image">
                <img class="img-circle" src="{{url('/images/')}}/{{$student->image}}" alt="User Avatar">
                </div>
                <div class="box-footer">
                <div class="row">
                    <div class="col-xs-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">{{$student->gender}}</h5>
                        <span class="description-text">GENDER</span>
                    </div>
                    <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">
                        {{$student->getClassName()}}</h5>
                        <span class="description-text">CLASS</span>
                    </div>
                    <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                    <div class="description-block">
                        <h5 class="description-header">{{$student->getAge()}} years</h5>
                        <span class="description-text">DOB</span>
                    </div>
                    <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
                        <!-- LINE CHART -->
                        <div class="box box-success">
                            <div class="box-header with-border">
                            <h4 class="box-title">Performance By Subject over months</h4>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            </div>
                            <div class="box-body">
                            <div><p>
                                @foreach ($stats as $stat)
                                <?php $theSubject = App\Subject::find($stat['subject_id']);?>
                                                <i class="fa fa-circle-o text-{{$stat['fillColor']}}"></i> {{$theSubject->name}} 
                                @endforeach
                            </p></div>
                                           
                            <div class="chart">
                                <canvas id="lineChart" style="height:250px"></canvas>
                            </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class=""><a href="#overview" data-toggle="tab" aria-expanded="true">Overview</a></li>
                        <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Profile</a></li>
                        <li class="active"><a href="#attendance" data-toggle="tab" aria-expanded="false">Attendance</a></li>
                        <!--<li class=""><a href="#analysis" data-toggle="tab" aria-expanded="false">Analysis</a></li>-->
                        <li class=""><a href="#comments" data-toggle="tab" aria-expanded="false">Comments</a></li>
                        <!--<li class=""><a href="#exam" data-toggle="tab" aria-expanded="false">Exam</a></li>
                        <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false">Documents</a></li>-->
                        <li class="pull-right"><a href="{!! action('StudentController@delete', $student->id) !!}" class="text-red" onclick="return confirm('Are you sure you want to delete this Student? All related data can not be recovered!');"><i class="fa fa-trash"></i> Delete Student</a></li>
                        <li class="pull-right">
                             <a class="btn btn-success pull-right text-blue" href="{!! action('StudentController@edit_form', $student->id) !!}" title=""><i class="fa fa-pencil"></i>
                                Edit details</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="attendance">
                            <div class="row">
                                <div class="col-md-12">
                                
                                    <!-- BAR CHART -->
                                    <div class="box box-success" style="margin-top:30px">
                                        <div class="box-header with-border">
                                        <h3 class="box-title">Calendar</h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                        </div>
                                        <div class="box-body chart-responsive">
                                        <div id="calendar"></div>

                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                    <!-- BAR CHART -->
                                    <div class="box box-success" style="margin-top:30px">
                                        <div class="box-header with-border">
                                        <h3 class="box-title">Bar Chart</h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                        </div>
                                        <div class="box-body chart-responsive">
                                        <p><i class="fa fa-circle-o text-green"></i> Present  <i class="fa fa-circle-o text-red"></i> Absent
                                         <i class="fa fa-circle-o text-yellow"></i> Late   <i class="fa fa-circle-o text-blue"></i> Late with Excuse</p>
                                        <div class="chart" id="bar-chart" style="height: 300px;"></div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <div class="col-md-6">
                                    
                                
                                </div>
                        </div>
                            
                        </div>
                        <div class="tab-pane" id="analysis">
                       
                        
                        <div class="box box-primary">
                            <div class="box-header with-border">
                            <h3 class="box-title">Area Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            </div>
                            <div class="box-body">
                            <div class="chart">
                                <canvas id="areaChart" style="height:250px"></canvas>
                            </div>
                            </div>
                            
                        </div>
                       


                        </div>
                        <div class="tab-pane" id="comments">
                            <div class="row"><div class="col-md-12">
                            <strong><i class="fa fa-file-text-o margin-r-5"></i> Comments</strong>
                            @foreach ($comments as $comment)

                            <hr/>
                            <p class="callout callout-success">{{$comment->comment}} <span class="pull-right">
                                                    <a href="{{route('student.comment.delete', $comment->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip " title="Delete" onclick="return confirm( 'Are you sure you want to delete this item?'); ">
                                                        <i class="fa fa-remove "></i>
                                                    </a>
                            </span></p>
                            @endforeach
                            </div>

                            <hr/>
                            <div class="col-md-12">
                                <h4>Add Comment</h4>
                                <form method="post" action="{{route('student.comment', $student->id)}}">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <textarea class="col-md-12 col-xs-12" style="padding:15;outline:none;border:1px solid #333333" name="comment"></textarea>
                                <button type="submit" style="margin-top:15px" class="btn btn-success brn-sm pull-right">ADD COMMENT</button>
                            </form>
                            </div>
                        </div>

                        </div>
                        <div class="tab-pane" id="overview">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="box-success">
                                        <div class="box-header">
                                            <h3 class="box-title">Attendance Overview for the week</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div>
                                                <?php $attendance_week = json_decode($student->getAttendanceForTheWeek());?>
                                                <p><i class="fa fa-circle-o text-green"></i> Present(<strong>{{$attendance_week->present}}</strong>)  <i class="fa fa-circle-o text-red"></i> Absent(<strong>{{$attendance_week->absent}}</strong>)
                                         <i class="fa fa-circle-o text-yellow"></i> Late(<strong>{{$attendance_week->late}}</strong>)   <i class="fa fa-circle-o text-blue"></i> Late with Excuse(<strong>{{$attendance_week->late_excuse}}</strong>)</p>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                    <div class="box-success">
                                        <div class="box-header">
                                            <h3 class="box-title">Recently Graded</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body no-padding">
                                            <table class="table table-striped">
                                                <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Task</th>
                                                <th>Due</th>
                                                <th style="width: 40px">Score</th>
                                                </tr>
                                                <?php $theassignments = json_decode($theassignments);?>
                                                
                                                    @foreach ($theassignments as $indexKey => $ass)
                                                    <tr>
                                                    <td>{{$indexKey+1}}</td>
                                                    <td><?= $ass->description; ?></td>
                                                    <td>
                                                        <?= $ass->subject;?>
                                                    </td>
                                                    <td> {{$ass->mark}}/{{$ass->max}}</td>
                                                    </tr>
                                                    @endforeach
                                                
                                                
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="tab-pane" id="activity">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Date Of Birth</td>
                                            <td>{{$student->date_of_birth}} </td>
                                        </tr>
                                        <tr>
                                            <td>Category</td>
                                            <td>
                                                General
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mobile Number</td>
                                            <td>{{$student->mobileno}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h3>Address </h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Current Address</td>
                                            <td>{{$student->current_address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Permanent Address</td>
                                            <td>{{$student->current_address}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h3>Parent / Guardian Details </h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="col-md-4">Father Name</td>
                                            <td class="col-md-5">{{$student->father_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Father Phone</td>
                                            <td>{{$student->father_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Father Occupation</td>
                                            <td>{{$student->father_occupation}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother Name</td>
                                            <td>{{$student->mother_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother Phone</td>
                                            <td>{{$student->mother_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother Occupation</td>
                                            <td>{{$student->mother_occupation}}</td>
                                        </tr>
                                        <tr>
                                            <td>Guardian Name</td>
                                            <td>{{$student->guardian_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Guardian Relation</td>
                                            <td>{{$student->guardian_relation}}</td>
                                        </tr>
                                        <tr>
                                            <td>Guardian Phone</td>
                                            <td>{{$student->guardian_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Guardian Occupation</td>
                                            <td>{{$student->guardian_occupation}}</td>
                                        </tr>
                                        <tr>
                                            <td>Guardian Address</td>
                                            <td>{{$student->guardian_address}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>

@endsection