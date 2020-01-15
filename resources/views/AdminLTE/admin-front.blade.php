<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/AdminLTE/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/AdminLTE/css/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/AdminLTE/css/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/AdminLTE/css/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/AdminLTE/css/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/AdminLTE/css/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/AdminLTE/css/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/AdminLTE/css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/AdminLTE/css/nestable.css">
    <link rel="stylesheet" href="/AdminLTE/css/my.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="app-admin" class="wrapper">
{{--Header--}}
@include('AdminLTE.partials.header')
{{--sidebar--}}
@include('AdminLTE.partials.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
    @include('AdminLTE.partials.page-header')
    <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            @include('AdminLTE.partials.small_box')
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                        @include('AdminLTE.partials.chart_box')
                    <div class="clearfix"></div>
                        @include('AdminLTE.partials.order_box')
                </section>
                <section class="col-lg-5 connectedSortable">
                   @include('AdminLTE.partials.map_box')
                </section>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('AdminLTE.partials.footer')

    {{--@include('AdminLTE.partials.control-sidebar')--}}
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/js/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Select2 -->
<script src="/AdminLTE/js/select2.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/AdminLTE/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/AdminLTE/js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/AdminLTE/js/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/AdminLTE/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/AdminLTE/js/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/AdminLTE/js/jquery.knob.js"></script>
<!-- daterangepicker -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>--}}
<script src="/AdminLTE/js/moment-with-locales.min.js"></script>
<script src="/AdminLTE/js/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/AdminLTE/js/bootstrap-datepicker.js"></script>
<script src="/AdminLTE/js/bootstrap-datepicker.ru.js"></script>
{{--iChek--}}
<script src="/AdminLTE/js/icheck.min.js"></script>
{{--<!-- Bootstrap WYSIHTML5 -->--}}
<script src="/AdminLTE/js/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/AdminLTE/js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/AdminLTE/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE/js/app.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/AdminLTE/js/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE/js/demo.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/AdminLTE/js/jquery.nestable.js"></script>
<script src="/AdminLTE/js/app-admin.js"></script>
<script src="/AdminLTE/js/my.js"></script>
@stack('script')
<script type="text/javascript">

    // CKEDITOR.replace(my_editor, options);
</script>

</body>
</html>
