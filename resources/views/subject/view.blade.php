@extends('layouts.theapp')

@section('title')
{{$subject->name}} - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> Academics </h1>
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

                    <div class="callout callout-danger">{{ $error }}</div>

                @endforeach 
            @endif 
            </div>
        </div>     
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">              
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Subtopics</h3>
                            </div>
                            <form id="form1" name="employeeform" action="{{route('subtopic.create', $subject->id)}}" method="post" accept-charset="utf-8">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                                <div class="box-body">
                                            
                                    <input type="hidden" name="ci_csrf_token" value="">                                <div class="form-group">
                                        <label for="exampleInputEmail1">Subtopic</label>
                                        <input id="category" name="name" placeholder="" type="text" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                    
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success pull-right">CREATE SUBTOPIC</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                            <h3 class="box-title">Subtopics for {{$subject->name}}</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                            <table class="table table-condensed">
                                
                                <tr>
                                <th style="width: 10px">#</th>
                                <th>Subtopic</th>
                                <th style="width: 40px">Assignments</th>
                                </tr>
                                <tr>
                                @foreach ($subtopics as $indexKey=>$subtopic)
                                <td>{{$indexKey+1}}</td>
                                <td>{{$subtopic->description}}</td>
                                <td><span class="badge bg-red">{{$subtopic->getNumberOfAssignments()}}</span></td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="col-md-12"> 
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Subject Details</h3>
                            </div> 
                            <div class="box-body">
                                <strong><i class="fa fa-book margin-r-5"></i>{!! $subject->name !!}</strong>

                                <p class="text-muted">
                                {!! $subject->type !!} 
                                </p>

                                <hr>

                                <strong><i class="fa fa-map-marker margin-r-5"></i> Class</strong>

                                <p class="text-muted">  {{$subject->getClassName()}}</p>

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
                </div>


                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">All Assignments for {{$subject->name}}</h3>
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
                                                            <th>Class </th>
                                                            <th class="text-right sorting">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($assignments as $indexKey => $assignment)
                                                            <tr role="row" class="odd">
                                                            <td class="">{!! $indexKey+1 !!}</td>
                                                            <td>{!! $assignment->description !!}</td>
                                                            <td class="">{{$assignment->getSubtopic()}}</td>
                                                            <td class="">{{$assignment->getSubject()}}</td>
                                                            <td class="">{{$assignment->getClass()}}</td>
                                                            <td class="mailbox-date pull-right"> 
                                                            <a href="{{route('assignment.performance', $assignment->id)}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="View Marks">
                                                                    <i class="fa fa-bar-chart"></i>
                                                                </a>                                               
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
                        <div class="">
                            <div class="box box-success">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">All Resources for {{$subject->name}} (<strong>{{$subject->getClassName()}}</strong>)</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                    <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive mailbo-messages">
                                        
                                        <div class="">
                                            <div class="">
                                                <table class="table table-striped table-bordered table-hover example dataTable no-footer">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Description </th>
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
                                    <div class="box-footer">
                                        <a href="{{route('resources.index')}}" class="btn btn-success pull-right">UPLOAD RESOURCE</a>
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