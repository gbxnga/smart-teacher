@extends('layouts.theapp')

@section('title')
Create Assignment - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Assignments
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Assignments</li>
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
            <?php
            if (isset($edit) && !empty($edit))
                $editmode = true;
            else 
                $editmode = false;
            ?>
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-success">
                    <div class="box-header with-border">
                    <?php
                    if ($editmode)
                        echo '<h3 class="box-title">Edit Assignment</h3>';
                    else
                        echo '<h3 class="box-title">Create Assignment</h3>';
                    ?>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                

                                <div class="col-md-12">
                                <label for="description" class=" control-label">Description</label>
                                    <textarea id="editor1" style="height:200px;width:100%" name="description" placeholder="" class="textarea teform-control" rows="2" required> <?php if ($editmode) echo $assignment->description; ?></textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Subject</label>
                                <select id="get_subtopics_select" name="subject_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($subjects as $subject)
                                    {
                                        <option value="{!! $subject->id !!}"
                                            <?php
                                            if ($editmode)
                                            {
                                                if($assignment->subject_id == $subject->id)
                                                echo 'selected="selected"';
                                            }
                                            ?>   
                                        >
                                            {!! $subject->name !!} ({{$subject->getClassName()}})
                                        </option>
                                    }
                                    @endforeach
                                    </select>
                                    @if ($errors->has('subject_id'))
                                        <span class="text-danger">
                                            <strong>*{{ $errors->first('subject_id') }}*</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Section</label>
                                <select id="section_id" name="section_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($sections as $section)
                                    {
                                        <option value="{!! $section->id !!}"
                                            <?php
                                            if ($editmode)
                                            {
                                                if($assignment->section_id == $section->id)
                                                echo 'selected="selected"';
                                            }
                                            ?>
                                        >
                                            {!! $section->name !!} 
                                        </option>
                                    }
                                    @endforeach
                                    </select>
                                    @if ($errors->has('section_id'))
                                        <span class="text-danger">
                                            <strong>*{{ $errors->first('section_id') }}*</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleInputEmail1">Subtopic</label>
                                <select id="subtopic_id" name="subtopic_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($subtopics as $subtopic)
                                    {
                                        <option value="{!! $subtopic->id !!}"
                                            <?php
                                            if ($editmode)
                                            {
                                                if($assignment->subtopic_id == $subtopic->id)
                                                echo 'selected="selected"';
                                            }
                                            ?>   
                                        >
                                            {!! $subtopic->description !!}
                                        </option>
                                    }
                                    @endforeach
                                </select>
                                @if ($errors->has('subtopic_id'))
                                    <span class="text-danger">
                                        <strong>*{{ $errors->first('subtopic_id') }}*</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Max Point</label>
                                <input
                                <?php
                                if ($editmode)
                                {
                                    echo 'value="'.$assignment->max.'"';
                                }
                                ?>
                                name="max" type="text" class="form-control"/>
                                @if ($errors->has('max'))
                                    <span class="text-danger">
                                        <strong>*{{ $errors->first('max') }}*</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Min Point</label>
                                <input
                                <?php
                                if ($editmode)
                                {
                                    echo 'value="'.$assignment->min.'"';
                                }
                                ?>
                                name="min" type="text" class="form-control"/>
                                @if ($errors->has('min'))
                                    <span class="text-danger">
                                        <strong>*{{ $errors->first('min') }}*</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                        <?php
                        if ($editmode)
                            echo '<button type="submit" class="btn btn-success pull-right">UPDATE ASSIGNMENT</button>';
                        else 
                            echo '<button type="submit" class="btn btn-success pull-right">CREATE ASSIGNMENT</button>';
                        ?>
                        </div>
                    </form>
                </div>

            </div>
            <!--/.col (right) -->

            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">All Assignments</h3>
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
                                            @foreach($assignments as $indexKey => $assignment)
                                                <tr role="row" class="odd">
                                                <td class="">{!! $indexKey+1 !!}</td>
                                                <td>{!! $assignment->description !!}</td>
                                                <td class="">{{$assignment->getSubtopic()}}</td>
                                                <td class="">{{$assignment->getSubject()}} ({{$assignment->getSectionName()}})</td>
                                                <td class="mailbox-date pull-right">                                               
                                                    <a href="{{route('assignment.marks.view', $assignment->id)}}" class="btn btn-default btn-xs " data-toggle="tooltip " title="View Marks">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="{{route('assignment.edit', $assignment->id)}}" class="btn btn-default btn-xs " data-toggle="tooltip " title="Edit ">
                                                        <i class="fa fa-pencil "></i>
                                                    </a>
                                                    <a href="{{route('assignment.delete', $assignment->id)}}" class="btn btn-default btn-xs " data-toggle="tooltip " title="Delete " onclick="return confirm( 'Are you sure you want to delete this item?'); ">
                                                        <i class="fa fa-remove "></i>
                                                    </a>
                                                </td>
                                                </tr>                                            
                                            @endforeach
                                        </tbody>
                            </table></div></div></div><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
    </section><!-- /.content -->
</div>
    @endsection