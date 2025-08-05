<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كفالة - لوحة الأدمن</title>
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
                            <span>
                                @if (auth()->user()->role === 'kafel')
                                    كافل
                                @elseif(auth()->user()->role === 'orphan')
                                    يتيم
                                @elseif(auth()->user()->role === 'admin')
                                    مدير
                                @endif
                            </span>
                        </p>

                        <!-- لوحة الملف الشخصي -->
                        <div class="profile-panel" id="profilePanel">
                            <div class="profile-header">
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="صورة المستخدم">
                                <div class="profile-info">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p>
                                        @if (auth()->user()->role === 'kafel')
                                            كافل
                                        @elseif(auth()->user()->role === 'orphan')
                                            يتيم
                                        @elseif(auth()->user()->role === 'admin')
                                            مدير النظام
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="profile-details">
                                <p><i class="fas fa-envelope"></i> {{ auth()->user()->email }}</p>
                                <p><i class="fas fa-building"></i> قسم
                                    @if (auth()->user()->role === 'kafel')
                                        الكافل
                                    @elseif(auth()->user()->role === 'orphan')
                                        الأيتام
                                    @elseif(auth()->user()->role === 'admin')
                                        الإدارة
                                    @endif
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


            <div class="main-content">
                <div class="header">
                    <div class="welcome-message">مرحباً بك مجدداً: <span>{{ auth()->user()->name }} </span> <br>
                        <p class="text-message">جميع البيانات المختلفة بمطلق مناقصة الإحصائيات أو إدارة صندوق
                            المنصة من القوائم
                            الخاصية</p>
                    </div>

                </div>
                <div class="stats-container">
                    <!-- الكاردات الأربعة في صف واحد -->
                    <div class="stat-card">
                        <div class="stat-title">الأيتام السجلين</div>
                        <div class="stat-number">
                            <img class="card-icon" src="{{ asset('frontend/img/users-three-Filled.png') }}"
                                alt="">
                            <span class="counter" data-target="{{ $orphansCount }}">{{ $orphansCount }}</span> +
                        </div>
                        <div class="stat-description">أكثر من {{ $orphansCount }} متاحين للكفالة</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-title">الكافلين</div>
                        <div class="stat-number">
                            <img class="card-icon" src="{{ asset('frontend/img/user-Filled.png') }}" alt="">
                            <span class="counter" data-target="{{ $donorsCount }}">{{ $donorsCount }}</span> +
                        </div>
                        <div class="stat-description">أكثر من {{ $donorsCount }} كافل و كافلة من أهل الخير</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-title">الأيتام المكفولين</div>
                        <div class="stat-number">
                            <img class="card-icon" src="{{ asset('frontend/img/users-three-Filled.png') }}"
                                alt="">
                            <span class="counter"
                                data-target="{{ $sponsoredOrphansCount }}">{{ $sponsoredOrphansCount }}</span> +
                        </div>
                        <div class="stat-description">أكثر من {{ $sponsoredOrphansCount }} يتيما تمت كفالتهم</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-title">الأيتام المتاحين للكفالة</div>
                        <div class="stat-number">
                            <img class="card-icon" src="{{ asset('frontend/img/users-three-Filled.png') }}"
                                alt="">
                            <span class="counter"
                                data-target="{{ $availableOrphansCount }}">{{ $availableOrphansCount }}</span> +
                        </div>
                        <div class="stat-description">يوجد حاليا أكثر من {{ $availableOrphansCount }} يتيما متاحون
                            للكفالة</div>
                    </div>
                </div>

                <div class="stats-container2">
                    <div class="chrt1">
                        <canvas id="chart1"></canvas>
                    </div>
                    <div class="chrt2">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
        window.userId = {{ auth()->id() }};
    </script>
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
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>



    <script>
        // عرف متغير الـ ID للمستخدم المسجّل دخوله
        const userId = {{ auth()->id() }};

        // الاستماع للقناة الخاصة بالمستخدم الحالي (مدير أو غيره)
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('📢 إشعار لحظي جديد:', notification);

                // مثال: تحديث عداد الإشعارات
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    let current = parseInt(badge.innerText) || 0;
                    badge.innerText = current + 1;
                }

                // مثال: إضافة الإشعار في القائمة
                const panel = document.getElementById('notificationPanel');
                if (panel) {
                    const newItem = document.createElement('div');
                    newItem.classList.add('notification-item');
                    newItem.innerHTML = `
                    <div class="notification-title">${notification.title ?? 'إشعار'}</div>
                    <div class="notification-message">${notification.message ?? ''}</div>
                    <div class="notification-time">الآن</div>
                `;
                    panel.prepend(newItem); // أضفه في أعلى القائمة
                }

                // اختياري: عرض Toast إذا كنت تستخدم مكتبة مثل Toastr
                // toastr.info(`${notification.title}: ${notification.message}`);
            });
    </script>

</body>

</html>
