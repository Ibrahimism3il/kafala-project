<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كفالة - لوحة اليتيم</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/all.css">
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.css.map">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">

    <link rel="stylesheet" href="frontend/css/bootstrap.css.map">
    <link rel="stylesheet" href="frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/css/style-dashboard.css">
    <link rel="stylesheet" href="frontend/css/all.css">
    <link rel="stylesheet" href="frontend/css/all.min.css">


    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css.map') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ضعه في style-dashboard.css أو داخل <style> */
        .upload-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #555;
            position: relative;
            margin: auto;
        }

        .upload-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .modal .popup-content {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            min-height: 550px;
            /* هذا السطر هو المفتاح لحل مشكلتك */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }


        body {
            background-color: #ffffff
        }
    </style>

</head>

<body>
    <div class="all-bage d-flex">
        <!-- Hamburger menu button for mobile -->
        <button id="sidebar-toggle" class="burger-btn">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <div class="profile">
                <div class="profile-img"> <img src="{{ asset('frontend/img/1745048934591-pica.png') }}" alt="">
                    كفالة</div>
            </div>
            <hr>
            <div class="menu">
                @include('layouts.sidebar')


            </div>
            <hr>

        </div>

        <div class="container">
            <nav class="navbar">
                <!-- منطقة البحث -->
                <div class="search-container">
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <input type="text" placeholder="ابحث الأن...">
                </div>

                <!-- الجرس والإشعارات -->
                <div style="display: flex; align-items: center;" class="ff1">
                    <div class="bill" id="bellIcon">
                        <i class="fas fa-bell"></i>

                        {{-- عدد الإشعارات الحقيقية --}}
                        @if ($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif

                        {{-- عرض آخر إشعار فقط --}}
                        <div class="notification-panel" id="notificationPanel">
                            @forelse($unreadNotifications as $notification)
                                <div class="notification-item">
                                    <div class="notification-title">{{ $notification->data['title'] ?? 'إشعار' }}</div>
                                    <div class="notification-message">
                                        {{ $notification->data['message'] ?? 'بدون رسالة' }}</div>
                                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <div class="notification-item">
                                    لا توجد إشعارات جديدة.
                                </div>
                            @endforelse
                        </div>
                    </div>


                    <!-- الخط الفاصل -->
                    <div class="line-img"></div>

                    <!-- الصورة والاسم -->
                    <div class="logo" id="profileIcon">
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="صورة المستخدم"
                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <p class="img-name">{{ auth()->user()->name }}<br>
                            <span>{{ auth()->user()->role === 'kafel' ? 'كافل' : 'يتيم' }}</span>
                        </p>

                        <!-- لوحة الملف الشخصي -->
                        <div class="profile-panel" id="profilePanel">
                            <div class="profile-header">
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="صورة المستخدم">
                                <div class="profile-info">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p>{{ auth()->user()->role === 'kafel' ? 'كافل' : 'يتيم' }}</p>
                                </div>
                            </div>

                            <div class="profile-details">
                                <p><i class="fas fa-envelope"></i> {{ auth()->user()->email }}</p>
                                <p><i class="fas fa-building"></i> قسم
                                    {{ auth()->user()->role === 'kafel' ? 'الكافل' : 'الأيتام' }}</p>
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn" id="logoutBtn">
                                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </nav>

            <div class="main-content">
                <div class="title-content">
                    <h4 class="detailesOrphan-title">بيانات اليتيم</h4>


                    <div id="myModal" class="modal">
                        <div class="popup-content">
                            <span class="close">&times;</span>
                            <p> إضافة وثيقة جديدة</p>
                            <hr>
                            <form method="POST" action="{{ route('orphans.update', $orphan->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <input type="text" id="name" name="name"
                                        value="{{ $orphan->name ?? '' }}" placeholder=" الاسم الكامل ">
                                </div>

                                <div class="form-group">
                                    <input type="number" id="age" name="age"
                                        value="{{ $orphan->age ?? '' }}" placeholder=" العمر">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="area" name="area"
                                        value="{{ $orphan->area ?? '' }}" placeholder=" المنطقة / المدينة ">
                                </div>

                                <div class="form-group">
                                    <select id="gender" name="gender">
                                        <option disabled hidden {{ !$orphan->gender ? 'selected' : '' }}>
                                            الجنس</option>
                                        <option value="ذكر" {{ $orphan->gender == 'ذكر' ? 'selected' : '' }}> ذكر
                                        </option>
                                        <option value="انثى" {{ $orphan->gender == 'انثى' ? 'selected' : '' }}>انثى
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select id="social_status" name="social_status">
                                        <option disabled hidden {{ !$orphan->social_status ? 'selected' : '' }}>الحالة
                                            الاجتماعية</option>
                                        <option value="يتيم الأب"
                                            {{ $orphan->social_status == 'يتيم الأب' ? 'selected' : '' }}>يتيم الأب
                                        </option>
                                        <option value="يتيم الأبوين"
                                            {{ $orphan->social_status == 'يتيم الأبوين' ? 'selected' : '' }}>يتيم
                                            الأبوين</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select id="health_status" name="health_status">
                                        <option disabled hidden {{ !$orphan->health_status ? 'selected' : '' }}>الحالة
                                            الصحية</option>
                                        <option value="سليم"
                                            {{ $orphan->health_status == 'سليم' ? 'selected' : '' }}>سليم</option>
                                        <option value="مريض"
                                            {{ $orphan->health_status == 'مريض' ? 'selected' : '' }}>مريض</option>
                                    </select>
                                </div>

                                <div class="popbtn">
                                    <button type="submit" class="save-btn">حفظ البيانات</button>
                                    <button type="button" class="cancle-btn" onclick="closeModal()">إلغاء</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
                <div class="detailes-header">
                    <div class="boxx">
                        <div class="header-image">
                            <img src="{{ asset('storage/' . $orphan->photo) }}" alt="صورة {{ $orphan->name }}"
                                style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #ccc;">
                            <p>{{ $orphan->name }}</p>
                        </div>

                        <div class="header-info" style="margin-right: auto; text-align: left;">
                            <p style="margin-bottom: 10px;">
                                <span>{{ $orphan->email }}</span><br>

                                <span>{{ $orphan->age }} سنة</span><br>
                                @php
                                    $statusText = $isSponsored ? 'مكفول' : 'غير مكفول';
                                    $statusColor = $isSponsored ? '#28a745' : '#dc3545';
                                @endphp

                                <span class="stute"
                                    style="color: white; padding: 6px 14px; border-radius: 6px; font-weight: bold; background-color: {{ $statusColor }};">
                                    {{ $statusText }}
                                </span>
                            </p>

                            <!-- زر تعديل البيانات -->
                            {{-- <a href="#" class="btn-download details-document" id="openModalBtn"
                                style="background-color: #006dff; color:  white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none; display: inline-block; margin-top:2px; width:150px ; text-align:center">
                                تعديل البيانات
                            </a> --}}
                        </div>

                    </div>
                </div>
                <div class="container-fluid responsive-cards-container">
                    <div class="cardsfather">
                        <div class="box">
                            <i class="fas fa-user icon-box"></i><br>
                            <span>الأسم</span>
                            <p>{{ $orphan->name }}</p>
                        </div>
                        <div class="box">
                            <i class="fas fa-user icon-box"></i><br>
                            <span>الجنس</span>
                            <p>{{ $orphan->gender }}</p>
                        </div>
                        <div class="box">
                            <i class="fas fa-store icon-box"></i><br>
                            <span>العمر</span>
                            <p>{{ $orphan->age ?? 'غير متوفر' }}</p>
                        </div>
                        <div class="box">
                            <i class="fas fa-location-dot icon-box"></i><br>
                            <span>المنطقة</span>
                            <p>{{ $orphan->area ?? 'غير متوفر' }}</p>
                        </div>
                        <div class="box">
                            <i class="fas fa-heart icon-box"></i><br>
                            <span>الحالة الإجتماعية</span>
                            <p>{{ $orphan->social_status ?? 'غير متوفرة' }}</p>
                        </div>
                        <div class="box">
                            <i class="fas fa-shield icon-box"></i><br>
                            <span>الحالة الصحية</span>
                            <p>{{ $orphan->health_status ?? 'غير متوفرة' }}</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/bootstrap.bundle.js.map"></script>
    <script src="../../js/main.js"></script>
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
    <script></script>

</body>

</html>
