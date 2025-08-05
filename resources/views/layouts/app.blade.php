<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'كفالة')</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style-dashboard.css') }}">
</head>

<body style="background-color: #fff">
    <div class="d-flex">
        @include('layouts.sidebar') {{-- هذا هو الشريط الجانبي --}}

        <div class="container mt-4 w-100">
            @yield('content')
        </div>
    </div>
    <script>
        window.userId = {{ auth()->check() ? auth()->id() : 'null' }};
    </script>
@vite('resources/js/app.js')
</body>

</html>
