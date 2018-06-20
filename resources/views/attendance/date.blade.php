@extends('layouts.theapp')

@section('title')
Attendance
    @if (isset($clas))
    for {{$clas->name}}({{$sec->name}}) ({{$request->date}}) 
    @endif
- {{config('app.name')}}
@endsection
@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-check-o"></i> Attendance </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
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
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                    </div>
                    <form id="form1" method="post" accept-charset="utf-8">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="box-body">
                            <div class="row">
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
                                                    @if ($errors->has('class_id'))
                                                        <span class="text-danger">
                                                            <strong>*{{ $errors->first('class_id') }}*</strong>
                                                        </span>
                                                    @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Section</label>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value="">Select</option>
                                                @foreach($sections as $section)
                                                
                                                    <option
                                                    <?php
                                                    if ($editmode)
                                                    {
                                                       if($section['id'] === $sec['id'])
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>
                                                     value="{{ $section->id }}">{{ $section->name}}</option>
                                                
                                                    @endforeach
                                                </select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 pull-right">
                                <div class="form-group">
                                    <label>Attendance Date:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text"
                                        <?php
                                            if ($editmode)
                                            {
                                                echo 'value="'.$request->date. '"';
                                            }
                                        ?>
                                         name="date" class="form-control pull-right" id="datepicker">
                                         
                                    </div>
                                    <!-- /.input group -->
                                    @if ($errors->has('date'))
                                                        <span class="text-danger">
                                                            <strong>*{{ $errors->first('date') }}*</strong>
                                                        </span>
                                        @endif
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="search" value="search" class="btn btn-success btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
                <?php
                if ($editmode){
                ?>

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Attendance List for <strong>
                            <?= $clas['name'].' '.$clas['section'];?></strong> - <?= $request->date;?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="students-table table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th style="width: 254px;">Name</th>
                                            <th style="width: 197px;">Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1;
                                        ?>
                                        @foreach ($students as $student)
                                        <tr>
                                            <td class="sorting_1"> <?php echo $i;?></td>
                                            <td><a href="{{action('StudentController@show', $student->id)}}">
                                            {{$student->firstname}} {{$student->lastname}}</a></td>
                                            <td class="pull-left">
                                                <?php $caught = false;?>
                                                @foreach ($attendances as $attendance)
                                                
                                                    @if ($attendance->student_id === $student->id)

                                                            <?php $caught = true;?>
                                                    
                                                        <small class="label label-danger">
                                                            @if($attendance->type === 'L')
                                                            Late
                                                            @elseif ($attendance->type === 'LE')
                                                            Late - with excuse
                                                            @elseif ($attendance->type === 'A')
                                                            Absent
                                                            @endif
                                                            </small>
                                                    
                                                    @endif
                                                
                                                
                                                
                                                @endforeach
                                                <?php if(!$caught) echo '<small class="label label-success">Present</small>';?>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>

</section>
</div>

@endsection