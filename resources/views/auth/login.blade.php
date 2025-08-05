<!DOCTYPE html>
<html lang="en">

<head>
    <title>تسجيل دخول</title>
    <meta charset="UTF-8">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/media.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- JS -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <style>
        .login-modal-form input {
            border: 1px solid #7a7a7a !important;
            /* يظهر الإطار دائمًا */
            border-radius: 6px;
            padding: 10px 15px;
            width: 80%;
            margin-bottom: 15px;
            color: #7a7a7a;
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
    </style>
</head>

<body>

    <div class="modal-content">
        <br><br>
        <span class=""></span>
        <h2 class="title-modal text-center">تسجيل دخول!</h2>

        <div class="text-center mb-3">
            <img src="{{ asset('frontend/img/loho.png') }}" alt="شعار" width="100" />
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-modal-form">
            @csrf

            @if ($errors->any())
                <div style="color: red; margin-bottom: 1rem; text-align:center;">
                    <ul style="list-style: none; padding-right: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="email" name="email" placeholder="البريد الإلكتروني" required autofocus>
            <input type="password" name="password" placeholder="كلمة المرور" required>

            <div class="mb-2" style=" padding-right: 25px; ;">
                <a href="#">هل نسيت كلمة المرور ؟</a>
            </div>

            <button type="submit" class="login-btn">تسجيل الدخول</button>

            <p class="form-note">لا تمتلك حساباً ؟ <a href="{{ route('register.form') }}">إنشاء حساب</a></p>
        </form>
    </div>

    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/bootstrap.bundle.js.map"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/main.js"></script>

    <script src="frontend/js/bootstrap.bundle.js"></script>
    <script src="frontend/js/bootstrap.bundle.js.map"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="frontend/js/main-dashboard.js"></script>

    <script src="{{ asset('frontend/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.js.map') }}"></script>
    <script src="{{ asset('frontend/js/main-dashboard.js') }}"></script>
</body>

</html>
