<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="/public/assets/css/auth.css" rel="stylesheet" type="text/css">

    <title>@yield('title', 'Talkiyon')</title>
    <link rel="icon" href="{{asset('assets/images/icon.png')}}" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/utils.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/login-form.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sign-up.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    @yield('style')
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
</head>

<body>
    <div id="container">
        @include('layouts.alert')
        @yield('content')
    </div>

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous">
    </script>
</body>
</html>
