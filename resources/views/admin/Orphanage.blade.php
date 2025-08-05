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

            <div class="title-content container">
                <p class="head-title">إدارة الأيتام</p>
                <a href="{{ route('admin.orphans.create') }}" class="add-orphanage">
                    <i class="fas fa-add add-btn"></i>إضافة يتيم
                </a>
            </div>

            <div class="search-eara" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" id="searchInput" placeholder="ابحث بالاسم أو البريد...">

                <select id="genderFilter" class="select-list-header">
                    <option value="">الجنس</option>
                    <option value="ذكر">ذكر</option>
                    <option value="أنثى">أنثى</option>
                </select>

                <select id="socialStatusFilter" class="select-list-header">
                    <option value="">الحالة الاجتماعية</option>
                    <option value="يتيم الأب">يتيم الأب</option>
                    <option value="يتيم الأبوين">يتيم الأبوين</option>
                </select>

                <select id="healthStatusFilter" class="select-list-header">
                    <option value="">الحالة الصحية</option>
                    <option value="سليم">سليم</option>
                    <option value="مريض">مريض</option>
                </select>
            </div>




            <div class="card-body table-responsive" style="max-width: 100%; margin-right: 15px;">
                <table class="table table-hover text-wrap table-lg" style="border-radius: 10px; overflow: hidden;">
                    <thead>
                        <tr>
                            <th>رقم اليتيم</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>العمر</th>
                            <th>الجنس</th>
                            <th>المنطقة</th>
                            <th>الحالة الاجتماعية</th>
                            <th>الحالة الصحية</th>
                            <th>حالة الكفالة</th>
                            <th>الإجراءات</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orphans as $orphan)
                            <tr>
                                <td>{{ $orphan->id }}</td>
                                <td>{{ $orphan->name }}</td>
                                <td>{{ $orphan->email }}</td>
                                <td>{{ $orphan->age }}</td>
                                <td>{{ $orphan->gender }}</td>
                                <td>{{ $orphan->area }}</td>
                                <td>{{ $orphan->social_status }}</td>
                                <td>{{ $orphan->health_status }}</td>
                                <td>{{ $orphan->sponsorship_status }}</td>
                                <td style="">
                                    <a href="{{ url('/admin/orphans/' . $orphan->id) }}" class="show-orphan">عرض</a>
                                    <form action="{{ url('/admin/orphans/' . $orphan->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-orphan"
                                            style="  border: none !important; box-shadow: none !important;"
                                            onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا يوجد أيتام حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

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
            const searchInput = document.getElementById('searchInput');
            const genderFilter = document.getElementById('genderFilter');
            const socialStatusFilter = document.getElementById('socialStatusFilter');
            const healthStatusFilter = document.getElementById('healthStatusFilter');

            const tableRows = document.querySelectorAll('table tbody tr');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const genderValue = genderFilter.value;
                const socialValue = socialStatusFilter.value;
                const healthValue = healthStatusFilter.value;

                tableRows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const gender = row.cells[4].textContent.trim();
                    const social = row.cells[6].textContent.trim();
                    const health = row.cells[7].textContent.trim();

                    const matchesSearch = name.includes(searchValue) || email.includes(searchValue);
                    const matchesGender = !genderValue || gender === genderValue;
                    const matchesSocial = !socialValue || social === socialValue;
                    const matchesHealth = !healthValue || health === healthValue;

                    if (matchesSearch && matchesGender && matchesSocial && matchesHealth) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterTable);
            genderFilter.addEventListener('change', filterTable);
            socialStatusFilter.addEventListener('change', filterTable);
            healthStatusFilter.addEventListener('change', filterTable);
        </script>

</body>

</html>
