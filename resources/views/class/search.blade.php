@extends('layouts.theapp')

@section('title')
Search Class - {{config('app.name')}}
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Classes
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage classes</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if (session('status'))
                        <div class="callout callout-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> Select Class</h3>
                        </div>
                        <div class="box-body">
                            <div class="">
                                <div class="col-md-6">
                                    <form id="search_by_class_form" role="form" action="search" method="post" class="form-horizontal">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label>Class</label>
                                                <select id="class_id" name="class_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($classes as $class)
                                                
                                                    <option value="{!! $class->id !!}">{!! $class->name !!}</option>
                                                
                                                @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Section</label>
                                                <select id="section_id" name="section_id" class="form-control">
                                                @foreach($sections as $section)
                                                
                                                    <option value="{!! $section->id !!}">{!! $section->name !!}</option>
                                                
                                                @endforeach                                              
                                            </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" name="submit" value="search_class" class="btn btn-success btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('search_result')

                    

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


@endsection