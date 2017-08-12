<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'В каждый дом | Рекламная газета | Бесплатная газета | Реклама в Витебске')</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Бесплатная рекламная газета «В каждый дом» г. Витебск')">
        <meta name="author" content="@yield('meta_author', 'В каждый дом')">
        <meta name="keywords" content="@yield('meta_keywords', 'рекламная газета, бесплатная газета, газета, подать объявление, газета объявлений, реклама, объявление, реклама в Витебске')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link media="all" type="text/css" rel="stylesheet" href="/css/frontend/frontend.css">

        @yield('after-styles')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    </head>

    <body>
        @include('frontend.includes.yandexmetrika')
        <div class="wrapper">
            <div class="col-xs-12 header">
                <p>Газета «В каждый дом» (г. Витебск)<p>
            </div>

            @include('frontend.includes.nav')

            <div class="container">
                @yield('content')
            </div><!-- container -->

            <div class="push"></div>
        </div><!-- wrapper -->

        @include('frontend.includes.foot')

        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>
{{--        {!! Html::script('js/vendor/bootstrap/bootstrap.min.js') !!}    --}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        @yield('before-scripts')
{{--        {!! Html::script(elixir('js/frontend.js')) !!}  --}}
        @yield('after-scripts')

    </body>
</html>