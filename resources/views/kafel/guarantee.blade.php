<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كفالة - لوحة الكافل</title>
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
        .modal-content {
            margin: auto;
            direction: rtl;
            text-align: right;

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
                <div class="title-content">
                    <p class="head-title">إدارة الكفالات</p>
                </div>
                <div class="search-eara">
                    <div type="submit"> <input type="text" id="searchInput" placeholder="ابحث الأن..."></div>
                    <select name="" id="filterType" class="select-list-headerr">
                        <option value="">نوع الكفالة</option>
                        <option value="مالية">مالية</option>
                        <option value="تعليمية">تعليمية</option>
                        <option value="صحية">صحية</option>
                    </select>
                    <select name="" id="filterStatus" class="select-list-headerr">
                        <option value="">حالة الكفالة</option>
                        <option value="نشطة">نشطة</option>
                        <option value="بإنتظار الموافقة">بإنتظار الموافقة</option>
                        <option value="منتهية">منتهية</option>
                    </select>
                </div>



                <div class="card-body table-responsive" style="max-width: 90%; margin-right: 15px;">
                    <table class="table table-hover text-wrap table-lg"
                        style="border-radius: 10px; overflow-x: hidden;">
                        <thead>
                            <tr>
                                <th>رقم الكفالة</th>
                                <th>أسم اليتيم</th>
                                <th>نوع الكفالة</th>
                                <th>المبلغ الشهري</th>
                                <th>تاريخ البدء</th>
                                <th>حالة الكفالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sponsorships as $sponsorship)
                                <tr data-name="{{ strtolower($sponsorship->orphan->name ?? '') }}"
                                    data-type="{{ $sponsorship->type }}" data-status="{{ $sponsorship->status }}">
                                    <td>{{ $sponsorship->id }}</td>
                                    <td>{{ $sponsorship->orphan->name ?? '—' }}</td>
                                    <td>{{ $sponsorship->type }}</td>
                                    <td>{{ $sponsorship->amount }}$</td>
                                    <td>{{ \Carbon\Carbon::parse($sponsorship->start_date)->format('d/m/Y') }}</td>
                                    <td
                                        style="color:
                        @if ($sponsorship->status == 'نشطة') #68AF73
                        @elseif($sponsorship->status == 'بإنتظار الموافقة') #fbba04
                        @else red @endif;">

                                        {{ $sponsorship->status }}
                                    </td>
                                    <td class="stutes">


                                        <button type="button"
                                            style="  border: none !important; box-shadow: none !important;"
                                            class="show-guarantee" data-id="{{ $sponsorship->id }}"
                                            data-orphan="{{ $sponsorship->orphan->name ?? '—' }}"
                                            data-age="{{ $sponsorship->orphan->age ?? '—' }}"
                                            data-gender="{{ $sponsorship->orphan->gender ?? '—' }}"
                                            data-type="{{ $sponsorship->type }}"
                                            data-amount="{{ $sponsorship->amount }}"
                                            data-status="{{ $sponsorship->status }}"
                                            data-start="{{ \Carbon\Carbon::parse($sponsorship->start_date)->format('d/m/Y') }}">
                                            عرض
                                        </button>
                                        <div id="ShowGuarantee" class="modal">
                                            <div class="modal-content" style="text-align: right; margin: auto;">
                                                <span class="close-modal" id="close">&times;</span>

                                                <div class="title-modalshow">
                                                    <p> تفاصيل كفالة اليتيم :</p>
                                                    <span id="modal-orphan-name">—</span>
                                                </div>

                                                <div class="modal-header">
                                                    <div class="orphan-title">
                                                        <p class="orphan-name" id="modal-name">—</p>
                                                        <p class="orphan-info">
                                                            <span id="modal-age">—</span> سنوات <br>
                                                            <span id="modal-gender">—</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="modal-body">
                                                    <p class="modalshow-title">تفاصيل الكفالة </p>
                                                    <div class="main-detailes">
                                                        <p><strong>رقم الكفالة:</strong> <span id="modal-id"></span>
                                                        </p>
                                                        <p><strong>نوع الكفالة:</strong> <span id="modal-type"></span>
                                                        </p>
                                                        <p><strong>المبلغ:</strong> $<span id="modal-amount"></span>
                                                        </p>
                                                        <p><strong>الحالة:</strong> <span id="modal-status"></span></p>
                                                        <p><strong>تاريخ بدء الكفالة:</strong> <span
                                                                id="modal-start"></span></p>
                                                        <hr>
                                                    </div>
                                                    <div class="btn-show-guarantee">

                                                        <button id="deleteBtn" type="submit" style="  border: none !important; box-shadow: none !important;"
                                                            class="delete-orphan">حذف
                                                            الكفالة</button>

                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <form id="delete-sponsorship-form" method="POST">
                                            @csrf
                                            @method('DELETE')

                                        </form>

                                        @if ($sponsorship->status == 'نشطة')
                                            <form action="{{ route('sponsorships.end', $sponsorship->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="delete-orphan"
                                                    style="  border: none !important; box-shadow: none !important;">إنهاء</button>
                                            </form>
                                        @elseif($sponsorship->status == 'منتهية')
                                            <form action="{{ route('sponsorships.renew', $sponsorship->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="edit-guarantee">تجديد</button>
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
        const searchInput = document.getElementById("searchInput");
        const filterType = document.getElementById("filterType");
        const filterStatus = document.getElementById("filterStatus");

        const rows = document.querySelectorAll("tbody tr");

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = filterType.value;
            const selectedStatus = filterStatus.value;

            rows.forEach(row => {
                const name = row.dataset.name?.toLowerCase() || '';
                const type = row.dataset.type || '';
                const status = row.dataset.status || '';

                const matchesSearch = name.includes(searchTerm);
                const matchesType = !selectedType || type === selectedType;
                const matchesStatus = !selectedStatus || status === selectedStatus;

                if (matchesSearch && matchesType && matchesStatus) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        searchInput.addEventListener("input", filterTable);
        filterType.addEventListener("change", filterTable);
        filterStatus.addEventListener("change", filterTable);
    </script>

</body>

</html>





<script>
    document.querySelectorAll('.show-guarantee').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('modal-id').textContent = this.dataset.id;
            document.getElementById('modal-orphan-name').textContent = this.dataset.orphan;
            document.getElementById('modal-name').textContent = this.dataset.orphan;
            document.getElementById('modal-age').textContent = this.dataset.age;
            document.getElementById('modal-gender').textContent = this.dataset.gender;
            document.getElementById('modal-type').textContent = this.dataset.type;
            document.getElementById('modal-amount').textContent = this.dataset.amount;
            document.getElementById('modal-status').textContent = this.dataset.status;
            document.getElementById('modal-start').textContent = this.dataset.start;


            // تعيين الفورم للحذف حسب id الكفالة
            const sponsorshipId = this.dataset.id;
            const deleteForm = document.getElementById('delete-sponsorship-form');
            deleteForm.action = `/kafel/sponsorships/${sponsorshipId}`;

            // عرض المودال
            document.getElementById('ShowGuarantee').style.display = 'block';
        });
    });

    document.getElementById('close').addEventListener('click', function() {
        document.getElementById('ShowGuarantee').style.display = 'none';
    });

    // عند الضغط على زر الحذف
    document.getElementById('deleteBtn').addEventListener('click', function() {
        if (confirm('هل أنت متأكد أنك تريد حذف هذه الكفالة؟')) {
            document.getElementById('delete-sponsorship-form').submit();
        }
    });
</script>
