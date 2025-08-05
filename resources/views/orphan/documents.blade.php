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
                    <h3 class="document-title">الوثائق و المستندات</h3>
                    <div id="myModal" class="modal">
                        <div class="popup-content">
                            <span class="close">&times;</span>
                            <p> إضافة وثيقة جديدة</p>
                            <hr>
                            <form>
                                <div class="form-group">
                                    <input type="text" id="fullName" name="fullName"
                                        placeholder=" أسم الوثيقة ">
                                </div>

                                <div class="document-number">
                                    <label class="custom-file-upload">
                                        <input type="file" class="file-input">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>رفع الوثيقة</span>
                                    </label>
                                </div>
                                <div class="popbtn">
                                    <button type="submit" class="save-btn">رفع الوثيقة</button>
                                    <button type="submit" class="cancle-btn">إالغاء</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive responsive-table" style="max-width: 80%; margin-right: 15px;">
                    <table class="table table-hover text-wrap table-lg"
                        style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th style="color: #ffffff">الرقم </th>
                                <th style="color: #ffffff">الأسم </th>
                                <th style="color: #ffffff"> تاريخ الرفع </th>
                                <th style="color: #ffffff">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['label'] }}</td>

                                    <td>
                                        @if ($row['doc'])
                                            {{ $row['doc']->created_at->format('d/m/Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td class="stutes">
                                        @if ($row['doc'])
                                            <a href="{{ asset('storage/' . $row['doc']->file) }}" target="_blank"
                                                class="accept-guarantee btn-view">عرض</a>


                                            <form action="{{ route('orphan.document.delete', $row['doc']->id) }}"
                                                method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-orphan"
                                                    style="  border: none !important; box-shadow: none !important;">حذف</button>
                                            </form>
                                        @else
                                            <form action="{{ route('orphan.document.upload') }}" method="POST"
                                                enctype="multipart/form-data" style="display:inline">
                                                @csrf
                                                <input type="hidden" name="type" value="{{ $row['type_key'] }}">
                                                <label class="custom-file-upload">
                                                    <input type="file" name="file"
                                                        onchange="this.form.submit()" style="display:none">
                                                    <span>رفع</span>
                                                </label>
                                            </form>
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
