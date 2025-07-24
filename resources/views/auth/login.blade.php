<x-guest-layout>
    <div dir="rtl" class="min-h-screen flex flex-col justify-center items-center bg-[#F5F5F5] p-6">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm p-8 space-y-6">
            <div class="flex justify-center">
                <img src="{{ asset('imges/logo.png') }}" alt="شعار المنصة" class="w-20 h-20">
            </div>

            <h2 class="text-center text-lg font-bold">تسجيل الدخول !</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('custom.login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" class="block w-full text-right bg-gray-100 rounded-md" type="email"
                        name="email" :value="old('email')" required autofocus placeholder="البريد الإلكتروني" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-right" />
                </div>

                <!-- Password -->
                <div>
                    <x-text-input id="password" class="block w-full text-right bg-gray-100 rounded-md" type="password"
                        name="password" required autocomplete="current-password" placeholder="كلمة المرور" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-right" />
                </div>

                <!-- Submit -->
                <div>
                   <button class="w-full bg-[#C68DFF] hover:bg-[#b373ff] text-white font-bold py-2 px-4 rounded-md">
    تسجيل الدخول
</button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('custom.register') }}" class="text-blue-600 text-sm hover:underline">ليس لديك حساب؟ سجل من
                    هنا</a>
            </div>
        </div>
    </div>
</x-guest-layout>
