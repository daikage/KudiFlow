<div class="topbar d-flex align-items-center justify-content-between">
    <button class="btn btn-sm btn-outline-secondary btn-toggle-sidebar d-lg-none">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="d-flex align-items-center gap-3 ms-auto">
        <form method="POST" action="{{ route('logout') ?? '#' }}">
            @csrf
            <button class="btn btn-sm btn-outline-secondary">Logout</button>
        </form>
    </div>
</div>
