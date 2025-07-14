<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - منصة التوظيف</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container">
        <h2>تسجيل الدخول</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>

            <div class="actions">
                <label><input type="checkbox" name="remember"> تذكرني</label>
            </div>

            <button type="submit">تسجيل الدخول</button>

            <div class="link">
                <a href="{{ route('register') }}">ليس لديك حساب؟ سجل الآن</a>
            </div>
        </form>
    </div>
</body>
</html>
