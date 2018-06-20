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
        <small>Grade</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('assignment.create')}}">Assignments</a></li>
        <li class="active">Grade Assignments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php
          if (isset($edit) && !empty($edit))
              $editmode = true;
          else 
              $editmode = false;
        ?>
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
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Mark</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($students as $student)
                <tr>
                  <td><img width="40" height="30" class="img-responsive img-circle" src="{{url('/images/')}}/{{$student->image}}" alt="User profile picture">
                      </td>
                  <td><a href="{{action('StudentController@show',$student->id)}}">{{$student->firstname}} {{$student->lastname}}</a></td>
                  <td><input style="width:70;margn-left:0px"
                  <?php
                    if ($editmode)
                    {
                      foreach($marks as $mark)
                      {
                        if ($mark->student_id == $student->id)
                          echo 'value="'.$mark->mark.'"';
                      }
                    }
                  ?>
                  name="mark_{{$student->id}}" max="{{$assignment->max}}" min="{{$assignment->min}}"  type="number"/></td>
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Mark</th>
                </tr>
                </tfoot>
              </table>

              <button type="submit" class="btn btn-success pull-right">
              <?php
                    if ($editmode)
                    {
                      echo 'UPDATE MARKS';
                    }
                    else
                    {
                      echo 'SAVE MARKS';
                    }
              ?></button>
            </form>
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