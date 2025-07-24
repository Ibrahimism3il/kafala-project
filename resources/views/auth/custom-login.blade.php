<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F5F5F5] flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-sm text-center">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('imges/logo.png') }}" alt="شعار المنصة" class="w-30 h-20">
        </div>

        <h2 class="text-lg font-bold mb-4">تسجيل الدخول !</h2>
        <form method="POST" action="{{ route('custom.login') }}" class="space-y-4">
            @csrf

            <input type="email" name="email" required placeholder="البريد الإلكتروني"
                class="w-full h-12 text-right placeholder-gray-500 text-gray-700 bg-[#F3F3F3] rounded-full px-4 shadow-inner focus:outline-none" />

            <input type="password" name="password" required placeholder="كلمة المرور"
                class="w-full h-12 text-right placeholder-gray-500 text-gray-700 bg-[#F3F3F3] rounded-full px-4 shadow-inner focus:outline-none" />

            <button type="submit"
                class="w-full h-12 bg-[#C68DFF] hover:bg-[#b97aff] text-white font-bold rounded-full shadow-md transition">
                تسجيل الدخول
            </button>
        </form>


        <div class="mt-4 text-sm">
            <a href="{{ route('custom.register') }}" class="text-blue-600 hover:underline">
                ليس لديك حساب؟ سجل من هنا
            </a>
        </div>
    </div>

</body>

</html>
