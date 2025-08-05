<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل</title>
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
            <div>


            </div>
        </div>

        <div class="container">
            <nav class="navbar">
                <!-- منطقة البحث -->
                <div class="search-container">
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <input type="text" placeholder="ابحث الأن...">
                </div>

                <!-- الجرس والإشعارات -->
                <div style="display: flex; align-items: center;">
                    <div class="bill" id="bellIcon">
                        <i class="fas fa-bell"></i>

                        {{-- عدد الإشعارات الحقيقية --}}
                        @if ($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif

                        {{-- عرض آخر إشعار غير مقروء --}}
                        <div class="notification-panel" id="notificationPanel">
                            @forelse($unreadNotifications as $notification)
                            <div class="notification-item">
                                <div class="notification-title">{{ $notification->data['title'] ?? 'إشعار' }}</div>
                                <div class="notification-message">
                                    {{ $notification->data['message'] ?? 'بدون رسالة' }}
                                </div>
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
                                    {{ auth()->user()->role === 'kafel' ? 'الكافل' : 'الأيتام' }}
                                </p>
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


                 <div class="container">


            <div class="main-content container mt-4">
                <h3 class="mb-4">إدخال مبلغ الكفالة</h3>
                <form method="POST" action="{{ route('payment.prepare') }}">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

                    <div class="mb-3">
                        <label class="form-label">أدخل المبلغ بالدولار</label>
                        <input type="number" name="amount" class="form-control" min="1" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">طريقة الدفع</label>
                        <select name="method" class="form-control" required>
                            <option value="فيزا">فيزا</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">متابعة إلى الدفع</button>
                </form>
            </div>
        </div>
    </div>


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
