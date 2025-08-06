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
    >
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet"> -->
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
            <div class="main-content">
                <p class="title-guarantee">إدارة المدفوعات</p>

                <div class="search-eara">
                    <input type="text" id="searchInput" placeholder="ابحث الأن...">

                    <select id="methodFilter" class="select-list-header">
                        <option value="">وسيلة الدفع</option>
                        <option value="بنكي">بنكي</option>
                        <option value="Palpay">Palpay</option>
                        <option value="كاش">كاش</option>
                        <option value="محفظة">محفظة</option>
                    </select>

                    <select id="statusFilter" class="select-list-header">
                        <option value="">حالة الدفع</option>
                        <option value="مكتمل">مكتمل</option>
                        <option value="غير مستوفي">غير مستوفي</option>
                    </select>
                </div>


                <div class="card-body table-responsive" style="max-width: 90%; margin-right: 15px;">
                    <table class="table table-hover text-wrap table-lg"
                        style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th>رقم المعاملة</th>
                                <th>أسم الكافل</th>
                                <th>المبلغ</th>
                                <th>تاريخ الدفع</th>
                                <th>وسيلة الدفع</th>
                                <th>حالة الدفع</th>
                                <th colspan="2">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ optional($payment->user)->name }}</td>
                                    <td>${{ $payment->amount }}</td>
                                    <td>{{ $payment->payment_date }}</td>
                                    <td>{{ $payment->method }}</td>
                                    <td style="color: {{ $payment->status == 'مكتمل' ? '#68AF73' : 'red' }};">
                                        {{ $payment->status }}
                                    </td>
                                    <td class="stutes">
                                        <a href="#" class="show-guarantee"
                                            onclick="openPaymentModal({{ $payment->id }})">تفاصيل</a>

                                        <!-- Modal -->
                                        <div id="paymentModal{{ $payment->id }}" class="modalshow"
                                            style="display: none;">
                                            <div class="modal-content-show">
                                                <div class="title-modalshow">
                                                    <p>تفاصيل الدفعة</p><span># {{ $payment->id }} </span>
                                                </div>
                                                <hr>
                                                <p class="modalshow-title">معلومات الكفالة الأساسية</p>
                                                <div class="main-detailes">
                                                    <p><strong>رقم المعاملة:</strong> {{ $payment->id }}</p>
                                                    <p><strong>المبلغ :</strong> ${{ $payment->amount }}</p>
                                                    <p><strong>الحالة:</strong> {{ $payment->status }}</p>
                                                    <p><strong>تاريخ الدفع:</strong> {{ $payment->payment_date }}</p>
                                                    <p><strong>وسيلة الدفع :</strong> {{ $payment->method }}</p>
                                                    <hr>
                                                    <p class="modalshow-title">معلومات الكافل</p>
                                                    <p><strong>الأسم كامل :</strong>
                                                        {{ optional($payment->user)->name }}</p>
                                                    <p><strong>البريد الألكتروني :</strong>
                                                        {{ optional($payment->user)->email }}</p>
                                                    <p><strong>رقم الهاتف:</strong>
                                                        {{ optional($payment->user)->phone }}</p>
                                                    <hr>
                                                    <p class="modalshow-title">معلومات الكفالة</p>
                                                    <p><strong>نوع الدفعة :</strong>
                                                          {{ optional($payment->sponsorship)->type ?? '-' }}</p>
                                                    <p><strong>اليتيم المكفول :</strong>
                                                         {{ optional(optional($payment->sponsorship)->orphan)->name ?? '-' }}</p>
                                                    <p><strong>رقم الكفالة :</strong>
                                                        #{{ optional($payment->sponsorship)->id ?? '-' }}</p>
                                                </div>
                                                <div class="btn-show-guarantee">
                                                    {{-- <form action="{{ route('admin.payments.notify', $payment->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        <button class="send-to-donor"
                                                            style="  border: none !important; box-shadow: none !important;"
                                                            type="submit">إرسال إشعار
                                                            للكافل</button>
                                                    </form> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.payments.accept', $payment->id) }}"
                                            method="POST" style="display: inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="accept-guarantee" type="submit"
                                                style="  border: none !important; box-shadow: none !important;">قبول</button>
                                        </form>

                                        <form action="{{ route('admin.payments.reject', $payment->id) }}"
                                            method="POST" style="display: inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="delete-orphan" type="submit"
                                                style="  border: none !important; box-shadow: none !important;">رفض</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                function openPaymentModal(id) {
                    document.getElementById("paymentModal" + id).style.display = "flex";
                }

                function closePaymentModal(id) {
                    document.getElementById("paymentModal" + id).style.display = "none";
                }
            </script>

            <script>
                function openPaymentModal(id) {
                    var modal = document.getElementById("paymentModal" + id);
                    if (modal) modal.style.display = "flex";
                }

                function closePaymentModal(id) {
                    var modal = document.getElementById("paymentModal" + id);
                    if (modal) modal.style.display = "none";
                }

                // إغلاق عند الضغط خارج المحتوى
                window.addEventListener('click', function(e) {
                    document.querySelectorAll('.modalshow').forEach(function(modal) {
                        if (e.target === modal) {
                            modal.style.display = "none";
                        }
                    });
                });
            </script>



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
        function openPaymentModal(id) {
            document.getElementById("paymentModal" + id).style.display = "flex";
        }

        function closePaymentModal(id) {
            document.getElementById("paymentModal" + id).style.display = "none";
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const methodFilter = document.getElementById('methodFilter');
            const statusFilter = document.getElementById('statusFilter');

            function applyFilters() {
                const searchValue = searchInput.value.toLowerCase();
                const selectedMethod = methodFilter.value;
                const selectedStatus = statusFilter.value;

                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(row => {
                    const donorName = row.children[1].textContent.toLowerCase();
                    const method = row.children[4].textContent.trim();
                    const status = row.children[5].textContent.trim();

                    const matchesSearch = donorName.includes(searchValue);
                    const matchesMethod = selectedMethod === '' || method === selectedMethod;
                    const matchesStatus = selectedStatus === '' || status === selectedStatus;

                    if (matchesSearch && matchesMethod && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', applyFilters);
            methodFilter.addEventListener('change', applyFilters);
            statusFilter.addEventListener('change', applyFilters);
        });
    </script>

</body>

</html>
