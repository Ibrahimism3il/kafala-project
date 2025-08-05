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
    body{
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
                <p class="title-guarantee"> الأيتام المتاحون للكفالة</p>
                <div class="search-eara">
                    <div type="submit">
                        <input type="text" placeholder="ابحث الأن..." id="searchInput">
                    </div>
                    <select id="genderFilter" class="select-list-header">
                        <option value="">الجنس </option>
                        <option value="ذكر">ذكر</option>
                        <option value="انثى">انثى</option>
                    </select>
                    <select id="statusFilter" class="select-list-header">
                        <option value="">الحالة الإجتماعية</option>
                        <option value="يتيم الأب">يتيم الأب</option>
                        <option value="يتيم الأبوين">يتيم الأبوين</option>
                    </select>
                    <select id="sponsorshipFilter" class="select-list-header">
                        <option value="">حالة الكفالة</option>
                        <option value="مكفول">مكفول</option>
                        <option value="غير مكفول">غير مكفول</option>
                    </select>
                </div>
                <!-- زر فتح المودال -->
                <button class="btn btn-secondary" style="background-color:#34ad66; margin:10px; margin-top:20px; margin-right: 20px;"
                    onclick="document.getElementById('candidatesModal').style.display='block'">
                    عرض المرشحين للكفالة
                </button>

                <!-- المودال -->
                <div id="candidatesModal" class="modal" >
                    <div class="modal-content" style="border-radius: 10px">
                        <span class="close"
                            onclick="this.parentElement.parentElement.style.display='none'">&times;</span>
                        <h4>المرشحون للكفالة</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>اليتيم</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                    <tr>
                                        <td>{{ $candidate->orphan->name }}</td>
                                        <td>{{ $candidate->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $candidate->status }}</td>
                                        <td>
                                            @if ($candidate->status === 'مقبول')
                                                <a href="{{ route('payment.create', ['candidate_id' => $candidate->id]) }}"
                                                    class="btn-sponsor sponsor-btn accept-guarantee">ادفع الآن</a>
                                            @else
                                                <span class="text-muted">بانتظار الموافقة</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-body table-responsive" style="max-width: 90%; margin-right: 5px;">
                    <table class="table table-hover text-wrap table-lg" style="border-radius: 10px;">
                        <thead>
                            <tr>

                                <th> الأسم </th>
                                <th> العمر </th>
                                <th> الجنس </th>
                                <th> الحالة الإجتماعية </th>
                                <th>حالة الكفالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orphans as $orphan)
                                <tr>
                                    <td>{{ $orphan->name }}</td>
                                    <td>{{ $orphan->age }}</td>
                                    <td>{{ $orphan->gender }}</td>
                                    <td>{{ $orphan->social_status }}</td>
                                    <td style="color: {{ $orphan->isSponsored() ? '#68AF73' : 'red' }}">
                                        {{ $orphan->isSponsored() ? 'مكفول' : 'غير مكفول' }}
                                    </td>

                                    <td class="stutes">
                                        @if (!$orphan->isSponsored())
                                            <form action="{{ route('candidate-sponsorship.store') }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="orphan_id" value="{{ $orphan->id }}">
                                                <button type="submit" class="btn-sponsor sponsor-btn accept-guarantee" style="border: none !important; box-shadow: none !important;">إكفل الآن</button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">مكفول</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
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
                document.querySelectorAll('.accept-guarantee').forEach(button => {
                    button.addEventListener('click', function() {
                        const modalId = this.getAttribute('data-modal-id');
                        const modal = document.getElementById(modalId);
                        if (modal) {
                            modal.style.display = 'block';
                        }
                    });
                });

                document.querySelectorAll('.modal .close').forEach(closeBtn => {
                    closeBtn.addEventListener('click', function() {
                        const modal = this.closest('.modal');
                        if (modal) modal.style.display = 'none';
                    });
                });

                window.onclick = function(event) {
                    document.querySelectorAll('.modal').forEach(modal => {
                        if (event.target === modal) {
                            modal.style.display = 'none';
                        }
                    });
                };
            </script>

            <script>
                function filterOrphans() {
                    const searchText = document.getElementById("searchInput").value.toLowerCase();
                    const gender = document.getElementById("genderFilter").value;
                    const status = document.getElementById("statusFilter").value;
                    const sponsorship = document.getElementById("sponsorshipFilter").value;

                    const rows = document.querySelectorAll("table tbody tr");

                    rows.forEach(row => {
                        const name = row.cells[0].textContent.trim().toLowerCase();
                        const age = row.cells[1].textContent.trim();
                        const rowGender = row.cells[2].textContent.trim();
                        const rowStatus = row.cells[3].textContent.trim();
                        const rowSponsorship = row.cells[4].textContent.trim();

                        const matchesSearch = name.includes(searchText);
                        const matchesGender = !gender || rowGender === gender;
                        const matchesStatus = !status || rowStatus === status;
                        const matchesSponsorship = !sponsorship || rowSponsorship === sponsorship;

                        if (matchesSearch && matchesGender && matchesStatus && matchesSponsorship) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                }

                // ربط الأحداث بالفلاتر
                document.getElementById("searchInput").addEventListener("input", filterOrphans);
                document.getElementById("genderFilter").addEventListener("change", filterOrphans);
                document.getElementById("statusFilter").addEventListener("change", filterOrphans);
                document.getElementById("sponsorshipFilter").addEventListener("change", filterOrphans);
            </script>

            <script src="https://js.stripe.com/v3/"></script>
            <script>
                const stripe = Stripe("{{ env('STRIPE_KEY') }}");

                document.getElementById("pay-button").addEventListener("click", function() {
                    fetch("{{ route('payment.createStripeSession') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                orphan_id: selectedOrphanId, // سيتم تحديده من المودال
                                type: selectedType,
                                amount: selectedAmount
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            stripe.redirectToCheckout({
                                sessionId: data.id
                            });
                        })
                        .catch(error => console.error('Stripe Error:', error));
                });
            </script>


</body>

</html>
