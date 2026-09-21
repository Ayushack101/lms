<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>AK Tech Solutions | Web Support | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS (optional) -->
    
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" /> -->

    <!-- Your custom CSS -->

    <link rel="stylesheet" href="{{ asset('build/assets/login-style.css') }}">
    
</head>

<body>

    {{-- Layout Content --}}
    @yield('homeContent')
    <script src="{{ asset('build/assets/plugins/jquery/jquery.min.js') }}"></script>

    @stack('scripts')
</body>

</html>