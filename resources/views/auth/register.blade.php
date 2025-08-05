<!DOCTYPE html>
<html lang="en">

<head>
    <title>تسجيل دخول</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/media.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <style>
        .login-modal-form input,
        .login-modal-form select {
            border: 1px solid #7a7a7a !important;
            border-radius: 6px;
            padding: 10px 15px;
            width: 80%;
            margin-bottom: 15px;
            color: #333;
            background-color: #fff;
            box-shadow: none !important;
        }

        .login-modal-form input::placeholder {
            color: #aaa;
        }

        .login-modal-form button.login-btn {
            background-color: #1b5e56;
            color: white;
            padding: 10px;
            width: 80%;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .login-modal-form button.login-btn:hover {
            background-color: #144c45;
        }

        .login-modal-form a {
            color: #1b5e56;
            font-weight: 500;
        }

        .login-modal-form .form-note {
            text-align: center;
            margin-top: 10px;
        }

        .modal-content {
            background: #fff;
            padding: 40px 30px;
            border-radius: 20px;

            width: 420px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }

        body {
            height: 100vh;
            overflow-y: auto;
            background-color: #f7f7f7;
        }
    </style>
</head>

<body>

    <!-- Start Modal Login/Register -->
    <div class="modal-content">
        <br><br>
        <h2 class="title-modal text-center">تسجيل جديد</h2>

        <div class="text-center mb-3">
            <img src="{{ asset('frontend/img/loho.png') }}" alt="شعار" width="100" />
        </div>

        <form method="POST" action="{{ route('register') }}" class="login-modal-form" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div style="color:red; margin-bottom:1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <select name="user_type" id="user_type" onchange="toggleFields()" required>
                <option value="">-- اختر نوع المستخدم --</option>
                <option value="kafel">كافل</option>
                <option value="orphan">يتيم</option>
            </select>
            <!-- نوع الكافل: يظهر فقط إذا كان المستخدم كافل -->
            <div id="kafel-type-field" style="display:none;">
                <select name="kafel_type">
                    <option value="">-- نوع الكافل --</option>
                    <option value="فرد">فرد</option>
                    <option value="مؤسسة">مؤسسة</option>
                </select>
            </div>
            <input type="text" name="name" placeholder="الاسم" required>
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>

            <!-- orphan fields -->
            <div id="orphan-fields" style="display:none;">
                <input type="number" name="age" placeholder="العمر">
                <input type="text" name="area" placeholder="المنطقة">
                <select name="gender">
                    <option value="">-- الجنس --</option>
                    <option value="ذكر">ذكر</option>
                    <option value="أنثى">أنثى</option>
                </select>
                <select name="social_status">
                    <option value="">-- الحالة الاجتماعية --</option>
                    <option value="يتيم الأب">يتيم الأب</option>
                    <option value="يتيم الأبوين">يتيم الأبوين</option>
                </select>
                <select name="health_status">
                    <option value="">-- الحالة الصحية --</option>
                    <option value="سليم">سليم</option>
                    <option value="مريض">مريض</option>
                </select>
            </div>
            <div class="wrap-input100 text-center">
                <label for="photo" class="d-block mb-2" style="font-weight: bold; color: #444;">&nbsp;</label>

                <label for="photo" class="btn btn-outline-secondary" style="width: 80%; padding: 10px;">
                    <span id="photo-label-text">📷 صورة شخصية</span>
                    <input type="file" name="photo" id="photo" accept="image/*" style="display: none;"
                        onchange="updatePhotoLabel(this)">
                </label>
            </div>

            <button type="submit" class="login-btn">إنشاء حساب</button>

            <p class="form-note">لديك حساب؟ <a href="{{ route('login.form') }}">تسجيل دخول</a></p>
        </form>
    </div>
    <!-- End Modal -->

    <!-- Scripts -->
    <script>
        function toggleFields() {
            const userType = document.getElementById("user_type").value;
            const orphanFields = document.getElementById("orphan-fields");
            const kafelTypeField = document.getElementById("kafel-type-field");

            // إظهار وإخفاء الحقول حسب نوع المستخدم
            orphanFields.style.display = userType === "orphan" ? "block" : "none";
            kafelTypeField.style.display = userType === "kafel" ? "block" : "none";
        }
    </script>
    <script>
        function updatePhotoLabel(input) {
            const label = document.getElementById('photo-label-text');
            if (input.files.length > 0) {
                label.textContent = '📁 ' + input.files[0].name;
            } else {
                label.textContent = '📷 صورة شخصية';
            }
        }
    </script>


    <script src="{{ asset('frontend/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('frontend/js/main-dashboard.js') }}"></script>
</body>

</html>
