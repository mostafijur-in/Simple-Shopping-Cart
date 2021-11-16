<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name', 'Shopping Cart') }}</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('niceadmin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('niceadmin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Bootstrap CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Vendor CSS Files -->
    {{-- <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('niceadmin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('niceadmin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('niceadmin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    {{-- Includable CSS --}}
    @yield('styles')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // "global" vars, built using blade
        var appUrl = "{{ url('/') }}";
        var assetUrl = "{{ URL::asset('/') }}";
    </script>
</head>

<body>
    @php
        $user   = auth()->user();
    @endphp

    @include('layouts.admin.topbar')
    @include('layouts.admin.aside')

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    @include('layouts._modals')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>mostafijur.in</span></strong>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Bootstrap JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/ae82d4046d.js" crossorigin="anonymous"></script>

    <!-- Vendor JS Files -->
    {{-- <script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script> --}}
    <script src="{{ asset('niceadmin/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('niceadmin/vendor/echarts/echarts.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('niceadmin/js/main.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/admin-scripts.js') }}"></script>

    {{-- Modal instances --}}
    <script>
        const commonModal = new bootstrap.Modal($("#commonModal"));
        const successModal = new bootstrap.Modal($("#successModal"));

        // Date and time picker
        window.datepicker_init = function() {
            $(".datePicker").daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1965,
                maxYear: parseInt(moment().format("YYYY"), 10) + 15,
                autoApply: true,
                locale: {
                    format: "DD-MM-YYYY",
                    cancelLabel: 'Clear'
                }
            });

            $(".datePicker").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });
        };
        window.datetimepicker_init = function() {
            $(".datetimePicker").daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 1965,
                maxYear: parseInt(moment().format("YYYY"), 10) + 15,
                autoApply: true,
                locale: {
                    format: "DD-MM-YYYY hh:mm A",
                    cancelLabel: 'Clear'
                }
            });

            $(".datetimePicker").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY hh:mm A'));
            });
        };
    </script>

</body>

</html>
