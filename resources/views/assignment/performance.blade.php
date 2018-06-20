@extends('layouts.theapp')

@section('title')
Subject Performance - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

<section class="content-header">
<h1>
    Performance Analysis
    <small>{{$subject->name}} {{$class->name}} ({{$section->name}})</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('class.view', [$class->id, $section->id])}}"><i class="fa fa-dashboard"></i> {{$class->name}} ({{$section->name}})</a></li>
    <li class="active">Subject Analysis</li>
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
        </div>  
        <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Subject Statistics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-xs-4 col-md-4 text-center">
                <?php $total = 0;?>
                    <?php
                    $max = -9999999; $min = 9999999;
                    foreach ($students as $student)
                    {
                        $sub_avg = (float) $student->getSubjectAvg($subject->id);
                        $total += $sub_avg;;
                        if($sub_avg>$max)
                            $max = $sub_avg;
                        if($sub_avg<$min)
                            $min = $sub_avg;
                    }
                   
                    $numberOfStudents = $class->getNumberOfStudentsInSection($section->id);
                    //exit($numberOfStudents.'jl');
                    
                    
            
                    
                    
                    ?>
                  <input id="stdAvg" type="text" class="knob" value="<?php echo round($total/$numberOfStudents);?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#3c8dbc" data-readonly="true">
                    
                    
                    
                  <div class="knob-label">Student Average</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 col-md-4 text-center">
                  <input type="text" class="knob" value="<?=round($max);?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgColor="#00a65a">

                  <div class="knob-label">Highest</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 col-md-4 text-center">
                  <input type="text" class="knob" value="<?=round($min);?>" data-skin="tron" data-thickness="0.1" data-width="90" data-height="90" data-fgColor="#f56954">

                  <div class="knob-label">Lowest</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->    
        <div class="row">
            <div class="col-md-12">
            <div style="border-color:#00a65a" class="box">
            <div class="box-header">
              <h3 class="box-title">Performance table for {{$subject->name}}, Class: {{$class->name}} ({{$section->name}})</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding table-responsive">
              <table id="example1" class="table table-striped">
                <thead>
                    <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th style="width:20px">Performance</th>
                    <th style="width: 30px">Average</th>
                    @foreach ($subtopics as $subtopic)
                        <th class="">{{$subtopic->description}}</th>
                    @endforeach
                    
                    </tr>
                </thead>
                <?php
                function getColor($percentage, $secondType = false)
                {
                    switch($percentage)
                    {
                        case ($percentage<=30):
                        $color = $secondType ? "red" : "danger";
                        break;
                        case ($percentage>30 && $percentage <50):
                        $color = $secondType ? "yellow" :  "warning";
                        break;
                        case ($percentage>=50 && $percentage <70):
                        $color = $secondType ? "blue" :  "primary";
                        break;
                        case ($percentage>=70):
                        $color = $secondType ? "green" :  "success";
                        break;
                        default:
                        $color = "info";
                    }
                    return $color;
                }
                ?>
                
                @foreach ($students as $indexKey => $student)
                
                
                    <tr>
                        <td>{{$indexKey+1}}</td>
                        <td style="white-space:nowrap"><a href="{{route('student.profile', $student->id)}}">{{$student->firstname}} {{$student->lastname}}</a></td>
                        <td>
                            <div class="progress progress-xs">
                                <?php
                                    $stdAvg = $student->getSubjectAvg($subject->id);
                                ?>
                            <div class="progress-bar progress-bar-<?= getColor($stdAvg);?>" style="width: {{$stdAvg}}"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-<?= getColor($stdAvg, true);?>">{{$stdAvg}}</span></td>
                        @foreach ($subtopics as $subtopic)
                            <td style="white-space:nowrap">
                                <?php $asss = $subtopic->getAssignments();?>
                                @foreach ($asss as $ass)
                                    <?php $marks = $ass->getStudentMarks($student->id);?>
                                    
                                    @foreach ($marks as $mark)
                                        <?php
                                        $percentage = ($mark->mark/$ass->max)*100;

                                        ?> 
                                        <span class="btn btn-<?= getColor($percentage);?> btn-sm">
                                            <?=number_format((float)$percentage, 1, '.', '') ."%";?>
                                        </span>
                                    @endforeach
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            </div>
            
            
        </div>

    </section>

</div>
    
@endsection


