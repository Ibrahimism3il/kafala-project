<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادارة الأيتام</title>
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


    <script src="../../js/main.js"></script>
    <style>
    body{
        background-color: #ffffff
    }
</style>
</head>

<body>


    <!-- Sidebar -->
    <div class="d-flex all-bage">
        <button id="sidebar-toggle" class="burger-btn">
            <i class="fas fa-bars"></i>
        </button>
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
                <div style="display: flex; align-items: center;">
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

            <div class="title-content">
                <p class="head-title">إدارة الكافلين</p>
                <a href="{{ route('admin.donors.create') }}" class="add-donor" id> <i
                        class="fas fa-add add-btn"></i>إضافة كافل</a>
            </div>

            <div class="search-eara">
                <div>
                    <input type="text" placeholder="ابحث الآن..." />
                </div>

                <select id="filterType" class="select-list-header">
                    <option value="">النوع</option>
                    <option value="فرد">فرد</option>
                    <option value="مؤسسة">مؤسسة</option>
                </select>
            </div>




            <div class="card-body table-responsive" style="max-width: 90%; margin-right: 15px;">
                <table class="table table-hover text-wrap table-lg" style="border-radius: 10px; overflow: hidden;">
                    <thead>
                        <tr>
                            <th>رقم الكافل</th>
                            <th>الأسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>النوع </th>
                            <th>عدد الكفالات</th>
                            <th rowspan="4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donors as $donor)
                            <tr>
                                <td>{{ $donor->id }}</td>
                                <td>{{ $donor->name }}</td>
                                <td>{{ $donor->email }}</td>
                                <td>{{ $donor->kafel_type ?? '-' }}</td>
                                <td>{{ $donor->sponsorships_count ?? 0 }}</td>
                                <td class="stutes" style = "border-bottom-color :aliceblue">
                                    <a href="{{ route('admin.donors.edit', $donor->id) }}"
                                        class="edit-donor">تعديل</a>
                                    <form action={{ route('admin.DonorsManagement.destroy', $donor->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-orphan"
                                            style="  border: none !important; box-shadow: none !important;"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا الكافل؟')">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

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
        <script>
            // البحث في اسم الكافل أو البريد
            document.querySelector('.search-eara input[type="text"]').addEventListener('keyup', function() {
                let searchValue = this.value.toLowerCase();
                let rows = document.querySelectorAll('tbody tr');

                rows.forEach(function(row) {
                    let name = row.children[1].textContent.toLowerCase();
                    let email = row.children[2].textContent.toLowerCase();
                    if (name.includes(searchValue) || email.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
        <script>
            // فلترة حسب النوع
            document.querySelector('.select-list-header').addEventListener('change', function() {
                let filterValue = this.value;
                let rows = document.querySelectorAll('tbody tr');

                rows.forEach(function(row) {
                    let type = row.children[3].textContent.trim();
                    if (filterValue === "" || type === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>

</body>

</html>
