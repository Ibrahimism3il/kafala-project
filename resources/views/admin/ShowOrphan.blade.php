<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كفالة - لوحة التحكم</title>
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

    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet"> -->
    <link rel="icon" href="{{ asset('frontend/img/1745048934591-pica.png') }}" type="image/png">
    <script src="../../js/main.js"></script>
    <style>
        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
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
            <div class="main-content">
                <div class="title-content">
                    <div class="btn-orphan">
                        <p class="head-guarantee">تفاصيل اليتيم</p>
                    </div>

                    <div class="btn-orphan d-flex gap-3">
                        <a id="editBtn" class="btn-edit-orphan">تعديل البيانات</a>

                        <form action="{{ route('admin.orphans.destroy', $orphan->id) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف اليتيم؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-orphan"
                                style="  border: none !important; box-shadow: none !important;">حذف
                                اليتيم</button>
                        </form>
                    </div>
                    <div id="editPopup" class="popup">
                        <div class="popup-content">
                            <span class="close-btn">&times;</span>
                            <p> تعديل بيانات اليتيم : <span> {{ $orphan->name }}</span></p>
                            <form action="{{ route('admin.orphans.update', $orphan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <input type="text" name="name" value="{{ $orphan->name }}"
                                        placeholder="الأسم الكامل">
                                </div>

                                <div class="form-group">
                                    <input type="number" name="age" value="{{ $orphan->age }}"
                                        placeholder="العمر">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="area" value="{{ $orphan->area }}"
                                        placeholder="المنطقة / المدينة">
                                </div>

                                <div class="form-group">
                                    <select id="gender" name="gender" class="select-list-header" required>
                                        <option value="" disabled
                                            {{ $orphan->gender == null ? 'selected' : '' }}>اختر الجنس</option>
                                        <option value="ذكر" {{ $orphan->gender == 'ذكر' ? 'selected' : '' }}>ذكر
                                        </option>
                                        <option value="أنثى" {{ $orphan->gender == 'أنثى' ? 'selected' : '' }}>أنثى
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <select name="social_status">
                                        <option disabled hidden>الحالة الاجتماعية</option>
                                        <option value="يتيم الأب"
                                            {{ $orphan->social_status == 'يتيم الأب' ? 'selected' : '' }}>يتيم الأب
                                        </option>
                                        <option value="يتيم الأبوين"
                                            {{ $orphan->social_status == 'يتيم الأبوين' ? 'selected' : '' }}>يتيم
                                            الأبوين</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="health_status">
                                        <option disabled hidden>الحالة الصحية</option>
                                        <option value="سليم"
                                            {{ $orphan->health_status == 'سليم' ? 'selected' : '' }}>سليم</option>
                                        <option value="مريض"
                                            {{ $orphan->health_status == 'مريض' ? 'selected' : '' }}>مريض</option>
                                    </select>
                                </div>

                                <button type="submit" class="save-btn">حفظ التعديلات</button>
                            </form>


                        </div>

                    </div>



                </div>

                <div class="card" style="height: 100%">
                    <div class="orphan-info">
                        <div class="orphan-details">
                            {{-- ✅ صورة اليتيم --}}
                            <div>
                                @if ($orphan->photo)
                                    <img src="{{ $orphan->photo ? asset('storage/' . $orphan->photo) : asset('frontend/img/default-avatar.png') }}"
                                        alt="صورة اليتيم"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #ddd; margin-bottom: 10px;">
                                @else
                                    <img src="{{ asset('frontend/img/default-avatar.png') }}" alt="لا توجد صورة"
                                        width="110px" height="110px">
                                @endif
                            </div>

                            {{-- ✅ بيانات اليتيم --}}
                            <div class="orphan-name">
                                <h4>{{ $orphan->name }}</h4>
                                <h5>#{{ $orphan->id }}</h5>
                                <h5>{{ $orphan->age }} سنة</h5>
                            </div>
                        </div>
                    </div>

                    <div class="orphan-info">
                        <div class="orphan-details">
                        </div>
                    </div>

                    <h3 class="section-title">البيانات الأساسية</h3>
                    <div class="container" style="max-width: 80%; margin-right: 20px;">
                        <div class="table-responsive-lg">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th> الاسم</th>
                                        <th>العمر</th>
                                        <th>الجنس</th>
                                        <th>المنطقة</th>
                                        <th>الحالة الإجتماعية</th>
                                        <th>الحالة الصحية</th>
                                        <th>حالة الكفالة</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $orphan->name }}</td>
                                        <td>{{ $orphan->age }}</td>
                                        <td>{{ $orphan->gender }}</td>
                                        <td>{{ $orphan->area }}</td>
                                        <td>{{ $orphan->social_status }}</td>
                                        <td>{{ $orphan->health_status }}</td>
                                        <td
                                            class="{{ $orphan->sponsorship_status == 'مكفول' ? 'status-active' : 'status-inactive' }}">
                                            {{ $orphan->sponsorship_status ?? 'غير مكفول' }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <h3 class="section-title">الوثائق والمستندات</h3>

                    <table class="table table-hover text-wrap table-lg responsive-table" style="max-width: 80%;">
                        <thead>
                            <tr>
                                <th>الاسم</th>

                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        @php
                            $types = [
                                'birth_certificate' => 'شهادة الميلاد',
                                'social_status' => 'إثبات الحالة الإجتماعية',
                                'study_status' => 'الحالة الدراسية',
                                'health_status' => 'الحالة الصحية',
                            ];
                        @endphp

                        @foreach ($types as $type => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td class="document-actions">
                                    @if ($documents->has($type))
                                        <a class="btn-view" href="{{ asset('storage/' . $documents[$type]->file) }}"
                                            target="_blank">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    @else
                                        <span style="color:red">لم يتم الرفع بعد</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>


                    </table>
                </div>
            </div>
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
