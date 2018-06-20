@extends('layouts.theapp')
@section('title')
SmartTeacher - {{Auth::user()->name}}
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Homepage </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Donut chart -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Students</h3>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <p style="font-family: 'Raleway' !important;" ><i class="fa fa-users text-default"></i> {{App\Student::count()}} Students</p>
                        <div id="donut-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body-->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="box box-success">
                <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Least Performing Student this week</h3>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('images/') }}/{{ $student_low->image }}" height="100" alt="User profile picture">

                    <h3 class="profile-username text-center">{{$student_low->name}}</h3>

                    <p class="text-muted text-center">{{$student_low->class}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                        <b>Average Score</b> <a class="pull-right">{{ number_format((float)$student_low->avg_score, 1, '.', '')}}</a>
                        </li>
                        <li class="list-group-item">
                        <b>Lowest Score</b> <a class="pull-right">{{$student_low->lowest_score}}</a>
                        </li>
                    </ul>
                    <div class="description-block border-right">
                    <!--<span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">PERCENTAGE PASS</span>-->
                  </div>

                    <a href="{{route('student.profile', $student_low->id)}}" class="btn btn-success btn-block"><b>View Profile</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="box box-success">
                <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>

                        <h3 class="box-title">Best Performing Student this week</h3>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body box-profile">
                    <?php //print_r($student_high);var_dump($student_high);exit();?>
                    <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('images/') }}/{{ $student_high->image }}" height="100" alt="User profile picture">
                    
                    <h3 class="profile-username text-center">{{$student_high->name}}</h3>

                    <p class="text-muted text-center">{{$student_high->class}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                        <b>Average Score</b> <a class="pull-right">{{ number_format((float)$student_high->avg_score, 1, '.', '')}}</a>
                        </li>
                        <li class="list-group-item">
                        <b>Highest Score</b> <a class="pull-right">{{$student_high->highest_score}}</a>
                        </li>
                    </ul>
                    <div class="description-block border-right">
                    <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">PERCENTAGE PASS</span>-->
                  </div>

                    <a href="{{route('student.profile', $student_high->id)}}" class="btn btn-success btn-block"><b>View Profile</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
            <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Classes Today <?=date('Y-m-d');?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Subject</th>
                  <th>Class</th>
                  <th><span class="fa fa-clock-o"></span> Time</th>
                  <?php $count=1;?>
                @foreach ($timetables as $timetable)
                
                
                </tr>
                <td>{{$count}}</td>
                <td >{{$timetable->getSubjectName()}}</td>
                <td>{{$timetable->getClassName()}} ({{$timetable->getSectionName()}})</td>
                <td class="text-success">{{$timetable->start_time}} - {{$timetable->end_time}}</td>
                </tr>
                <?php $count++;?>
                
                @endforeach

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
