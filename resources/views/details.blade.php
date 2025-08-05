<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كفالة</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- استايلات الصفحة (اختر حسب الحاجة) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/media.css') }}">
    <style>
        .login-modal-form input,
        .login-modal-form select,
        .login-modal-form button.login-btn {
            width: 70%;
            padding: 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 12px;
            background-color: #fff;
            color: #333;
            box-shadow: none;
            text-size-adjust: initial text-align: right;
        }

        .login-modal-form button.login-btn {
            background-color: #22756c;
            color: white;
            border-radius: 10px;
            text-align: center;
            font-size: 14px
        }

        .login-modal-form button.login-btn:hover {
            background-color: #144c45;
        }

        .forgotpass {
            font-size: 12px;
        }

        .form-note {
            font-size: 12px
        }

        /* حجم افتراضي للمودالات */
        .register-modal-form input,
        .register-modal-form select,
        .register-modal-form textarea {
            font-family: 'droid', sans-serif;
            font-size: 15px !important;
            color: #555 !important;
        }


        /* مودال مستجيب للشاشات الصغيرة */
        @media (max-width: 768px) {
            .modal-content-register {
                width: 95% !important;
                padding: 15px !important;
                margin: auto;
            }

            .register-modal-form {
                width: 100% !important;
                margin: 0 !important;
            }

            .register-modal-form>div {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .register-modal-form input,
            .register-modal-form select {
                width: 100% !important;
                font-size: 14px !important;
            }

            .register-modal-form label {
                text-align: right;
                font-size: 13px;
                margin-bottom: 5px;
            }

            .form-group.text-center label {
                width: 100% !important;
            }

            #imagePreviewContainer {
                width: 60px;
                height: 60px;
                display: none;
                position: relative;
            }

            #imagePreview {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 5px;
                border: 1px solid #ccc;
            }


            .login-btn {
                width: 100% !important;
            }
        }


        /* لشاشات أقل من 480px */
        @media (max-width: 480px) {

            .modal-content,
            .modal-content-register {
                width: 95%;
                padding: 10px;
            }
        }

        /* .modal-content-register {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 700px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1001;
        } */
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="frontend/img/loho.png" width="80" height="80"
                    alt="شعار كفالة"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#types">أنواع الكفالات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#donation">التبرع العام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how">كيف أكفل ؟</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#principles">الإحصائيات</a>
                    </li>

                </ul>
                <div class="buttons">
                    <button class="sign" id="openModalRegister">تسجيل</button>
                    <button class="log" id="openModalLogin">دخول</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="div-hero" id="home">
        <div class="container">
            <div class="content-hero-div text-center">
                <h3 class="title-hero" data-aos="zoom-in" data-aos-duration="1000">كن سنداً لهم وامنحهم الأمل!</h3>
                <h4 class="subtitle-hero" data-aos="zoom-in" data-aos-duration="2000">كفالتك الآن تمنح الأيتام فرصة حياة
                    كريمة وتجعل مستقبلاً أكثر إشراقاً في متناول أيديهم</h4>
                <a href="#"> <button class="now-btn" data-aos="zoom-in"
                        data-aos-duration="3000" id="openModalyateem">أكفل يتيماً الآن</button></a>
            </div>
        </div>
    </div>
    <div class="card-top">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="box" data-aos="zoom-in" data-aos-duration="1000">
                    <img class="img-fluid" src="frontend/img/img1.png" alt="أية" loading="lazy">
                    <div class="text-center p-3">
                        <h3 class="mt-3 mb-2">أية</h3>
                        <p class="mb-3">بانتظار الكفالة</p>
                        <a href="#"> <button type="button" class="btn btn-card">أكفل
                                الآن</button></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="box" data-aos="zoom-in" data-aos-duration="2000">
                    <img class="img-fluid" src="frontend/img/img2.png" alt="عائشة" loading="lazy">
                    <div class="text-center p-3">
                        <h3 class="mt-3 mb-2">عائشة</h3>
                        <p class="mb-3">بانتظار الكفالة</p>
                        <a href="#"><button type="button" class="btn btn-card">أكفل
                                الآن</button></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="box" data-aos="zoom-in" data-aos-duration="3000">
                    <img class="img-fluid" src="frontend/img/img3.png" alt="أحمد" loading="lazy">
                    <div class="text-center p-3">
                        <h3 class="mt-3 mb-2">أحمد</h3>
                        <p class="mb-3">بانتظار الكفالة</p>
                        <a href="#"> <button type="button" class="btn btn-card">أكفل
                                الآن</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="types" id="types">
        <div class="container">
            <h3 class="title-section mx-auto">أنواع الكفالات</h3>
            <div class="row mt-5 ">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                        <div class="img-type">
                            <img class="img-fluid service-icon" src="frontend/img/img7.png" alt="كفالة مالية"
                                loading="lazy">
                        </div>
                        <h3 class="title-ca">كفالة مالية</h3>
                        <p class="content-ca">ساهم في تغطية الاحتياجات الأساسية لليتيم من خلال دعم مالي مباشر</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center" data-aos="zoom-in" data-aos-duration="2000">
                        <div class="img-type">
                            <img src="frontend/img/img5.png" alt="كفالة تعليمية" loading="lazy">
                        </div>
                        <h3 class="title-ca">كفالة تعليمية</h3>
                        <p class="content-ca">ادعم تعليم الأيتام لضمان مستقبل أفضل لهم</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                        <div class="img-type">
                            <img src="frontend/img/img6.png" alt="كفالة صحية" loading="lazy">
                        </div>
                        <h3 class="title-ca">كفالة صحية</h3>
                        <p class="content-ca">ساهم في توفير الرعاية الصحية للأيتام</p>
                    </div>
                </div>
            </div>
            <div class="centerd">
                <div class="row mt-5 text-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="img-type">
                                <img src="frontend/img/love.png" alt="">
                            </div>
                            <h3 class="title-ca">كفالة اجتماعية</h3>
                            <p class="content-ca">قدم الدعم النفسي والاجتماعي للأيتام</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="img-type">
                                <img src="frontend/img/img4.png" alt="التبرع العام" loading="lazy">
                            </div>
                            <h3 class="title-ca">التبرع العام</h3>
                            <p class="content-ca">تبرع لدعم جميع برامج الرعاية للأيتام</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="how-section" id="how">
        <div class="container">
            <h3 class="title-section mx-auto">كيف أقوم بكفالة يتيم</h3>
            <div class="row mt-5">

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/one.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">تسجيل الدخول</h3>
                                <p class="card-text text-muted mb-0">انشئ حسابك بسهولة وابدأ رحلتك في العطاء</p>
                            </div>
                        </div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/three.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">استعراض الايتام</h3>
                                <p class="card-text text-muted mb-0">تصفح الأيتام المتاحين مع تفاصيلهم بشكل مبسط وواضح
                                </p>
                            </div>
                        </div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/ivve.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">اختيار اليتيم</h3>
                                <p class="card-text text-muted mb-0">اختر اليتيم الذي ترغب بكفالته بحسب حالته او منطقته
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/two.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">تحديد نوع الكفالة</h3>
                                <p class="card-text text-muted mb-0">اختر بين كفالة شهرية أو سنوية بما يناسب قدرتك</p>
                            </div>
                        </div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/our.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">الدفع الآمن</h3>
                                <p class="card-text text-muted mb-0">أكمل عملية الكفالة عبر وسائل دفع موثوقة وآمنة</p>
                            </div>
                        </div>
                        <div class="cardO" data-aos="zoom-in" data-aos-duration="1000">
                            <img src="frontend/img/six.svg" class="img-fluid" style="width: 60px;" alt="">
                            <div class="ms-3">
                                <h3 class="card-title mb-1">متابعة الكفيل</h3>
                                <p class="card-text text-muted mb-0">تابع حالة اليتيم وتحديقات الكفالة من خلال حسابك
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="donation" id="donation">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <h3 class="title-section">التبرع العام</h3>
                        <p class="details-p">هو مساهمة مرنة تهدف إلى دعم جميع الأيتام والبرامج التي نقدمها دون تقييد
                            بكفالة طفل معين</p>
                        <p class="details-p">من خلال هذا النوع من التبرع يتم توجيه المبلغ للمجالات الأكثر حاجة بشكل
                            فوري مثل:</p>
                        <ul>
                            <li>توفير الاحتياجات الغذائية</li>
                            <li>توفير الرعاية الصحية</li>
                            <li>توفير المستلزمات الدراسية</li>
                            <li>تغطية نفقات العلاج</li>
                        </ul>
                        <div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                        <img src="frontend/img/Group 2266.png" alt="" class="img-donaion">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="principles text-center" id="principles">
        <div class="container">
            <h3 class="title-section mx-auto">الإحصائيات</h3>
            <div class="row mt-5">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <div class="cir cir1  mx-auto mb-3">
                            <span>200+</span>
                        </div>
                        <p class="title-circle">أيتام تم كفالتهم</p>
                        <p class="det">تم كفالة أكثر من 200 يتيم حتى الآن</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <div class="cir cir2  mx-auto mb-3">
                            <span>200+</span>
                        </div>
                        <p class="title-circle">الأيتام المتاحين للكفالة</p>
                        <p class="det">يوجد حالياً 57 يتيماً بحاجة إلى كفالة</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <div class="cir cir3 mx-auto mb-3">
                            <span>320+</span>
                        </div>
                        <p class="title-circle">عدد المتبرعين</p>
                        <p class="det">كثر من 320 متبرع ساهموا معنا</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="questions">
        <div class="container">
            <div class="div-que text-center">
                <div class="position">
                    <img src="frontend/img/Group 77.png" alt="">
                </div>
                <h3 class="title-q" data-aos="zoom-in" data-aos-duration="1000">هل لديك تساؤلات أو استفسارات؟</h3>
                <p class="deta-q" data-aos="zoom-in" data-aos-duration="1000">لا تتردد في التواصل معنا</p>
                <button class="contact-btn" data-aos="zoom-in" data-aos-duration="1000">تواصل معنا</button>
            </div>
        </div>
    </section>
    <footer class="footer-details">
        <div class="text-center">
            <p>الحقوق محفوظة لدى كفالة © 2025</p>
        </div>
    </footer>
    <!--back to top button-->
    <button id="back-to-top" class="btn back-to-top" aria-label="العودة إلى الأعلى">
        <span>↑</span>
    </button>
    <!--modal register-->
    <div class="modal" id="registerModal" style="display: none; ">
        <div class="modal-content-register">
            <span class="close" style="float: left; cursor: pointer;">&times;</span>
            <br>
            <h2 class="title-modal text-center" style="margin-right: 50px">تسجيل جديد</h2>
            <div class="text-center mb-3">
                <img src="{{ asset('frontend/img/loho.png') }}" alt="شعار" width="90" />
            </div>
            <form method="POST" action="{{ route('register') }}" style="width: 600px; margin-right:90px"
                class="register-modal-form" enctype="multipart/form-data">
                @csrf

                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <!-- نوع المستخدم -->
                    <div style="flex: 1;">
                        <div>
                            <label for="user_type"
                                style="display: block; text-align: right; margin-bottom: 5px;font-size: 13px; color: #858585;">نوع
                                المستخدم:</label>
                        </div>
                        <select name="user_type" id="user_type" onchange="toggleFields()" required
                            style="width: 100%; font-size: 13px; color: #858585;">
                            <option value="">-- اختر نوع المستخدم --</option>
                            <option value="kafel">كافل</option>
                            <option value="orphan">يتيم</option>
                        </select>
                    </div>

                    <!-- نوع الكافل (يظهر فقط إذا اختير كافل) -->
                    <div id="kafel-type-field" style="flex: 1; display: none;">
                        <label for="kafel_type"
                            style="display: block; text-align: right; margin-bottom: 5px; font-size: 13px; color: #858585;">نوع
                            الكافل:</label>
                        <select name="kafel_type" id="kafel_type"
                            style="width: 100%;font-size: 13px; color: #858585;">
                            <option value="">-- نوع الكافل --</option>
                            <option value="فرد">فرد</option>
                            <option value="مؤسسة">مؤسسة</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <!-- الاسم -->
                    <div style="flex: 1;">
                        <label
                            style="font-size: 13px; color: #858585;display: block; text-align: right; margin-bottom: 5px;">الاسم
                            :</label>
                        <input type="text" name="name" placeholder="" required style="width: 100%;">
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div style="flex: 1;">
                        <label
                            style="font-size: 13px; color: #858585; display: block; text-align: right; margin-bottom: 5px;">البريد
                            الإلكتروني :</label>
                        <input type="email" name="email" placeholder="" required style="width: 100%;">
                    </div>



                </div>


                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <!-- كلمة المرور -->
                    <div style="flex: 1;">
                        <label
                            style="font-size: 13px; color: #858585; display: block; text-align: right; margin-bottom: 5px;">كلمة
                            المرور :</label>
                        <input type="password" name="password" placeholder="" required style="width: 100%;">
                    </div>
                    <!-- تأكيد كلمة المرور -->
                    <div style="flex: 1;">
                        <label
                            style="font-size: 13px; color: #858585;display: block; text-align: right; margin-bottom: 5px;">تأكيد
                            كلمة المرور :</label>
                        <input type="password" name="password_confirmation" placeholder="" required
                            style="width: 100%;">
                    </div>
                </div>

                <div id="orphan-fields" style="display:none;">
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <!-- العمر -->
                        <div style="flex: 1;">
                            <label
                                style="font-size: 13px; color: #858585;display: block; text-align: right; margin-bottom: 5px;">العمر
                                :</label>
                            <input type="number" name="age" placeholder="" style="width: 100%;">
                        </div>

                        <!-- المنطقة -->
                        <div style="flex: 1;">
                            <label
                                style="font-size: 13px; color: #858585;display: block; text-align: right; margin-bottom: 5px;">المنطقة
                                :</label>
                            <input type="text" name="area" placeholder="" style="width: 100%;">
                        </div>
                    </div>
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <!-- الجنس -->
                        <div style="flex: 1;">
                            <select name="gender" style="width: 100%; font-size: 70%;">
                                <option value="">-- الجنس --</option>
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                        </div>

                        <!-- الحالة الاجتماعية -->
                        <div style="flex: 1;">
                            <select name="social_status" style="width: 100%; font-size: 70%;">
                                <option value="">-- الحالة الاجتماعية --</option>
                                <option value="يتيم الأب">يتيم الأب</option>
                                <option value="يتيم الأبوين">يتيم الأبوين</option>
                            </select>
                        </div>

                        <!-- الحالة الصحية -->
                        <div style="flex: 1;">
                            <select name="health_status" style="width: 100%; font-size: 70%;">
                                <option value="">-- الحالة الصحية --</option>
                                <option value="سليم">سليم</option>
                                <option value="مريض">مريض</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group d-flex align-items-center" style="gap: 10px; justify-content: center;">
                    <!-- زر رفع الصورة -->
                    <label class="btn btn-outline-secondary m-0" style="padding: 8px 50px; font-size: 14px;">
                        <span id="photo-label-text">📷 صورة شخصية</span>
                        <input type="file" name="photo" class="photo" id="photo" accept="image/*"
                            style="display: none;" onchange="handleImagePreview(event)">
                    </label>

                    <!-- معاينة الصورة -->
                    <div class="preview-container" id="imagePreviewContainer"
                        style="display: none; position: relative; width: 60px; height: 60px;">
                        <button type="button" class="remove-image-btn" onclick="removeImage()"
                            style="
            position: absolute;
            top: -6px;
            left: -6px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            line-height: 16px;
            padding: 0;
            cursor: pointer;">×</button>
                        <img id="imagePreview" src="" alt="معاينة"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px; border: 1px solid #ccc;">
                    </div>
                </div>



                <button type="submit" class="login-btn">إنشاء حساب</button>
                <p class="form-note"> هل تمتلك حساب؟ <a href="#" style="color: #22756c"
                        onclick="switchToLogin()">تسجيل دخول</a></p>
            </form>
        </div>
    </div>

    <!--modal login-->
    <div class="modal" id="loginModal" style="display: none;">
        <div class="modal-content">
            <span class="close" style="float: left; cursor: pointer;">&times;</span>
            <h2 class="title-modal text-center">تسجيل دخول!</h2>
            <div class="text-center mb-3">
                <img src="{{ asset('frontend/img/loho.png') }}" alt="شعار" width="100" />
            </div>
            <form method="POST" action="{{ route('login') }}" class="login-modal-form">
                @csrf
                @if ($errors->has('email'))
                    <div class="alert alert-danger text-center"
                        style="margin-bottom: 10px;     height: 55px;
    margin-right:85px;
    width: 205px;">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <input type="email" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني"
                    required>

                <input type="password" name="password" value="{{ old('password') }}" placeholder="كلمة المرور"
                    required>


                <div class="divFor">
                    <a class="forgotpass" href="#">هل نسيت كلمة المرور ؟</a>
                </div>

                <button type="submit" class="login-btn">تسجيل الدخول</button>
                <p class="form-note">لا تمتلك حساباً ؟ <a href="#" onclick="switchToRegister()">إنشاء حساب</a>
                </p>
            </form>
        </div>
    </div>

    <!--modal yateem-->
    <div id="myModalyateem" class="modal">
        <div class="modal-content">
            <span class="closeee">&times;</span>
            <h2 class="title-modal">إضافة يتيم جديد!</h2>
            <form action="">
                <input dir="rtl" class="user-inputs" type="text" placeholder="الاسم" />
                <input dir="rtl" class="user-inputs" type="text" placeholder="العمر" />
                <input dir="rtl" class="user-inputs" type="text" placeholder="الجنس" />
                <input dir="rtl" class="user-inputs" type="text" placeholder="المنطقة" />
                <input dir="rtl" class="user-inputs" type="text" placeholder="الحالة الاجتماعية" />
                <input dir="rtl" class="user-inputs" type="text" placeholder="الحالة الصحية" />
                <div class="upload-container">
                    <label for="file-input" class="file-label">
                        <img src="img/log-out-Filled.png" alt="" /> رفع صورة
                    </label>
                    <input type="file" id="file-input" accept="image/*,.pdf,.doc,.docx" />
                    <div class="preview" id="preview"></div>
                    <div class="file-name" id="file-name"></div>
                </div>
                <div class="upload-container">
                    <label for="file-input" class="file-label">
                        <img src="img/log-out-Filled.png" alt="" /> رفع صورة
                    </label>
                    <input type="file" id="file-input" accept="image/*,.pdf,.doc,.docx" />
                    <div class="preview" id="preview"></div>
                    <div class="file-name" id="file-name"></div>
                </div>
            </form>
            <button class="login-btn">إضافة يتيم</button>
        </div>
    </div>

      @if ($errors->has('email'))
        <script>
            window.onload = function() {
                document.getElementById('loginModal').style.display = 'block';
            };
        </script>
    @endif
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عناصر المودالات
            const loginBtn = document.getElementById('openModalLogin');
            const registerBtn = document.getElementById('openModalRegister');
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');

            // فتح مودال تسجيل الدخول
            if (loginBtn && loginModal) {
                loginBtn.addEventListener('click', () => {
                    closeAllModals();
                    loginModal.style.display = 'block';
                });
            }

            // فتح مودال التسجيل
            if (registerBtn && registerModal) {
                registerBtn.addEventListener('click', () => {
                    closeAllModals();
                    registerModal.style.display = 'block';
                });
            }

            // زر الإغلاق في كل مودال
            document.querySelectorAll('.modal .close').forEach(closeBtn => {
                closeBtn.addEventListener('click', () => {
                    closeBtn.closest('.modal').style.display = 'none';
                });
            });

            // إغلاق المودال إذا ضغطت خارج المحتوى
            window.addEventListener('click', function(event) {
                document.querySelectorAll('.modal').forEach(modal => {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            });

            // إذا تم تحميل الصفحة مسبقًا مع مودال مفتوح (مثلاً بسبب أخطاء)
            if (window.location.hash === "#register") {
                registerModal.style.display = 'block';
            } else if (window.location.hash === "#login") {
                loginModal.style.display = 'block';
            }
        });

        // وظائف التبديل بين المودالات
        function switchToRegister() {
            closeAllModals();
            document.getElementById('registerModal').style.display = 'block';
        }

        function switchToLogin() {
            closeAllModals();
            document.getElementById('loginModal').style.display = 'block';
        }

        // إغلاق جميع المودالات
        function closeAllModals() {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.style.display = 'none';
            });
        }

        // تحديث اسم الملف عند رفع صورة
        function updatePhotoLabel(input) {
            const label = document.getElementById('photo-label-text');
            if (input.files.length > 0) {
                label.textContent = '📁 ' + input.files[0].name;
            } else {
                label.textContent = '📷 صورة شخصية';
            }
        }

        // عرض الحقول الخاصة حسب نوع المستخدم
        function toggleFields() {
            const type = document.getElementById("user_type").value;
            document.getElementById("orphan-fields").style.display = (type === "orphan") ? "block" : "none";
            document.getElementById("kafel-type-field").style.display = (type === "kafel") ? "block" : "none";
        }
    </script>

    <script>
        function handleImagePreview(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('imagePreviewContainer');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('photo');
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');

            input.value = '';
            container.style.display = 'none';
            preview.src = '';
            document.getElementById('photo-label-text').textContent = '📷 صورة شخصية';
        }
    </script>
</body>

</html>
