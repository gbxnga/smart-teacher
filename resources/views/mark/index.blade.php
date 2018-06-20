@extends('layouts.theapp')
 <?php
            if (isset($edit) && !empty($edit)){
                if ($edit['editmode'] === 'true')
                $editmode = true;
                else
                $editmode = false;
            }else {$editmode = false;}
            ?>
@section('title')
<?php 
if($editmode){
echo $request->exam.' FOR '.$clas['name'].' '.$clas['section'];
}else{
    echo 'View Class Grades';
}
?>

@endsection
@section('content')


<div class="content-wrapper" style="min-height: 681px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> Grade Report <small></small> </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            @if (session('status'))
                <div class="col-md-12"><div class="alert alert-success">
                    {{ session('status') }}
                </div></div>
            @endif
           

            <div class="col-md-12">

                <!-- general form elements -->

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Select Class to view Grade</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <form method="post" accept-charset="utf-8" id="schedule-form">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" name="save_exam" value="search">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Exam Name</label>

                                        <select id="exam" name="exam" class="form-control">
                                            <option value="">Select</option>

                                                    <option value="CA 1"
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($request->exam === 'CA 1')
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                     >CA 1</option>
                                                    <option value="CA 2"
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($request->exam === 'CA 2')
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                     >CA 2</option>

                                                    <option value="EXAM" 
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($request->exam === 'EXAM')
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                    >EXAM</option>
                                                    

                                            </select>
                                        <span class="text-danger"></span>
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Class</label>

                                        <select id="class_id" name="class_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($classes as $class)
                                                
                                                    <option
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($class['id'] === $clas['id'])
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                     value="{!! $class->id !!}">{!! $class->name !!} - {{$class->section}}</option>
                                                
                                            @endforeach

                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                </div>

                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" name="search" value="search" class="btn btn-success btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- right column -->

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>

@endsection