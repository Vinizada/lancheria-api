<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Lancheria Verde Mar - @yield('titulo')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
@include('layouts._partials.top')
@yield('conteudo')
</body>
</html>
