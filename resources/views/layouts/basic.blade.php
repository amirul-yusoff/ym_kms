<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <link href="{{URL::asset('css/app.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/all.css')}}" rel="stylesheet">
    <script src="{{URL::asset('js/autoNumeric.min.js')}}"></script>
    <script src="{{URL::asset('js/dropzone/dropzone.js')}}"></script>
    @yield('style')
</head>
<body>
    @yield('body')
    <!-- JavaScripts -->
    <div id="app"></div>
    <script src="{{URL::asset('js/app.js')}}"></script>
    <script src="{{URL::asset('js/toastr.js')}}"></script>
    <script src="{{URL::asset('js/popper.min.js')}}"></script>
    <script src="{{URL::asset('js/inspinia/moment-with-locales.min.js')}}"></script>
    <script src="{{URL::asset('js/inspinia/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('js/initialization.js')}}"></script>
    @yield('script_admin')
    @yield('script')
</body>
</html>










