@extends('layouts.theapp')

@section('title')
View Class - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

<section class="content-header">
<h1>
    Class
    <small>{{$class->name}} ({{$section->name}})</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('class.search')}}"><i class="fa fa-dashboard"></i> Select Class</a></li>
    <li class="active">{{$class->name}} ({{$section->name}})</li>
</ol>
</section>


    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6 hidden-xs hidden-sm">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Class</span>
                <span class="info-box-number">{{$class->name}} ({{$section->name}})</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-6 hidden-xs hidden-sm">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Subjects</span>
                <span class="info-box-number">{!! App\Subject::where('class_id', $class->id)->count() !!} </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12 hidden-xs hidden-sm">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Students</span>
                <span class="info-box-number">{{$class->getNumberOfStudentsInSection($section->id)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12 hidden-xs hidden-sm">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Assignments</span>
                <span class="info-box-number">
                <?php $count=0; //json_decode($assignments);print_r($assignments);exit();?>
                 @foreach($assignments as $assignment)
                 @if ($assignment->belongsToClass($class->id))
                 <?php $count++;?>
                 @endif
                 @endforeach
                <?=$count;?>
                </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">  
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
            </div>
        </div>     
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">              
                        
                    </div>
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Subjects for {{$class->name}} ({{$section->name}})</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                            <table class="table table-condensed">
                                
                                <tr>
                                <th style="width: 10px">#</th>
                                <th>subject</th>
                                <th style="width: 40px">Assignments</th>
                                <th style="width: 40px">Performance Analysis</th>
                                </tr>
                                <tr>
                                @foreach ($subjects as $indexKey=>$subject)
                                <td>{{$indexKey+1}}</td>
                                <td>{{$subject->name}}</td>
                                <td><span class="badge bg-red">{{$subject->getNumberOfAssignmentsForClass($class->id, $section->id)}}</span></td>
                                <td>@if ($subject->getNumberOfAssignmentsForClass($class->id,$section->id)>0)<a href="{{route('assignment.performance', [$subject->id, $section->id])}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="View Analysis">
                                                                    <i class="fa fa-bar-chart"></i>
                                                                </a>@endif </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="col-md-12"> 

                        <div style="display:none" class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Subject Details</h3>
                            </div> 
                            <div class="box-body">
                                <strong><i class="fa fa-book margin-r-5"></i>Subjects</strong>

                                <p class="text-muted">
                                {!! App\Subject::where('class_id', $class->id)->count() !!} 
                                </p>

                                <hr>

                                <strong><i class="fa fa-map-marker margin-r-5"></i> Class</strong>

                                <p class="text-muted">  {{$subject->getClassName()}} ({{$section->name}})</p>


                                <hr>

                                <strong><i class="fa fa-map-marker margin-r-5"></i> Number Of Students</strong>

                                <p class="text-muted">  {{$class->getNumberOfStudentsInSection($section->id)}}</p>

                                <!--<hr>

                                <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                                <p>
                                    <span class="label label-danger">UI Design</span>
                                    <span class="label label-success">Coding</span>
                                    <span class="label label-info">Javascript</span>
                                    <span class="label label-warning">PHP</span>
                                    <span class="label label-primary">Node.js</span>
                                </p>

                                <hr>

                                <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>-->
                                </div> 
                            </div>  
                        </div>
                    </div> 
                    <div class="">
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
                                <p style="font-family: 'Raleway' !important;" ><i class="fa fa-users text-default"></i> {{App\Student::where('class_id', $class->id)->where('section_id', $section->id)->count()}} Students</p>
                                <div id="donut-chart" style="height: 300px;"></div>
                            </div>
                            <!-- /.box-body-->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>


                <div class="col-md-7">
                    <div class="row">
                                    <!-- /.col -->
                        <div class="col-md-6">
                            <!-- Profile Image -->
                            <div class="box box-success">
                            <div class="box-header with-border">
                                    <!--<i class="fa fa-bar-chart-o"></i>-->

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
                            </div>

                                <a href="{{route('student.profile', $student_low->id)}}" class="btn btn-success btn-block"><b>View Profile</b></a>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <!-- Profile Image -->
                            <div class="box box-success">
                            <div class="box-header with-border">
                                    <!--<i class="fa fa-bar-chart-o"></i>-->

                                    <h3 class="box-title">Best Performing Student this week</h3>

                                    <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body box-profile">
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
                            </div>

                                <a href="{{route('student.profile', $student_high->id)}}" class="btn btn-success btn-block"><b>View Profile</b></a>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">All Assignments for subjects for {{$class->name}} ({{$section->name}})</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                    <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive mailbo-messages">
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-striped table-bordered table-hover example dataTable no-footer">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Description </th>
                                                            <th>Topic </th>
                                                            <th>Subject </th>
                                                            <th class="text-right sorting">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $count=1; //json_decode($assignments);print_r($assignments);exit();?>
                                                        @foreach($assignments as $indexKey => $assignment)

                                                        @if ($assignment->belongsToClass($class->id))
                                                            <tr role="row" class="odd">
                                                            <td class=""><?= $count;?></td>
                                                            <td>{!! $assignment->description !!}</td>
                                                            <td class="">{!! $assignment->getSubtopic() !!}</td>
                                                            <td class="">{!! $assignment->getSubject()!!}</td>
                                                            <td class="mailbox-date pull-right">                                                
                                                                <a href="{{route('assignment.marks.view', $assignment->id)}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add Marks">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                                <a href="{{route('assignment.edit', $assignment->id)}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                                    <i class="fa fa-pencil "></i>
                                                                </a>
                                                                <a href="{{route('assignment.delete', $assignment->id)}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm( 'Are you sure you want to delete this item?'); ">
                                                                    <i class="fa fa-remove "></i>
                                                                </a>
                                                            </td>
                                                            </tr>  
                                                            <?php $count++;?>
                                                            @endif                                          
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- /.table -->



                                    </div><!-- /.mail-box-messages -->
                                    <div class="box-footer">
                                        <a href="{{route('assignment.create')}}" class="pull-right btn btn-success btn-sm">CREATE ASSIGNMENT</a>
                                    </div>
                                </div><!-- /.box-body -->
                        
                            </div>
                        </div>
                    </div>
                </div><!-- end -->
            </div>
            
        </div>
    </section>

</div>
    
@endsection