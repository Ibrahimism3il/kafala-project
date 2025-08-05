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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <style>
        .modalshow {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .modal-content-show {
            background: white;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative;

            /* حل تمركز أفقي وعمودي فعلي */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close {
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 22px;
            cursor: pointer;
            color: #444;
        }

        .title-modalshow {
            font-size: 18px;
            font-weight: bold;
            color: #00796b;
            display: flex;
            justify-content: space-between;
        }

        .modal-section-title {
            color: #004d40;
            font-weight: bold;
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .main-detailes p {
            margin: 6px 0;
            font-size: 14.5px;
        }
    </style>
    <style>
        body {
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
                <p class="title-guarantee">إدارة الكفالات</p>
                <div class="search-eara">
                    <input type="text" id="searchInput" placeholder=" ابحث الأن..."
                        style="padding: 6px; margin-left: 10px;">

                    <select id="typeFilter" class="select-list-header">
                        <option value="">نوع الكفالة</option>
                        <option value="مالية">مالية</option>
                        <option value="تعليمية">تعليمية</option>
                        <option value="طبية">طبية</option>
                    </select>

                    <select id="statusFilter" class="select-list-header">
                        <option value="">حالة الكفالة</option>
                        <option value="بإنتظار الموافقة">بإنتظار الموافقة</option>
                        <option value="نشطة">نشطة</option>
                        <option value="منتهية">منتهية</option>
                    </select>
                </div>




                <div class="card-body table-responsive" style="max-width: 90%; margin-right: 15px;">
                    <table class="table table-hover text-wrap table-lg"
                        style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th style="color: #f5faf9">اسم الكافل</th>
                                <th style="color: #f5faf9">اسم اليتيم</th>
                                <th style="color: #f5faf9">نوع الكفالة</th>
                                <th style="color: #f5faf9">المبلغ</th>
                                <th rowspan="2" style="color: #f5faf9">تاريخ البداية</th>
                                <th style="color: #f5faf9">الحالة</th>
                                <th style="color: #f5faf9">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sponsorships as $sponsorship)
                                <tr>
                                    <td>{{ $sponsorship->donor->name ?? '-' }}</td>
                                    <td>{{ optional($sponsorship->orphan)->name ?? '-' }}</td>
                                    <td>{{ $sponsorship->type ?? '-' }}</td>
                                    <td>${{ $sponsorship->amount ?? '0.00' }}</td>
                                    <td>{{ $sponsorship->start_date }}</td>
                                    <td>{{ $sponsorship->status }}</td>
                                    <td class="stutes">
                                        <!-- زر عرض -->
                                        <button class="show-guarantee"
                                            style="  border: none !important; box-shadow: none !important;"
                                            data-id="{{ $sponsorship->id }}">عرض</button>

                                        <!-- حذف -->
                                        <form action="{{ route('admin.sponsorships.destroy', $sponsorship->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="delete-orphan"
                                                style="  border: none !important; box-shadow: none !important;">حذف</button>
                                        </form>

                                        <!-- قبول -->
                                        {{-- <form action="{{ route('admin.sponsorships.accept', $sponsorship->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('PUT')
                                            <button class="accept-guarantee"
                                                style="  border: none !important; box-shadow: none !important;">قبول</button>
                                        </form>

                                        <!-- رفض -->
                                        <form action="{{ route('admin.sponsorships.reject', $sponsorship->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('PUT')
                                            <button class="edit-donor"
                                                style="  border: none !important; box-shadow: none !important;">رفض</button>
                                        </form> --}}
                                    </td>
                                </tr>




                                <!-- المودال -->
                                <div class="modalshow" id="showSponsorship{{ $sponsorship->id }}">
                                    <div class="modal-content-show" onclick="event.stopPropagation()">

                                        <div class="title-modalshow">
                                            <span class="modal-id">#{{ $sponsorship->id }}</span>
                                            <span>تفاصيل الكفالة</span>

                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات الكفالة الأساسية</p>
                                        <div class="main-detailes">
                                            <p><strong>رقم الكفالة:</strong> {{ $sponsorship->id }}</p>
                                            <p><strong>نوع الكفالة:</strong> {{ $sponsorship->type }}</p>
                                            <p><strong>المبلغ:</strong> ${{ $sponsorship->amount }}</p>
                                            <p><strong>الحالة:</strong> {{ $sponsorship->status }}</p>
                                            <p><strong>تاريخ البدء:</strong> {{ $sponsorship->start_date }}</p>
                                            <p><strong>تاريخ الانتهاء:</strong> {{ $sponsorship->end_date }}</p>
                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات الكافل</p>
                                        <div class="main-detailes">
                                            <p><strong>الاسم:</strong> {{ optional($sponsorship->donor)->name ?? '-' }}
                                            </p>
                                            <p><strong>الإيميل:</strong>
                                                {{ optional($sponsorship->donor)->email ?? '-' }}</p>
                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات اليتيم</p>
                                        <div class="main-detailes">
                                            <p><strong>الاسم:</strong>
                                                {{ optional($sponsorship->orphan)->name ?? '-' }}</p>
                                            <p><strong>العمر :</strong>
                                                {{ optional($sponsorship->orphan)->age ?? '-' }}</p>
                                            <p><strong>المنطقة:</strong>
                                                {{ optional($sponsorship->orphan)->area ?? '-' }}</p>
                                        </div>
                                        <div class="btn-show-guarantee">
                                            <a href="{{ route('admin.sponsorships.edit', $sponsorship->id) }}"
                                                class="renew-guarantee">تعديل الكفالة</a>

                                            <form action="{{ route('admin.sponsorships.destroy', $sponsorship->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-orphan"
                                                    onclick="return confirm('هل أنت متأكد من حذف الكفالة؟')"
                                                    style="border: none; background-color: #ff1403; color: white; padding: 6px 12px; border-radius: 9px;">
                                                    حذف الكفالة
                                                </button>
                                            </form>
                                        </div>

                                    </div>

                                </div>
                            @endforeach
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td>{{ $candidate->donor->name ?? '-' }}</td>
                                    <td>{{ $candidate->orphan->name ?? '-' }}</td>
                                    <td>مالية</td>
                                    <td>---$</td>
                                    <td>---</td>
                                    <td>{{ $candidate->status }}</td>
                                    <td class="stutes">
                                        <!-- عرض -->
                                        <button class="show-guarantee"
                                            style="border: none !important; box-shadow: none !important;"
                                            data-id="candidate{{ $candidate->id }}">عرض</button>

                                        <!-- حذف -->
                                        <form action="{{ route('candidate-sponsorship.destroy', $candidate->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="delete-orphan"
                                                style="border: none !important;">حذف</button>
                                        </form>

                                        <!-- قبول -->
                                        <form action="{{ route('admin.sponsorships.accept', $candidate->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf @method('PUT')
                                            <button class="accept-guarantee"
                                                style="border: none !important; height: 38px;">قبول</button>
                                        </form>
                                        <form action="{{ route('candidate-sponsorship.reject', $candidate->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button class="edit-donor"
                                                style=" border: none !important; box-shadow: none !important;">
                                                رفض
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- مودال عرض التفاصيل -->
                                <div class="modalshow" id="showSponsorshipcandidate{{ $candidate->id }}">
                                    <div class="modal-content-show" onclick="event.stopPropagation()">
                                        <div class="title-modalshow">
                                            <span class="modal-id">#{{ $candidate->id }}</span>
                                            <span>تفاصيل طلب الكفالة</span>
                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات الكفالة</p>
                                        <div class="main-detailes">
                                            <p><strong>رقم الطلب:</strong> {{ $candidate->id }}</p>
                                            <p><strong>نوع الكفالة:</strong> مالية</p>
                                            <p><strong>الحالة:</strong> {{ $candidate->status }}</p>
                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات الكافل</p>
                                        <div class="main-detailes">
                                            <p><strong>الاسم:</strong> {{ $candidate->donor->name ?? '-' }}</p>
                                            <p><strong>الإيميل:</strong> {{ $candidate->donor->email ?? '-' }}</p>
                                        </div>
                                        <hr>
                                        <p class="modalshow-title">معلومات اليتيم</p>
                                        <div class="main-detailes">
                                            <p><strong>الاسم:</strong> {{ $candidate->orphan->name ?? '-' }}</p>
                                            <p><strong>المنطقة:</strong> {{ $candidate->orphan->area ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </tbody>
                    </table>

                </div>

            </div>



        </div>
    </div>


    </div>
    </div>
    <script src="../../js/main.js"></script>
    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/bootstrap.bundle.js.map"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.show-guarantee').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const modal = document.getElementById('showSponsorship' + id);
                modal.style.display = 'flex';
            });
        });

        function closeModal(id) {
            document.getElementById('showSponsorship' + id).style.display = 'none';
        }

        // إغلاق عند الضغط خارج المودال
        document.querySelectorAll('.modalshow').forEach(modal => {
            modal.addEventListener('click', function() {
                this.style.display = 'none';
            });
        });
    </script>

    <script>
        function applyFilters() {
            const search = document.getElementById('searchInput').value.trim().toLowerCase();
            const type = document.getElementById('typeFilter').value.trim();
            const status = document.getElementById('statusFilter').value.trim();

            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const donorName = row.cells[0].textContent.trim().toLowerCase();
                const sponsorshipType = row.cells[2].textContent.trim();
                const sponsorshipStatus = row.cells[5].textContent.trim();

                const matchSearch = donorName.includes(search);
                const matchType = type === "" || sponsorshipType === type;
                const matchStatus = status === "" || sponsorshipStatus === status;

                row.style.display = (matchSearch && matchType && matchStatus) ? '' : 'none';
            });
        }

        // تشغيل الفلترة تلقائياً عند التفاعل
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('typeFilter').addEventListener('change', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
    </script>

</body>

</html>
