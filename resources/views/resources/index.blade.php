@extends('layouts.theapp')

@section('title')
Resources - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Resources
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Resources</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            @if (session('status'))
                <div class="col-md-12">
                    <div class="callout callout-success">
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            @if (count($errors) > 0) 
            @foreach ($errors->all() as $error)

                <div class="callout callout-danger">{{ $error }}</div>

            @endforeach 
            @endif
            <div class="col-md-5">
                <!-- Horizontal Form -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Upload Resources</h3>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1" action="{{route('resources.upload')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Resource Name</label>
                                            <input id="name" name="name" placeholder="" type="text" class="form-control" value="">
                                            @if ($errors->has('firstname'))
                                                <span class="text-danger">
                                                    <strong>*{{ $errors->first('name') }}*</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                

                                <div class="col-md-12">
                                <label for="description" class=" control-label">Description</label>
                                    <textarea id="editor1" style="height:120px;width:100%" name="description" placeholder="" class="textarea teform-control" rows="2" required> </textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Select File</label>
                                            <input type="file" name="file" id="file" size="20">
                                        </div>
                                        @if ($errors->has('file'))
                                        <span class="text-danger">
                                            <strong>*{{ $errors->first('file') }}*</strong>
                                        </span>
                                    @endif
                                    </div>
                            <!--<div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Class</label>
                                <select id="class_id" name="class_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($classes as $class)
                                    {
                                        <option value="{!! $class->id !!}" >
                                            {!! $class->name !!} - {{$class->section}}
                                        </option>
                                    }
                                    @endforeach
                                    </select>
                                    @if ($errors->has('class_id'))
                                        <span class="text-danger">
                                            <strong>*{{ $errors->first('class_id') }}*</strong>
                                        </span>
                                    @endif
                            </div>-->
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Subject</label>
                                <select id="subject_id" name="subject_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($subjects as $subject)
                                    {
                                        <option value="{!! $subject->id !!}">
                                            {!! $subject->name !!} (<strong>{{$subject->getClassName()}}</strong>)
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

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">UPLOAD RESOURCE</button>
                        </div>
                    </form>
                </div>

            </div>
            <!--/.col (right) -->

            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">All Resources</h3>
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
                                                <th>Name</th>
                                                <th>Description </th>
                                                <th>Subject </th>
                                                <th>File Size</th>
                                                <th class="text-right sorting">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resources as $indexKey => $resource)
                                                <tr role="row" class="odd">
                                                <td class="">{!! $indexKey+1 !!}</td>
                                                <td>{!! $resource->name !!}</td>
                                                <td>{!! $resource->description !!}</td>
                                                <td class="">{{$resource->getSubject()}}</td>
                                                <td class="">{{$resource->size/1000}}KB</td>
                                                <td class="mailbox-date pull-right"> 
                                                    <a href="{{route('resources.download', $resource->id)}}" class="btn btn-default btn-xs " data-toggle="tooltip" title="download">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <a href="{{route('resources.delete', $resource->id)}}" class="btn btn-default btn-xs " data-toggle="tooltip" title="Delete" onclick="return confirm( 'Are you sure you want to delete this item?'); ">
                                                        <i class="fa fa-trash-o"></i>
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