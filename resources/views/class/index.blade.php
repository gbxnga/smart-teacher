@extends('layouts.theapp')

@section('title')
Class - {{config('app.name')}}
@endsection
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Classes
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Classes</li>
        </ol>
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
                $editmode = true;
            }else {$editmode = false;}
            ?>
            <div class="col-md-4">
                <!-- Horizontal Form -->
                <div class="box box-success">
                    <div class="box-header with-border">
                    <?php
                    if ($editmode){
                        echo '<h3 class="box-title">Edit Class</h3>';
                    }else{ echo '<h3 class="box-title">Add Class</h3>';}
                    ?>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Class</label>
                                <input id="class" name="name" placeholder="" 
                                <?php
                                if ($editmode)
                                {
                                    echo 'value="'.$class['name'].'"';
                                }
                                ?>
                                type="text" class="form-control" value="">
                                @if ($errors->has('section'))
                                    <span class="text-danger">
                                        <strong>*{{ $errors->first('section') }}*</strong>
                                    </span>
                                @endif
                            </div>

           

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                        <?php
                        if ($editmode){
                            echo '<button type="submit" class="btn btn-success pull-right">Update class</button>';
                        }else{ echo '<button type="submit" class="btn btn-success pull-right">Create class</button>';}
                        ?>
                        </div>
                    </form>
                </div>

            </div>
            <!--/.col (right) -->

            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Class List</h3>
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
                                                <th>Class </th>
                                                <th class="text-right sorting">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($classes as $class)
                                            

                                                <tr role="row" class="odd">
                                                <td class="mailbox-name sorting_1">{!! $class->name !!}</td>
                                                <td class="mailbox-date pull-right">
                                                <a href="" class="btn btn-default btn-xs" data-toggle="tooltip" title="View">
                                                    <i class="fa fa-remove "></i>
                                                </a>
                                                <a href="{!! action('TheClassController@edit', $class->id) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil "></i>
                                                </a>
                                                <a href="{!! action('TheClassController@delete', $class->id) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm( 'Are you sure you want to delete this item?'); ">
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