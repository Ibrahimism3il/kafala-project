   <!DOCTYPE html>
   <html lang="en">

   <head>
       <title>تسجيل دخول</title>
       <meta charset="UTF-8">
       <!-- CSS -->
       <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
       <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}">
       <link rel="stylesheet" href="{{ asset('frontend/css/style-home.css') }}">
       <link rel="stylesheet" href="{{ asset('frontend/css/media.css') }}">
       <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
       <!-- JS -->
       <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">
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
       <!--===============================================================================================-->
   </head>

   <body>



       <!--modal login-->

       <div class="modal-content">
           <span class="close">&times;</span>
           <h2 class="title-modal">تسجيل دخول!</h2>
           <div class="text-center">
               <img src="img/loho.png" alt="" width="100" />
           </div>
           <form id="loginForm">
               <input type="email" id="email" placeholder="البريد الإلكتروني" required>
               <input type="password" id="password" placeholder="كلمة المرور" required>
               <button type="submit">تسجيل الدخول</button>
           </form>
           <div class="divFor">
               <a class="forgotpass" href="#">هل نسيت كلمة المرور ؟</a>
           </div>
           <button class="login-btn">تسجيل الدخول</button>
           <p class="link-sign">
               لا تمتلك حساباً ؟ <a href="#" id="signupLink">إنشاء حساب</a>
           </p>
       </div>


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
   </body>

   </html>
