<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('storage/img/image.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('storage/img/avatar.png') }}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/img/image.png') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('tickets*')) ? 'active' : '' }}" href="{{ route('tickets.index') }}">
                        <i class="ni ni-tv-2 text-primary"></i> Pengaduan
                    </a>
                </li>
                @if(! Auth::user()->isClient())
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('locations*')) ? 'active' : '' }}" href="{{ route('locations.index') }}">
                        <i class="ni ni-pin-3 text-orange"></i> Lokasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('print*')) ? 'active' : '' }}" href="{{ route('option') }}">
                        <i class="ni ni-folder-17 text-info"></i> Cetak Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="ni ni-circle-08 text-pink"></i> Manage Pengguna
                    </a>
                </li>
                @endif
            </ul>
            <!-- Divider -->
            <hr class="my-3">
    </div>
</nav>