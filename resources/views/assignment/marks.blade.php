@extends('layouts.theapp')

@section('title')
Assignment Grade - {{config('app.name')}}
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Assignments
        <small>Grades</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('assignment.create')}}">Assignments</a></li>
        <li class="active">View Assignment</li>
      </ol>
    </section>

    <!-- Main content -->
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
        <div class="col-xs-12">

          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Assignment Grades - <strong>Class: </strong>{{$class->name}} ({{$assignment->getSectionName()}}) </h3><hr/>
              <p><strong>Topic: </strong>{{$assignment->getSubtopic()}}, <strong>Subject:</strong>{{$assignment->getSubject()}} </p>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Mark</th>
                    <th>Grade</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($students as $student)
                <tr>
                  <td><img width="50" height="40" class="img-responsive img-circle" src="{{url('/images/')}}/{{$student->image}}" alt="User profile picture">
                        </td>
                  <td><a href="{{action('StudentController@show',$student->id)}}">{{$student->firstname}} {{$student->lastname}}</a></td>
                  <td>
                  <?php $mk = 0;?>
                      @foreach ($grades as $grade)
                      
                        @if ($grade->student_id == $student->id)
                            
                            {{$grade->mark}}
                            <?php $mk = $grade->mark;?>
                        @endif
                      @endforeach
                  </td>
                  <td>
                  <?php
                  $percentage = ($mk/$assignment->max)*100;
                  switch($percentage)
                  {
                    case ($percentage<=30):
                      $color = "danger";
                      break;
                    case ($percentage>30 && $percentage <50):
                      $color = "warning";
                      break;
                    case ($percentage>=50 && $percentage <70):
                      $color = "primary";
                      break;
                    case ($percentage>=70):
                      $color = "success";
                      break;
                    default:
                      $color = "info";
                  }
                  ?>  
                  <span  class="btn btn-<?=$color;?> btn-sm">
                    <?php
                      
                      echo number_format((float)$percentage, 1, '.', '') ."%";
                    ?>
                  </span></td>
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Mark</th>
                    <th>Grade</th>
                </tr>
                </tfoot>
              </table>
              <a class="btn btn-success pull-right" href="{{route('assignment.mark.edit', $assignment->id)}}">EDIT MARKS</a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection