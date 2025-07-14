<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التسجيل - منصة التوظيف</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container">
        <h2>إنشاء حساب جديد</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">الاسم الكامل:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">تأكيد كلمة المرور:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">التسجيل</button>

            <div class="link">
                <a href="{{ route('login') }}">هل لديك حساب؟ تسجيل الدخول</a>
            </div>
        </form>
    </div>
</body>
</html>
