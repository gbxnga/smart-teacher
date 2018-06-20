@extends('layouts.theapp')

@section('title')
Create Mark - {{config('app.name')}}
@endsection
@section('content')


<div class="content-wrapper" style="min-height: 681px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> Examinations <small></small> </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            @if (session('status'))
                <div class="col-md-12"><div class="callout callout-success">
                    {{ session('status') }}
                </div></div>
            @endif
            <?php
            if (isset($edit) && !empty($edit)){
                if ($edit['editmode'] === 'true')
                $editmode = true;
                else
                $editmode = false;
            }else {$editmode = false;}
            ?>

            <div class="col-md-12">

                <!-- general form elements -->

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
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
                                                     value="{!! $class->id !!}">{!! $class->name !!}</option>
                                                
                                            @endforeach

                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                                <label>Section</label>
                                                <select id="section_id" name="section_id" class="form-control">
                                                @foreach($sections as $section)
                                                
                                                    <option
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($section['id'] === $sec['id'])
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                    value="{!! $section->id !!}">{!! $section->name !!}</option>
                                                
                                                @endforeach                                              
                                            </select>

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
                <?php
                if ($editmode){

                ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Record Marks</h3>
                        <br/>
                        <?php 
                        if (isset($marks) && !empty($marks)){
                            echo '<div style="margin-top:15px" class="callout callout-success">Student marks for this exam in this class are already recorded. You are now editing them</div>';
                        }
                        ?>

                    </div>
                    <div class="box-body">
                        <form role="form" class="addschedule-form"
                        <?php 
                        if (isset($marks) && !empty($marks)){
                        ?>
                            action="{{route('marks.update')}}"
                        <?php
                        }else{
                        ?>
                            action="{{route('marks.save')}}"
                        <?php
                        }
                        ?> method="post" novalidate="novalidate">
                            <input type="text"
                                        <?php
                                            if ($editmode)
                                            {
                                                echo 'value="'.$request->exam. '"';
                                            }
                                        ?>
                                         name="exam" hidden="hidden">
                            <input hidden="hidden" type="text" name="class_id" value="<?= $request->class_id;?>">
                            <input hidden="hidden" type="text" name="section_id" value="<?= $request->section_id;?>">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="table-responsive">
                            @if ($students->count()>0)
                                @if ($subjects->count()>0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Photo </th>
                                            <th> Student </th>
                                            @foreach ($subjects as $subject)
                                                        <th> {{$subject->name}} </th>
                                            
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($students as $student)
                                        <tr>
                                            <td>
                                                <div class="form-group"><img style="border-radius:70%" src="{{url('/images/')}}/{{$student->image}}" width="40" height="40"/> </div>
                                            </td>
                                             <td>
                                                <div class="form-group">{{$student->getFullname()}} </div>
                                            </td>
                                            @foreach ($subjects as $subject)
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                if (isset($marks) && !empty($marks)){
                                                                    ?>
                                                                    <?php $update=false;?>
                                                                    @foreach ($marks as $mark)
                                                                    @if (($subject->id == $mark->subject_id) && ($student->id == $mark->student_id) )
                                                                    <?php $update = true;?>
                                                                        <input type="text" name="mark_{{$subject->id}}_{{$student->id}}_{{$mark->id}}" class="form-control sandbox-container" id="" value="{{$mark->mark}}" placeholder="Enter Mark">
                                                                    @endif
                                                                    @endforeach
                                                                <?php
                                                                // if new subjects have been assigned after some subjects 
                                                                // have been scheduled for exams already
                                                                if (!$update) echo '<input type="text" name="mark_'.$subject->id.'_'.$student->id.'" class="form-control sandbox-container" id="" value="0" placeholder="Enter Mark">';
                                                                } // end if isset marks 
                                                                else{ 
                                                                ?>
                                                                    <input type="text" name="mark_{{$subject->id}}_{{$student->id}}" class="form-control sandbox-container" id="" value="0" placeholder="Enter Mark">
                                                                <?php 
                                                                } // end else
                                                                ?>
                                                                
                                                            </div>
                                                        </td>
                                            
                                            @endforeach
                                            
                                            
                                            
                                        </tr>
                                        @endforeach

                                        
                                    </tbody>

                                </table>
                                
                            </div>
                            <button type="submit" class="btn btn-success save_form pull-right" name="submit">Submit</button>
                            @else
                                        <div style="margin-top:15px" class="callout callout-danger">No Subject Registered in this class yet</div>
                            @endif
                            @else
                                        <div style="margin-top:15px" class="callout callout-danger">No Student Registered in this class yet</div>
                            @endif
                        </form>

                    </div>
                    <!--./end box-body-->
                </div>
                <?php
                    
                    
                }
                ?>
            </div>

            <!-- right column -->

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>

@endsection