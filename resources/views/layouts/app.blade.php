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

@section('noti')
    <script type="text/javascript">
        var message_success = '<?php echo $message_success; ?>';
        var message_warning = '<?php echo $message_warning; ?>';

        if(message_success) {
            setTimeout(function() {
                toastr.options = {
                    showMethod: 'slideDown',
                    timeOut: 1500
                };
                toastr.success(message_success);
            }, 300);
        }

        if(message_warning) {
            setTimeout(function() {
                toastr.options = {
                    showMethod: 'slideDown',
                    timeOut: 4500
                };
                toastr.warning(message_warning);
            }, 300);
        }

        $(document).on('click', '#see-noti', function(event) {
            var formData = {
                '_token': '{{csrf_token()}}'
            };
            $.ajax({
                type: 'POST',
                url: '{{url('member/read-all')}}',
                data: formData,
                dataType: 'json',
                encode: 'true'
            })
            .done(function(res) {
                if(res['success']) {
                    $('.notiNo').css('display', 'none');
                }
            });
        });
    </script>
@endsection
