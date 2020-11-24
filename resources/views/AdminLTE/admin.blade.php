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
    <link rel="stylesheet" href="/AdminLTE/css/bootstrap4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/AdminLTE/css/fontawsome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/AdminLTE/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
{{--    <link rel="stylesheet" href="AdminLTE/plugins/summernote/summernote-bs4.css">--}}
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/AdminLTE/css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/AdminLTE/css/my.css">
    @stack('style')
<!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
            <div class="">
                @include('partials.message')
                @yield('AdminLTE.content')
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

<!-- jQuery -->
<script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/AdminLTE/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/AdminLTE/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/AdminLTE/plugins/moment/moment-with-locales.min.js"></script>
<script src="/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
{{--<script src="/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>--}}
<!-- CKeditor -->
<script src="/AdminLTE/plugins/ckeditor/ckeditor.js"></script>
<script src="/AdminLTE/plugins/ckeditor/adapters/jquery.js"></script>
<!-- overlayScrollbars -->
<script src="/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/AdminLTE/js/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE/js/demo.js"></script>
<script src="/AdminLTE/js/app-admin.js"></script>
@stack('scripts')
<script src="/AdminLTE/js/my.js"></script>
</body>
</html>
