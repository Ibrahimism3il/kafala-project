
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'منصة التوظيف')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            direction: rtl;
            text-align: right;
        }
        nav.navbar {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
    <a class="navbar-brand text-white" href="/">منصة التوظيف</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link text-white" href="/jobs">الوظائف</a></li>
            @auth
                <li class="nav-item"><a class="nav-link text-white" href="/dashboard/applications">طلباتي</a></li>
                <li class="nav-item">
                    <span class="nav-link text-white">مرحباً، {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white" style="display:inline; padding: 0;">تسجيل الخروج</button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">تسجيل الدخول</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">التسجيل</a></li>
            @endauth
        </ul>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="bg-primary text-white text-center py-3 mt-5">
    &copy; 2025 منصة التوظيف - جميع الحقوق محفوظة.
</footer>

</body>
</html>
