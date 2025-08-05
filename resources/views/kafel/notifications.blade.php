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

    <script src="../../js/main.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
        }

        .close-modal {
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .readed {
            color: #056659;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;

        }

        .btn-mark-all-read {
            background-color: #969696;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-mark-all-read:hover {
            background-color: #044e49;
        }
    </style>
    <style>
        body {
            background-color: #ffffff
        }
    </style>
    <style>
        .modalshow {
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            direction: rtl;
        }

        .modal-content-show {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 15px;
            width: 70%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: right;
        }

        .close-modal {
            float: left;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
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

                        {{-- عرض آخر إشعار غير مقروء --}}
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
                <p class="title-guarantee">الإشعارات الواردة </p>
                <div class="search-eara">
                    <input type="text" id="searchInput" placeholder="ابحث الأن..." onkeyup="filterNotifications()">

                    <select id="sourceFilter" class="select-list-header" style="width: 200px;"
                        onchange="filterNotifications()">
                        <option value="">المصدر</option>
                        <option value="نظام">نظام</option>
                        <option value="يتيم">يتيم</option>
                    </select>

                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-mark-all-read">مقروءة للكل</button>
                    </form>
                </div>


                <div class="notifications-container">
                    <div class="card-body table-responsive" style="max-width: 95%; margin-right: 5px;">
                        <table class="table table-hover text-wrap table-lg notifications-table"
                            style="border-radius: 10px; overflow: hidden;">
                            <thead>
                                <tr>
                                    <th class="status-col" style="background-color: #056659">الحالة</th>
                                    <th class="content-col" style="background-color:  #056659">محتوى الإشعار</th>
                                    <th class="source-col"style="background-color:  #056659">المصدر</th>
                                    <th class="date-col"style="background-color:  #056659">التاريخ</th>
                                    <th class="time-col"style="background-color:  #056659">الوقت</th>
                                    <th class="actions-col"style="background-color:  #056659">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (auth()->user()->notifications as $notification)
                                    @php
                                        $data = $notification->data;
                                        $title = $data['title'] ?? 'لا يوجد عنوان';
                                        $message = $data['message'] ?? 'لا يوجد محتوى.';
                                        $source = $data['source'] ?? 'النظام';
                                        $type = $data['type'] ?? 'غير محدد';
                                    @endphp

                                    <tr class="{{ $notification->read_at ? 'old' : 'active' }}">
                                        <td data-label="الحالة"><span
                                                class="status-indicator {{ $notification->read_at ? 'old' : 'new' }}"></span>
                                        </td>
                                        <td data-label="محتوى الإشعار" class="notification-content">
                                            <div class="content-wrapper">
                                                {{ $notification->data['title'] ?? 'لا يوجد محتوى' }}
                                            </div>
                                        </td>
                                        <td data-label="المصدر" class="notification-source">
                                            {{ $notification->data['source'] ?? 'نظام' }}</td>
                                        <td data-label="التاريخ" class="notification-date">
                                            {{ $notification->created_at->format('Y-m-d') }}</td>
                                        <td data-label="الوقت" class="notification-time">
                                            {{ $notification->created_at->format('h:i A') }}</td>
                                        <td data-label="الإجراءات" class="notification-actions">
                                            <a href="#" class="notification-detailes"
                                                onclick="openModal('{{ $notification->id }}')">تفاصيل</a>

                                            <!-- Modal -->
                                            <div id="notificationModal{{ $notification->id }}" class="modalshow"
                                                style="display: none;">
                                                <div class="modal-content-show">
                                                    <span class="close-modal"
                                                        onclick="closeModal('{{ $notification->id }}')">&times;</span>
                                                    <div class="title-modalshow">
                                                        <p>تفاصيل الإشعار :</p>
                                                        <span>{{ $title }}</span>
                                                    </div>
                                                    <hr>
                                                    <p class="modalshow-title">معلومات الإشعار الأساسية</p>
                                                    <div class="main-detailes">
                                                        <p><strong>نوع الإشعار :</strong> {{ $type }}</p>
                                                        <p><strong>المصدر :</strong> {{ $source }}</p>
                                                        <p><strong>الحالة:</strong>
                                                            <span
                                                                style="background-color: {{ $notification->read_at ? '#aaa' : '#006dff' }};
                            padding: 8px; border-radius: 15px; color: white;">
                                                                {{ $notification->read_at ? 'مقروءة' : 'غير مقروءة' }}
                                                            </span>
                                                        </p>
                                                        <p><strong>تاريخ ووقت الإستلام :</strong>
                                                            {{ $notification->created_at->format('Y-m-d H:i') }}</p>
                                                    </div>
                                                    <hr>
                                                    <p class="modalshow-title">محتوى الإشعار</p>
                                                    <p><strong>عنوان الإشعار :</strong> {{ $title }}</p>
                                                    <p class="content-notf">{{ $message }}</p>
                                                    <hr>
                                                    <div class="stutes">
                                                        @if (!$notification->read_at)
                                                            <form
                                                                action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="send-to-donor"
                                                                    style="border: none !important; box-shadow: none !important;">وضع
                                                                    علامة مقروءة</button>
                                                            </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('notifications.delete', $notification->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="end-guarantee" style="height: 42px; background-color:#db2929 ;border: none !important; box-shadow: none !important;">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6">لا توجد إشعارات حالياً.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>


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
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <script src="{{ asset('frontend/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('frontend/js/main-dashboard.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.js.map') }}"></script>
    <script src="{{ asset('frontend/js/main-dashboard.js') }}"></script>

    <script>
        function openModal(id) {
            let modal = document.getElementById("notificationModal" + id);
            if (modal) modal.style.display = "block";
        }

        function closeModal(id) {
            let modal = document.getElementById("notificationModal" + id);
            if (modal) modal.style.display = "none";
        }

        window.onclick = function(event) {
            document.querySelectorAll(".modalshow").forEach(function(modal) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        }
    </script>

    <script>
        function filterNotifications() {
            const search = document.getElementById("searchInput").value.toLowerCase();
            const sourceFilter = document.getElementById("sourceFilter").value.trim();

            const rows = document.querySelectorAll(".notifications-table tbody tr");

            rows.forEach(row => {
                const content = row.querySelector(".notification-content")?.innerText.toLowerCase() || "";
                const source = row.querySelector(".notification-source")?.innerText.trim() || "";

                const matchesSearch = content.includes(search);
                const matchesSource = sourceFilter === "" || source === sourceFilter;

                if (matchesSearch && matchesSource) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>


</body>

</html>
