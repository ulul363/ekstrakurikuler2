<style>
    .profile-notification {
    width: 300px; /* Sesuaikan lebar dropdown */
}

.pro-head {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.pro-head img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
}

.pro-head span {
    flex-grow: 1;
}

.pro-body {
    padding: 0;
}

.pro-body li {
    border-bottom: 1px solid #ddd;
}

.pro-body li:last-child {
    border-bottom: none;
}

.dropdown-item {
    padding: 10px 15px;
}

</style>

<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="#!" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="{{ asset('assets/images/logo-man3.png') }}" style="width: 45px; height: 45px;" alt=""
                class="logo">
            <img src="{{ asset('dist/assets/images/logo-icon.png') }}" alt="" class="logo-thumb">
        </a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="feather icon-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head" style="width: 300px;"> <!-- Menambahkan lebar dropdown -->
                            <img src="{{ asset('dist/assets/images/user/avatar-1.jpg') }}" class="img-radius"
                                alt="User-Profile-Image">
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{ route('profile.show') }}" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                            {{-- <li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My
                                    Messages</a></li>
                            <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock
                                    Screen</a></li> --}}
                            <li>
                                <a href="javascript:void(0);"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </li>
        </ul>
    </div>


</header>
