<div class="sidebar" style="width: 225px; background: #f8f9fa; padding: 1rem; height: 100vh; direction: rtl;">
    <h3 style="margin-bottom: 1rem;">لوحة التحكم</h3>

    @auth
        {{-- ✅ قائمة المدير --}}
        @if(Auth::user()->email === 'admin@example.com')
            <div class="menu">
                     <a href="{{ url('admin/dashboard') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-user"></i></span>
                        <span>الرئيسية</span>
                    </div>
                </a>
                <a href="{{ url('admin/orphans') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-user"></i></span>
                        <span>إدارة الأيتام</span>
                    </div>
                </a>
                <a href="{{ url('admin/DonorsManagement') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-users"></i></span>
                        <span>إدارة الكافلين</span>
                    </div>
                </a>
                <a href="{{ url('admin/GuaranteeManagement') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-file"></i></span>
                        <span>إدارة الكفالات</span>
                    </div>
                </a>
                <a href="{{ url('admin/paymentsManagement') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-credit-card"></i></span>
                        <span>إدارة المدفوعات</span>
                    </div>
                </a>
                <a href="{{ url('admin/notifications') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-bell"></i></span>
                        <span>الإشعارات</span>
                    </div>
                </a>
                <a href="{{ url('admin/editProfile') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-cog"></i></span>
                        <span>تعديل الحساب</span>
                    </div>
                </a>
            </div>

        {{-- ✅ قائمة الكافل --}}
        @elseif(Auth::user()->role === 'kafel')
            <div class="menu">
                     <a href="{{ url('kafel/dashboard') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-user"></i></span>
                        <span>الرئيسية</span>
                    </div>
                </a>
                <a href="{{ url('kafel/showOrphan') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-users"></i></span>
                        <span>عرض الأيتام</span>
                    </div>
                </a>
                <a href="{{ url('kafel/guarantee') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-file"></i></span>
                        <span>إدارة الكفالات</span>
                    </div>
                </a>
                <a href="{{ url('kafel/notifications') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-bell"></i></span>
                        <span>الإشعارات</span>
                    </div>
                </a>
                <a href="{{ url('kafel/editProfile') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-cog"></i></span>
                        <span>تعديل الحساب</span>
                    </div>
                </a>
            </div>

        {{-- ✅ قائمة اليتيم --}}
        @elseif(Auth::user()->role === 'orphan')
            <div class="menu">
                  <a href="{{ url('orphan/dashboard') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-user"></i></span>
                        <span>الرئيسية</span>
                    </div>
                </a>
                <a href="{{ url('orphan/detailesOrphan') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-user"></i></span>
                        <span>بيانات اليتيم</span>
                    </div>
                </a>
                <a href="{{ url('orphan/documents') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-file"></i></span>
                        <span>وثائق</span>
                    </div>
                </a>
                <a href="{{ url('orphan/Myguarantee') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-calendar"></i></span>
                        <span>الكفالات</span>
                    </div>
                </a>
                <a href="{{ url('orphan/notifications') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-bell"></i></span>
                        <span>الإشعارات</span>
                    </div>
                </a>
                <a href="{{ url('orphan/editProfile') }}">
                    <div class="menu-item">
                        <span class="menu-icon"><i class="fas fa-cog"></i></span>
                        <span>تعديل الحساب</span>
                    </div>
                </a>
            </div>
        @endif

        {{-- ✅ زر تسجيل الخروج --}}
        <hr>
        @include('layouts.logout-button')
    @endauth
</div>
