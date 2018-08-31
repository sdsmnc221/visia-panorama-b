<?php
    use App\Providers\HelpersProvider;
    $h = new HelpersProvider();

    // use App\Models\PanoramaAuthor;;
    // dd(array_key_exists('id_author', PanoramaAuthor::first()->toArray()));

    // phpinfo();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>@yield('title')</title>
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('/') }}vendor/vendor.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/app.css">
    <script src="{{ asset('/') }}vendor/vendor.js"></script>
</head>
<body>
    <div class="app ui grid">
        <!-- <div class="app__preloader"></div> -->

        @include('layouts.sidebar')

        <div class="thirteen wide fixed column app__wrapper">
            @include('layouts.header')

            <main class="app__content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('/') }}js/app.js"></script>
</body>
</html>