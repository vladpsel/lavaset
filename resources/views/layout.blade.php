<!DOCTYPE html>
<html lang="uk-UA" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>@yield('title', 'Lavaset')</title>
    <link rel="icon" type="image/png" href="/dist/img/favicon.png">
    <link rel="stylesheet" href="{{ asset('/dist/css/font.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/dist/css/style.css') }}">
</head>
<body>

@yield('content')

<!-- scrpts -->
<script src="{{ mix('/dist/js/master.js') }}"></script>
@yield('scripts')
</body>
</html>

