<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة التوظيف - الرئيسية</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
   <nav style="display: flex; justify-content: space-between; align-items: center; background-color:rgb(243, 243, 243); padding: 15px 40px;">
    {{-- شعار المنصة في الجهة اليمنى --}}
    <div style="flex-shrink: 0;">
        <img src="{{ asset('imges/logo.png') }}" alt="شعار المنصة" style="height: 50px;">
    </div>

    {{-- روابط القائمة في الجهة اليسرى --}}
    <div style="display: flex; gap: 15px;">
        <a href="{{ route('home') }}" class="nav-link">
            الرئيسية
        </a>
        <a href="{{ route('custom.register') }}" class="nav-link">
             التسجيل
        </a>
        <a href="{{ route('custom.login') }}" class="nav-link">
           تسجيل الدخول
        </a>
    </div>
</nav>
<header style="text-align: center; padding: 30px 0; background-color: #f5f5f5;">
<img src="{{ asset('imges/logo.png') }}" alt="شعار المنصة" style="max-width: 200px; height: auto;">
    <h1>اعثر على وظيفتك المثالية</h1>
    <p>نربط الباحثين عن العمل بأفضل الشركات بسهولة وسرعة</p>
</header>

    <section class="section">
        <h2>أحدث الوظائف</h2>
        <div class="cards">
            @foreach($jobs as $job)
                <div class="card">
                    <h3>{{ $job->title }}</h3>
                    <p>{{ $job->company }} - {{ $job->location }}</p>
                  @guest
                    <a href="{{ route('custom.login') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                       تسجيل
                    </a>
                  @endguest
                </div>
            @endforeach
        </div>
    </section>

    <footer>
        &copy; 2025 منصة التوظيف - جميع الحقوق محفوظة.
    </footer>
</body>
</html>
