<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nongkiyuk Admin | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Dropzone --}}
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.css') }}">
    @yield('css')
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    @include('includes.header')
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('img/logo.png') }}" class="img-circle">
                </div>
                <div class="pull-left info">
                    <p>Nongkiyuk</p>
                </div>
            </div>

            <!-- Sidebar Menu -->
            @include('includes.sidebar')
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 878px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page-header')
                <small>@yield('optional-header')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            
            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    @include('includes.footer')

</div>
<!-- ./wrapper -->

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@yield('js')
@include('includes.js')
</body>
</html>