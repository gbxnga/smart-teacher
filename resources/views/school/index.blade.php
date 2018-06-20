@extends('layouts.theapp')

@section('title')
School Information - {{config('app.name')}}
@endsection
@section('content')


<div class="content-wrapper" style="min-height: 634px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> School Information</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (count($errors) > 0) 
                    @foreach ($errors->all() as $error)

                        <div class="callout callout-danger">{{ $error }}</div>

                    @endforeach 
                @endif
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-gear"></i> General Settings</h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                 </div>
                        </div>
                    </div>
                    <div class="box-body">
                        @foreach($settings as $setting)
                        <p>Current Term:  
                        <?php
                            if($setting->term == 1 ) echo 'First Term';
                            elseif($setting->term == 2 ) echo 'Second Term';
                            elseif($setting->term == 3 ) echo 'Third Term';
                        ?>
                        </p>
                        <p>Current Session: 
                        <?php
                            $year = (int) $setting->year;
                            echo $year - 1 .'/'.$year;
                        ?>
                        </p>
                        @endforeach
                       
        <button class="btn btn-success  btn-sm" id="push-notification-btn" disabled>ENABLE PUSH NOTIFICATION</button>
        <p style="display:none" class="js-subscription-json">
        </p>
        <p style="display:none" class="js-subscription-details">
        </p>
                    </div>
                </div>
                 
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-gear"></i> Update Settings</h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                 </div>
                        </div>
                    </div>
                    <div class="box-body">

                        <form action="{{route('settings.store')}}" method="post">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Current Term</label>
                                            <select class="form-control" name="term">
                                                <option value="">Select</option>
                                                <option value="1">First</option>
                                                <option value="2">Second</option>
                                                <option value="3">Third</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Current Session</label>
                                            <select class="form-control" name="year">
                                                <option value="">Select</option>
                                                <option value="2018">2017/2018</option>
                                                <option value="2019">2018/2019</option>
                                                <option value="2020">2019/2020</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm pull-right">UPDATE</button>
                                
                        </form>
                       
                    </div>
                </div>
                 
            </div>
            <div class="col-md-4">              
                <div class="box box-success">
                    <div class="box-body box-profile">
                        <img width="150" height="150" class="profile-user-img img-responsive img-circle" src="{{url('/images/')}}/{{Auth::user()->photo}}" alt="User profile picture">
                        <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right text-aqua">{{Auth::user()->email}}</a>
                        </ul>
                        <form action="{{route('upload.image')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
        <label for="photo" class="col-md-12 ">Select Photo</label>

        <div class="col-md-12">
            <input type="file" name="image" id="photo" size="20">

            @if ($errors->has('image'))
                <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
            @endif
        </div>
    </div>
                        <button type="submit "class="btn btn-success pull-right" title="">
                                Upload Image</button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection