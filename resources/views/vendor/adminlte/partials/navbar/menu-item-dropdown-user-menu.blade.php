@php
    $user = Auth::user();

    $displayName = trim(
        ($user->first_name ?? '') . ' ' .
        ($user->middle_name ?? '') . ' ' .
        ($user->last_name ?? '')
    );

    if ($displayName === '') {
        $displayName = $user->name ?? 'User';
    }

    $displayRole = $user->role ?? 'Administrator';
    $displayEmail = $user->email ?? '';
@endphp

<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link d-flex align-items-center" data-toggle="dropdown" aria-expanded="false">
            <div class="d-flex align-items-center">
                <div class="user-menu-avatar mr-2">
                    {{ strtoupper(substr($displayName, 0, 1)) }}
                </div>

                <div class="d-none d-md-flex flex-column text-left" style="line-height: 1.1;">
                    <span class="user-menu-name">{{ $displayName }}</span>
                    <small class="user-menu-role">{{ ucfirst($displayRole) }}</small>
                </div>
            </div>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-menu-dropdown">
            <div class="user-header bg-white text-center py-3">
                <div class="user-menu-avatar-lg mx-auto mb-2">
                    {{ strtoupper(substr($displayName, 0, 1)) }}
                </div>

                <div class="font-weight-bold">{{ $displayName }}</div>

                @if($displayEmail)
                    <div class="text-muted small">{{ $displayEmail }}</div>
                @endif

                <span class="badge badge-primary mt-2">
                    {{ ucfirst($displayRole) }}
                </span>
            </div>

            <div class="dropdown-divider m-0"></div>
            <div class="dropdown-header text-muted">
                <h6 class="fas fa-user">My Account</h6>
            </div>

            <div class="dropdown-divider"></div>

            <a href="{{ route('myaccount.view') }}" class="dropdown-item">
                <i class="fas fa-user-circle mr-2 text-primary"></i>
                View Account
            </a>

            <a href="{{ route('myaccount.edit') }}" class="dropdown-item">
                <i class="fas fa-user-edit mr-2 text-success"></i>
                Update Account
            </a>

            <a href="{{ route('myaccount.deactivate') }}" class="dropdown-item">
                <i class="fas fa-user-times mr-2 text-danger"></i>
                Deactivate Account
            </a>

            <div class="dropdown-divider"></div>

            <div class="px-3 pb-2">
                <form action="{{ route('logout') }}" method="POST" class="m-0"
                      onsubmit="return confirm('Are you sure you want to log out?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block rounded-pill">
                        <i class="fas fa-sign-out-alt mr-1"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </li>
</ul>

<style>
    .user-menu-avatar,
    .user-menu-avatar-lg {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #f47607, #f47607);
    }

    .user-menu-avatar {
        width: 34px;
        height: 34px;
    }

    .user-menu-avatar-lg {
        width: 60px;
        height: 60px;
        font-size: 22px;
    }

    .user-menu-name {
        font-weight: 600;
        color: #343a40;
    }

    .user-menu-role {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .user-menu-dropdown {
        border-radius: 14px;
        overflow: hidden;
        min-width: 260px;
        padding: 0;
    }
</style>