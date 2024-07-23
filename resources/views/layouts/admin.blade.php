@extends('layouts.basic')

<?php $message_success = Session::get('success'); ?>
<?php $message_warning = Session::get('warning'); ?>

@section('body')
    <div id="wrapper">
        <!-- Navigation -->
        @include('partials.sidemenu-main')
        <div id="page-wrapper" class="gray-bg">
            @include('partials.header')
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
@endsection

@section('script_admin')
@endsection
