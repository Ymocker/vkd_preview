<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Панель управления сайтом</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'TV')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link media="all" type="text/css" rel="stylesheet" href="/css/backend/backend.css">
        <link rel="stylesheet" href="/css/vendor/font-awesome/css/font-awesome.min.css">

        @yield('after-styles')

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body>
        <div class="header">Панель управления сайтом «В каждый дом»</div>
        <div class="wrapper">

            <div id="sidemenu">
                @include('backend.includes.sidebar')
            </div>
            <div class="cont">

                <!-- Content Header (Page header) -->
                <section class="status">
                    <h3 class="box-title">
                        Редактируемый номер: <b><span id="ed-number">{{ $admData['editNumber'] }}</span></b> (<span id="status-number">{{ $admData['statusNumber'] }}</span>)
                    </h3>
                </section>

                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section><!-- /.content -->
            </div>

        </div> {{-- end wrapper --}}
        <div class="footer">«В каждый дом»</div>

        <!-- JavaScripts -->
        @yield('before-scripts')

        @yield('after-scripts')
    </body>
</html>