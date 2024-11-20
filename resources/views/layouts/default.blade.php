<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>EasyCoffe - @yield('titulo')</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<div class="main-container">
    @yield('conteudo')
</div>

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
