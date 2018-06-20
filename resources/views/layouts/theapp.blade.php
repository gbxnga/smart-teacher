<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="description" content="Smart Teacher App: Education IT solution to track collective and individual student performance to facilitate personalised learning decisions">
  <meta name="keywords" content="Edutech, education, innovation, Laravel, software for schools, Nigeria, BetaGrades">
  <meta name="author" content="Gbenga Oni - BetaGrades">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- jvectormap -->
  <!--<link rel="stylesheet" href="{{ URL::asset('bower_components/jvectormap/jquery-jvectormap.css') }}">-->
  <!-- Theme style -->
  <meta name="theme-color" content="#00a65a" />
     <!-- bootstrap datepicker -->
     <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
  <!-- Pace style -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/pace/pace.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    @if (Route::currentRouteName() == 'assignment.form.create' || Route::currentRouteName() == 'resources.index')
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    @endif
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/iCheck/square/blue.css') }}">
    @if (Route::currentRouteName() == 'home' || Route::currentRouteName() == 'student.profile')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
    @endif
    <!-- Morris charts -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/morris.js/morris.css') }}">
    @if (Route::currentRouteName() == 'timetable.save')
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
    @endif
    <script>
                    if ('serviceWorker' in navigator) {
                    navigator.serviceWorker
                        .register('sw.js')
                        .then(function() {
                            console.log('Service Worker Registered');
                        })
                }
    </script>
    

  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body class="sidebar-mini skin-green-light">
<div class="wrapper">
    <style>
        body {
            font-family: 'Raleway' !important;
        }
    </style>

  <header class="main-header">

    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SMRT</b></span>
      <!-- logo for regular state and mobile devices -->
      
      <span class="logo-lg"><b>Smart</b>Teacher<small>.com.ng</small></span>

      
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="{{ URL::asset('images/') }}/{{ Auth::user()->photo }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ URL::asset('images/') }}/{{ Auth::user()->photo }}" class="img-circle" alt="User Image">

                <p>
                {{ Auth::user()->name }} - Teacher
                  <small>Member since {{date('M, Y',strtotime(Auth::user()->created_at))}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                </div>
                <div class="pull-right">
                    

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="{{route('settings')}}" data-toggle="control-sideba"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ URL::asset('images/') }}/{{ Auth::user()->photo }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        
        <?php
        $setting = \App\Settings::all()->first();
        ?>
        <li  style="padding:7px 20px"class="">
          Term:         <?php
                            if($setting->term == 1 ) echo 'First Term';
                            elseif($setting->term == 2 ) echo 'Second Term';
                            elseif($setting->term == 3 ) echo 'Third Term';
                        ?>
        </li>
        <li  style="padding:7px 20px" class="">
          Session:                         <?php
                            $year = (int) $setting->year;
                            echo $year - 1 .'/'.$year;
                        ?>
        </li>
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
          <a href="{{route('home')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>-->
        <li class="treeview @if (Route::currentRouteName() == 'student.register.form' || Route::currentRouteName() == 'student.search.form') active @endif">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Students</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('student.register.form')}}"><i class="fa fa-circle-o"></i>Register Students</a></li>
            <li><a href="{{route('student.search.form')}}"><i class="fa fa-circle-o"></i> Manage Students<span class="pull-right-container">
              <small class="label pull-right bg-green">{{App\Student::count()}}</small>
            </span></a></li>
          </ul>
        </li>
        <li class="treeview @if (Route::currentRouteName() == 'classes' || Route::currentRouteName() == 'class.search') active @endif">
            <a href="#">
                <i class="fa fa-hospital-o"></i> <span>Classes</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="active">
                    <a href="{{route('classes')}}">
                    <i class="fa fa-angle-double-right"></i> Create Class</a></li>
                <li class=""><a href="{{route('class.search')}}"><i class="fa fa-angle-double-right"></i>Manage Class<span class="pull-right-container">
              <small class="label pull-right bg-green">{{App\TheClass::count()}}</small>
            </span></a></li>
            </ul>
        </li>
        <li class=" @if (Route::currentRouteName() == 'subjects') active @endif">
          <a href="{{route('subjects')}}">
            <i class="fa fa-book"></i>
            <span>Subjects</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">{{App\Subject::count()}}</small>
            </span>
          </a>
        </li>
        <li class="treeview @if (Route::currentRouteName() == 'attendance.date' || Route::currentRouteName() == 'attendance.report') active @endif">
            <a href="#">
                <i class="fa fa-calendar-check-o"></i> <span>Attendance</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="active">
                    <a href="{{route('attendance.index')}}">
                    <i class="fa fa-angle-double-right"></i> Student Attendance</a></li>
                <li class=""><a href="{{route('attendance.date')}}"><i class="fa fa-angle-double-right"></i> Attendance By Date</a></li>
                <li class=""><a href="{{route('attendance.report')}}"><i class="fa fa-angle-double-right"></i> Attendance Report</a></li>
            </ul>
        </li>
        <li class="treeview @if (Route::currentRouteName() == 'assignment.form.create') active @endif">
            <a href="#">
                <i class="fa fa-list-alt"></i> <span>Assignments</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="active">
                    <a href="{{route('assignment.form.create')}}">
                    <i class="fa fa-angle-double-right"></i>Manage Assignments<span class="pull-right-container">
              <small class="label pull-right bg-green">{{App\Assignment::count()}}</small>
            </span></a>
          </li>
            </ul>
        </li>
        <li class="treeview @if (Route::currentRouteName() == 'marks.create') active @endif">
            <a href="#">
                <i class="fa fa-list-alt"></i> <span>Examinations</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="active">
                    <a href="{{route('marks.create')}}">
                    <i class="fa fa-angle-double-right"></i>Record Marks</a>
          </li>
            </ul>
        </li>
        <li class=" @if (Route::currentRouteName() == 'timetable') active @endif">
          <a href="{{route('timetable')}}">
            <i class="fa fa-calendar"></i>
            <span>Timetable</span>
          </a>
        </li>
        <li class=" @if (Route::currentRouteName() == 'resources.index') active @endif">
          <a href="{{route('resources.index')}}">
            <i class="fa fa-book"></i>
            <span>Resources</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">{{App\Resource::count()}}</small>
            </span>
          </a>
        </li>
        <li class=" @if (Route::currentRouteName() == 'settings') active @endif">
          <a href="{{route('settings')}}">
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  @yield('content')

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.1
    </div>
    <strong>Copyright © 2017-2018 <a href="https://betagrades.com">BetaGrades</a>.</strong> All rights
    reserved.
  </footer>

  <form id="send_endpoint" style="display:none">
        {{ csrf_field() }}
        <input type="text" hidden="hidden" value="" id="object_push" name="object" />
    </form>
    
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap  -->
<!--<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>-->
<!-- SlimScroll -->
<script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ URL::asset('dist/js/pages/dashboard2.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset('dist/js/demo.js') }}"></script>

<!-- FLOT CHARTS -->
<script src="{{ URL::asset('bower_components/Flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ URL::asset('bower_components/Flot/jquery.flot.resize.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ URL::asset('bower_components/Flot/jquery.flot.pie.js') }}"></script>

<!-- PACE -->
<script src="{{ URL::asset('bower_components/PACE/pace.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ URL::asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@if (Route::currentRouteName() == 'assignment.form.create' || Route::currentRouteName() == 'resources.index')
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
@endif
<!-- iCheck -->
<script src="{{ URL::asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- fullCalendar -->
<script src="{{ URL::asset('bower_components/moment/moment.js') }}"></script>
@if (Route::currentRouteName() == 'home' || Route::currentRouteName() == 'student.profile')
<script src="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
@endif
<!-- Morris.js charts -->
<script src="{{ URL::asset('bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ URL::asset('bower_components/morris.js/morris.min.js') }}"></script>
@if (Route::currentRouteName() == 'timetable.save')
<!-- bootstrap time picker -->
<script src="{{ URL::asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
@endif
<!-- ChartJS -->
<script src="{{ URL::asset('bower_components/Chart.js/Chart.js') }}"></script>

<!--<script type="text/javascript" language="javascript" src="//cod.jquery.com/jquery-1.12.4.j"></script>-->
<script src="js/push.js"></script>
@if (Route::currentRouteName() == 'student.search.fulltext' || Route::currentRouteName() == 'assignment.performance'  || Route::currentRouteName() == 'attendance.date.post'  || Route::currentRouteName() == 'attendance.report.post' || Route::currentRouteName() == 'subject.edit' || Route::currentRouteName() == 'subjects' || Route::currentRouteName() == 'student.search')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
@endif
<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print',
                        {
                    extend: 'collection',
                    text: 'Table control',
                    buttons: [
                        {
                            text: 'Toggle Admission Date',
                            action: function ( e, dt, node, config ) {
                                dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                            }
                        },
                        {
                            text: 'Toggle Action',
                            action: function ( e, dt, node, config ) {
                                dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                            }
                        },
                        
                    ]
                }
            ]
        });
    });
</script>
<script>
  
        $(function () {
          //Date picker
          $('#datepicker').datepicker({
                autoclose: true
            })
          $('#example1').DataTable()
          $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          })
        })
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '10%' // optional
            });
          });
          @if (Route::currentRouteName() == 'timetable.save')
             //Timepicker
             $('.timepicker').timepicker({
                showInputs: false,
                defaultTime: false,
            })
            @endif

            @if (Route::currentRouteName() == 'assignment.form.create' || Route::currentRouteName() == 'resources.index')
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
            @endif
                      
       
        $(function() {
            Pace.restart()
            
            

            /*
             * DONUT CHART
             * -----------
             */
            @if (Route::currentRouteName() == 'home' || Route::currentRouteName() == 'class.view')
            $.ajax({
              @if (Route::currentRouteName() == 'class.view') 
              url: "/api/get-class-stat/{{$class->id}}/{{$section->id}}",
              @else 
              url: "api/get-class-stat",
              @endif
              type: "GET",
              data: new FormData(this),
              contentType: false,
              processData: false,
              failure: function(data) {},
              success: function(data) {
                console.log(data);
                var donutData = JSON.parse(data);
                $.plot('#donut-chart', donutData, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            innerRadius: 0.5,
                            label: {
                                show: true,
                                radius: 2 / 3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }

                        }
                    },
                    legend: {
                        show: false
                    }
                })
              }
            });
                    /*
         * Custom Label formatter
         * ----------------------
         */
        function labelFormatter(label, series) {
            return '<div style="font-size:10px; text-align:center; padding:2px 10px; color: #fff; font-weight: 600;">' +
                label +
                '<br>' +
                Math.round(series.percent) + '%</div>'
        }
            @endif

            /*var donutData = [{
                label: 'JSS2b',
                data: 30,
                color: '#3c8dbc'
            }, {
                label: 'JSS1',
                data: 20,
                color: '#0073b7'
            }, {
                label: 'PRIMARY 5',
                data: 50,
                color: '#00c0ef'
            }]*/
            
                /*
                 * END DONUT CHART
                 */
                


        })


            @if (Route::currentRouteName() == 'student.profile')
            //BAR CHART
            var bar = new Morris.Bar({
              element: 'bar-chart',
              resize: true,
              data: [
                <?php if(isset($bars) && !empty($bars)) 
                {
                  $bars = json_decode($bars);
                  foreach($bars as $bar)
                  {
                    echo '{y: "'.$bar->y.'", a: '.$bar->a.', b: '.$bar->b.', c: "'.$bar->c.'", d: "'.$bar->d.'"},';
                  }
                }
                ?>
              ],
              barColors: ['#00a65a', '#f56954', 'orange', 'blue'],
              xkey: 'y',
              ykeys: ['a', 'b', 'c', 'd'],
              labels: ['Present', 'Absent', 'Late', 'Late with Excuse'],
              hideHover: 'auto'
            });
            @endif

        
</script>


<script>
  $(function() {

    @if (Route::currentRouteName() == 'student.profile')
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : ['January', 'February'],
      datasets: [
        @foreach ($stats as $stat)
        {
          label               : '{{$stat['label']}}',
          fillColor           : '{{$stat['fillColor']}}',
          strokeColor         : '{{$stat['strokeColor']}}',
          pointColor          : '{{$stat['pointColor']}}',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [{{$stat['data']}}]
        },
        @endforeach
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    //-------------
    //- LINE CHART -
    //--------------
    var ln = document.querySelector("#lineChart");
    var lineChartCanvas          = $("#lineChart").get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions)
    @endif

            /* initialize the external events
             -----------------------------------------------------------------*/
            function init_events(ele) {
                ele.each(function() {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    })

                })
            }

            init_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day'
                },
                //Random default events
            events: [

                <?php if(isset($attendances) && !empty($attendances)) 
                {
                ?>
                
                   @foreach ($attendances as $attendance)
                   <?php
                    if ($attendance->type === 'A') $titlee='Absent';
                    else if ($attendance->type === 'L') $titlee='Late';
                    else if ($attendance->type === 'LE') $titlee='Late with Excuse';
                    else $titlee='ee';
                    
                    ?>

                    {title: '<?php echo $titlee;?>', start: '<?php echo substr($attendance->attendance_date, 0, 10); ?>',backgroundColor: '#f56954',borderColor: '#f39c12'} @if(  count($attendances)>1) , @endif
                    @endforeach

                <?php
                }// end if isset attendances
                ?>
            
            ],
                event: [{
                    title: 'Absent',
                    start: new Date(y, m, 1),
                    backgroundColor: '#f56954', //red
                    borderColor: '#f56954' //red
                }, {
                    title: 'Late',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    backgroundColor: '#f39c12', //yellow
                    borderColor: '#f39c12' //yellow
                }, {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    backgroundColor: '#0073b7', //Blue
                    borderColor: '#0073b7' //Blue
                }, {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    backgroundColor: '#00c0ef', //Info (aqua)
                    borderColor: '#00c0ef' //Info (aqua)
                }, {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    backgroundColor: '#00a65a', //Success (green)
                    borderColor: '#00a65a' //Success (green)
                }, {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/',
                    backgroundColor: '#3c8dbc', //Primary (light-blue)
                    borderColor: '#3c8dbc' //Primary (light-blue)
                }],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject')

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject)

                    // assign it the date that was reported
                    copiedEventObject.start = date
                    copiedEventObject.allDay = allDay
                    copiedEventObject.backgroundColor = $(this).css('background-color')
                    copiedEventObject.borderColor = $(this).css('border-color')

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove()
                    }

                }
            })

            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
                //Color chooser button
            var colorChooser = $('#color-chooser-btn')
            $('#color-chooser > li > a').click(function(e) {
                e.preventDefault()
                    //Save color
                currColor = $(this).css('color')
                    //Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color': currColor
                })
            })
            $('#add-new-event').click(function(e) {
                e.preventDefault()
                    //Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                //Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff'
                }).addClass('external-event')
                event.html(val)
                $('#external-events').prepend(event)

                //Add draggable funtionality
                init_events(event)

                //Remove event from text input
                $('#new-event').val('')
            })
        })
    </script>

    @if (Route::currentRouteName() == 'assignment.performance')
    <!-- jQuery Knob -->
    <script src="{{ URL::asset('bower_components/jquery-knob/js/jquery.knob.js') }}"></script>
    <script>
    $(function () {
      /* jQueryKnob */

      $(".knob").knob({
        /*change : function (value) {
        //console.log("change : " + value);
        },
        release : function (value) {
        console.log("release : " + value);
        },
        cancel : function () {
        console.log("cancel : " + this.value);
        },*/
        draw: function () {

          // "tron" case
          if (this.$.data('skin') == 'tron') {

            var a = this.angle(this.cv)  // Angle
                , sa = this.startAngle          // Previous start angle
                , sat = this.startAngle         // Start angle
                , ea                            // Previous end angle
                , eat = sat + a                 // End angle
                , r = true;

            this.g.lineWidth = this.lineWidth;

            this.o.cursor
            && (sat = eat - 0.3)
            && (eat = eat + 0.3);

            if (this.o.displayPrevious) {
              ea = this.startAngle + this.angle(this.value);
              this.o.cursor
              && (sa = ea - 0.3)
              && (ea = ea + 0.3);
              this.g.beginPath();
              this.g.strokeStyle = this.previousColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
              this.g.stroke();
            }

            this.g.beginPath();
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
            this.g.stroke();

            this.g.lineWidth = 2;
            this.g.beginPath();
            this.g.strokeStyle = this.o.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
            this.g.stroke();

            return false;
          }
        }
      });
      /* END JQUERY KNOB */

      //INITIALIZE SPARKLINE CHARTS
      $(".sparkline").each(function () {
        var $this = $(this);
        $this.sparkline('html', $this.data());
      });

      /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
      drawDocSparklines();
      drawMouseSpeedDemo();

    });
    function drawDocSparklines() {

      // Bar + line composite charts
      $('#compositebar').sparkline('html', {type: 'bar', barColor: '#aaf'});
      $('#compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7],
          {composite: true, fillColor: false, lineColor: 'red'});


      // Line charts taking their values from the tag
      $('.sparkline-1').sparkline();

      // Larger line charts for the docs
      $('.largeline').sparkline('html',
          {type: 'line', height: '2.5em', width: '4em'});

      // Customized line chart
      $('#linecustom').sparkline('html',
          {
            height: '1.5em', width: '8em', lineColor: '#f00', fillColor: '#ffa',
            minSpotColor: false, maxSpotColor: false, spotColor: '#77f', spotRadius: 3
          });

      // Bar charts using inline values
      $('.sparkbar').sparkline('html', {type: 'bar'});



      // Tri-state charts using inline values
      $('.sparktristate').sparkline('html', {type: 'tristate'});
      $('.sparktristatecols').sparkline('html',
          {type: 'tristate', colorMap: {'-2': '#fa7', '2': '#44f'}});

      // Composite line charts, the second using values supplied via javascript
      $('#compositeline').sparkline('html', {fillColor: false, changeRangeMin: 0, chartRangeMax: 10});
      $('#compositeline').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7],
          {composite: true, fillColor: false, lineColor: 'red', changeRangeMin: 0, chartRangeMax: 10});

      // Line charts with normal range marker
      $('#normalline').sparkline('html',
          {fillColor: false, normalRangeMin: -1, normalRangeMax: 8});
      $('#normalExample').sparkline('html',
          {fillColor: false, normalRangeMin: 80, normalRangeMax: 95, normalRangeColor: '#4f4'});

      // Discrete charts
      $('.discrete1').sparkline('html',
          {type: 'discrete', lineColor: 'blue', xwidth: 18});
      $('#discrete2').sparkline('html',
          {type: 'discrete', lineColor: 'blue', thresholdColor: 'red', thresholdValue: 4});

      // Bullet charts
      $('.sparkbullet').sparkline('html', {type: 'bullet'});

      // Pie charts
      $('.sparkpie').sparkline('html', {type: 'pie', height: '1.0em'});

      // Box plots
      $('.sparkboxplot').sparkline('html', {type: 'box'});
      $('.sparkboxplotraw').sparkline([1, 3, 5, 8, 10, 15, 18],
          {type: 'box', raw: true, showOutliers: true, target: 6});

      // Box plot with specific field order
      $('.boxfieldorder').sparkline('html', {
        type: 'box',
        tooltipFormatFieldlist: ['med', 'lq', 'uq'],
        tooltipFormatFieldlistKey: 'field'
      });

      // click event demo sparkline
      $('.clickdemo').sparkline();
      $('.clickdemo').bind('sparklineClick', function (ev) {
        var sparkline = ev.sparklines[0],
            region = sparkline.getCurrentRegionFields();
        value = region.y;
        alert("Clicked on x=" + region.x + " y=" + region.y);
      });

      // mouseover event demo sparkline
      $('.mouseoverdemo').sparkline();
      $('.mouseoverdemo').bind('sparklineRegionChange', function (ev) {
        var sparkline = ev.sparklines[0],
            region = sparkline.getCurrentRegionFields();
        value = region.y;
        $('.mouseoverregion').text("x=" + region.x + " y=" + region.y);
      }).bind('mouseleave', function () {
        $('.mouseoverregion').text('');
      });
    }

    /**
    ** Draw the little mouse speed animated graph
    ** This just attaches a handler to the mousemove event to see
    ** (roughly) how far the mouse has moved
    ** and then updates the display a couple of times a second via
    ** setTimeout()
    **/
    function drawMouseSpeedDemo() {
      var mrefreshinterval = 500; // update display every 500ms
      var lastmousex = -1;
      var lastmousey = -1;
      var lastmousetime;
      var mousetravel = 0;
      var mpoints = [];
      var mpoints_max = 30;
      $('html').mousemove(function (e) {
        var mousex = e.pageX;
        var mousey = e.pageY;
        if (lastmousex > -1) {
          mousetravel += Math.max(Math.abs(mousex - lastmousex), Math.abs(mousey - lastmousey));
        }
        lastmousex = mousex;
        lastmousey = mousey;
      });
      var mdraw = function () {
        var md = new Date();
        var timenow = md.getTime();
        if (lastmousetime && lastmousetime != timenow) {
          var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
          mpoints.push(pps);
          if (mpoints.length > mpoints_max)
            mpoints.splice(0, 1);
          mousetravel = 0;
          $('#mousespeed').sparkline(mpoints, {width: mpoints.length * 2, tooltipSuffix: ' pixels per second'});
        }
        lastmousetime = timenow;
        setTimeout(mdraw, mrefreshinterval);
      };
      // We could use setInterval instead, but I prefer to do it this way
      setTimeout(mdraw, mrefreshinterval);
    }
  </script>
    @endif
    @if (Route::currentRouteName() == 'class.search')
    <script>
      $('#search_by_class_form').on('submit', function(e){
          e.preventDefault();
          var class_id = $('#class_id').find(":selected").attr("value");
          var section_id = $('#section_id').find(":selected").attr("value");
          var url      = window.location.href;
          window.location.href = "/class/view/"+class_id+"/"+section_id;
      })
  </script>
  @endif
  <script>
      $('#get_subtopics_select').on('change', function(){

          // disable submit button

          // get subject id
          var subject_id = $(this).find(":selected").attr("value");
          
          // get json form server
          $.getJSON( "/subject/get-subtopics/"+subject_id, function( data ) {
            var items = [];
            $('#subtopic_id').html('');
            $.each( data, function( key, val ) {
              $('#subtopic_id').append('<option value="'+val.id+'">'+val.name+'</option>')
            });
          });

          // populate subtopics select
      });
    </script>
</body>
</html>