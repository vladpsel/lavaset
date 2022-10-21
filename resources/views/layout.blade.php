<!DOCTYPE html>
<html lang="uk-UA" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>@yield('title', 'Lavaset')</title>
    <link rel="icon" type="image/png" href="/dist/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/dist/css/style.css') }}">
</head>
<body>

@yield('content')

<!-- scrpts -->
<script src="{{ # mix('dist/js/script.js') }}"></script>
<script src="{{ # mix('dist/js/app.js') }}"></script>
@yield('scripts')
</body>
</html>

