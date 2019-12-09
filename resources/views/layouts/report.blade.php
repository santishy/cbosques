<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <!-- Styles -->
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
      @yield('content')
    </div>
</body>
</html>
