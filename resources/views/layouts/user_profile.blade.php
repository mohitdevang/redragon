<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->title }} | @yield('title')</title>
    <link rel="icon" href="{{url('/')}}/public/uploads/{{$setting->favicon}}" type="image/png">
    <!-- Custom Css -->
    <link href="{{url('/')}}/public/admin/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/public/admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Data Table -->
    <link href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css" rel="stylesheet">
</head>

<body>


    @stack('css')
    {!! $setting->google_analytics !!}
    </head>

    <body>

        <!-- Animated Background -->
        <div class="background">
            <div class="particles">
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>


        <!-- DASHBOARD -->
        <div class="dashboard">

            @include('elements.user_left_menu')
            <main class="main-content">


                @include('elements.user_top_bar')
                @include('elements.user_login_modal')
                @yield('content')

                @include('elements.user_footer')

            </main>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>


        <!-- SIDEBAR collapsed -->
        <script src="{{ url('/') }}/public/admin/assets/js/sidebar.js"></script>
        <!-- Scripts -->
        <script src="{{ url('/') }}/public/admin/assets/js/jquery.js"></script>
        <script src="{{ url('/') }}/public/admin/assets/js/bootstrap.bundle.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js">
        </script>
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js">
        </script>
        <script>$('#example').DataTable({
                scrollX: true,
                scrollCollapse: true,
                responsive: false,
                autoWidth: false
            });

        </script>



        @stack('js')
    </body>

</html>