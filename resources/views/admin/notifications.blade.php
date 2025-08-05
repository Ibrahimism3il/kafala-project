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
    <script src="../../js/main.js"></script>
    <style>
        .modalshow {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content-show {
            background: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            width: 90%;
        }

        th {
            background-color: #3c7a6d
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
                <div class="profile-img"> <img src=".{{ asset('frontend/img/1745048934591-pica.png') }}" alt="">
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
                <div class="not-head">
                    <p class="title-guarantee">الإشعارات الواردة </p>
                    <div class="search-eara">
                        <div type="submit"> <input type="text" placeholder="ابحث الأن..." id="searchInput">
                        </div>
                        <select name="" id="sourceFilter" class="select-list-header">
                            <option value="">المصدر</option>
                            <option value="كافل">كافل</option>
                            <option value="النظام">النظام</option>
                        </select>
                        <!-- زر فتح مودال الإرسال -->
                        <button class="show-orphan"
                            onclick="document.getElementById('manualNotifyModal').style.display='flex'"
                            style="  border: none !important; box-shadow: none !important;">إرسال
                            إشعار</button>

                        <!-- مودال إرسال إشعار يدوي -->
                        <div id="manualNotifyModal" class="modalshow">
                            <div class="modal-content-show">
                                <span class="close-modal"
                                    onclick="document.getElementById('manualNotifyModal').style.display='none'">&times;</span>
                                <h3 style="margin-bottom: 20px;">إرسال إشعار يدوي</h3>

                                <form action="{{ route('admin.notifications.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="receiver_type">اختر نوع المستلم:</label>
                                        <select name="receiver_type" id="receiver_type" required
                                            class="form-control">
                                            <option value="kafel">كافل</option>
                                            <option value="orphan">يتيم</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="receiver_id">اختر المستلم:</label>
                                        <select name="receiver_id" id="receiver_id" required class="form-control">
                                            @foreach ($kafels as $kafel)
                                                <option value="{{ $kafel->id }}" data-type="kafel">
                                                    {{ $kafel->name }}</option>
                                            @endforeach
                                            @foreach ($orphans as $orphan)
                                                <option value="{{ $orphan->user->id }}" data-type="orphan">
                                                    {{ $orphan->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="title">عنوان الإشعار:</label>
                                        <input type="text" name="title" id="title" required
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="content">محتوى الإشعار:</label>
                                        <textarea name="content" id="content" rows="4" required class="form-control"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3"
                                        style="background-color: #327969">إرسال</button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="notifications-container">
                    <div class="card-body table-responsive" style="max-width: 90%; margin-right: 15px;">
                        <table class="table table-hover text-wrap table-lg notifications-table"
                            style="border-radius: 10px; overflow: hidden;">
                            <thead>
                                <tr>
                                    <th class="status-col" style="background-color: #327969">الحالة</th>
                                    <th class="content-col" style="background-color: #327969">محتوى الإشعار</th>
                                    <th class="source-col" style="background-color: #327969">المصدر</th>
                                    <th class="date-col" style="background-color: #327969">التاريخ</th>
                                    <th class="time-col" style="background-color: #327969">الوقت</th>
                                    <th class="actions-col" style="background-color: #327969">الإجراءات</th>
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
                                        $sponsorship = $data['sponsorship'] ?? [];
                                        $orphanName = $sponsorship['orphan'] ?? '-';
                                        $sponsorshipId = $sponsorship['id'] ?? '-';
                                        $sponsorshipType = $sponsorship['type'] ?? '-';
                                        $paymentId = $data['payment_id'] ?? null;
                                    @endphp

                                    <tr class="{{ $notification->read_at ? 'table-old' : 'table-active' }}">
                                        <td data-label="الحالة">
                                            <span
                                                class="status-indicator {{ $notification->read_at ? 'old' : 'new' }}"></span>
                                        </td>
                                        <td data-label="محتوى الإشعار" class="notification-content">
                                            <div class="content-wrapper">{{ $title }}</div>
                                        </td>
                                        <td data-label="المصدر" class="notification-source">{{ $source }}</td>
                                        <td data-label="التاريخ" class="notification-date">
                                            {{ $notification->created_at->format('Y-m-d') }}</td>
                                        <td data-label="الوقت" class="notification-time">
                                            {{ $notification->created_at->format('h:i A') }}</td>

                                        <td class="stutes">
                                            <!-- زر فتح المودال -->
                                            <a href="#" class="notification-detailes"
                                                style="background-color: #7b7e85;"
                                                onclick="openModal('{{ $notification->id }}')">عرض</a>

                                            <!-- المودال -->
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
                                                    <p class="modalshow-title">معلومات المرسل</p>
                                                    <p><strong>نوع الكفالة:</strong> {{ $sponsorshipType }}</p>
                                                    <p><strong>اليتيم المكفول:</strong> {{ $orphanName }}</p>
                                                    <p><strong>رقم الكفالة:</strong> #{{ $sponsorshipId }}</p>

                                                    @if ($paymentId)
                                                        <div class="btn-show-guarantee">
                                                            <form
                                                                action="{{ route('admin.payments.notify', $paymentId) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="send-to-donor">إرسال
                                                                    إشعار للكافل</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- تحديد كمقروء -->
                                            @if (!$notification->read_at)
                                                <form
                                                    action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="accept-guarantee"
                                                        style="  border: none !important; box-shadow: none !important; height:38px;">تحديد
                                                        كمقروء</button>
                                                </form>
                                            @endif

                                            <!-- حذف الإشعار -->
                                            <form action="{{ route('notifications.delete', $notification->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-orphan"
                                                    style="  border: none !important; box-shadow: none !important;">حذف</button>
                                            </form>
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
        function openModal(id) {
            const modal = document.getElementById("notificationModal" + id);
            if (modal) {
                modal.style.display = "flex";
            }
        }

        function closeModal(id) {
            const modal = document.getElementById("notificationModal" + id);
            if (modal) {
                modal.style.display = "none";
            }
        }

        // إغلاق المودال إذا ضغطت على X
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modal = this.closest('.modalshow');
                    if (modal) modal.style.display = 'none';
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const sourceFilter = document.getElementById('sourceFilter');
            const rows = document.querySelectorAll('.notifications-table tbody tr');

            function filterNotifications() {
                const searchText = searchInput.value.toLowerCase();
                const selectedSource = sourceFilter.value.trim();

                rows.forEach(row => {
                    const content = row.querySelector('.notification-content')?.innerText.toLowerCase() ||
                        '';
                    const source = row.querySelector('.notification-source')?.innerText.trim();

                    const matchesSearch = content.includes(searchText);
                    const matchesSource = selectedSource === '' || source === selectedSource;

                    if (matchesSearch && matchesSource) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterNotifications);
            sourceFilter.addEventListener('change', filterNotifications);
        });
    </script>

</body>

</html>
