<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" style="all: unset; cursor: pointer; width: 100%;">
        <div class="menu-item">
            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
            <span> تسجيل خروج</span>
        </div>
    </button>
</form>
