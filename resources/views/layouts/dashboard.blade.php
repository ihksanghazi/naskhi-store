<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="manifest" href="/site.webmanifest">

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    @stack('addon-style')
  </head>

  <body>
    <div class="page-dashboard">
      <div class="d-flex" id="wrapper" data-aos="fade-right">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="/images/dashboard-store-logo.svg" class="my-4" />
          </div>
          <div class="list-group list-group-flush">
            <a
              href="{{ route('dashboard') }}"
              class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'active' : '' }}"
              >Dashboard</a
            >
            <a
              href="{{ route('dashboard-product') }}"
              class="list-group-item list-group-item-action {{ Request::is('dashboard/product*') ? 'active' : '' }}"
              >My Product</a
            >
            <a
              href="{{ route('dashboard-transaction') }}"
              class="list-group-item list-group-item-action {{ Request::is('dashboard/transactions*') ? 'active' : '' }}"
              >Transactions</a
            >
            <a
              href="{{ route('dashboard-setting-store') }}"
              class="list-group-item list-group-item-action {{ Request::is('dashboard/setting') ? 'active' : '' }}"
              >Store Settings</a
            >
            <a
              href="{{ route('dashboard-setting-account') }}"
              class="list-group-item list-group-item-action {{ Request::is('dashboard/account*') ? 'active' : '' }}"
              >My Account</a
            >
            <form action="{{ route('logout') }}" method="POST" >
              @csrf
              <button type="submit" class="list-group-item list-group-item-action">Sign Out</button>
            </form>
          </div>
        </div>
        <!-- Page Content -->
        <div id="page-content-wrapper">
          <nav
            class="navbar navbar-expand-lg navbar-light navbar-store fixed-top"
            data-aos="fade-down"
          >
            <div class="container-fluid">
              <button
                class="btn btn-secondary d-md-none mr-auto mr-2"
                id="menu-toggle"
              >
                &laquo; Menu
              </button>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
              >
                
                <img
                  src="{{ Storage::url( Auth::user()->photo ? Auth::user()->photo : 'assets/user/userDefault.png' ) }}"
                  class="rounded-circle mr-2 profile-picture navbar-toggler-icon"
                  style="width: 45px;height: 45px;"
                  />

              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
                  <li class="nav-item dropdown">
                    <a
                      href="#"
                      class="nav-link"
                      id="navbarDropdown"
                      role="button"
                      data-toggle="dropdown"
                    >
                      <img
                        src="{{ Storage::url(Auth::user()->photo ? Auth::user()->photo : 'assets/user/userDefault.png') }}"
                        class="rounded-circle mr-2 profile-picture"
                        style="width: 45px;height: 45px"
                      />
                      Hi, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                      <a href="{{ route('home') }}" class="dropdown-item">Beranda</a>
                      @can('isAdmin')
                        <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Administrator</a>  
                      @endcan
                      <a href="{{ route('dashboard-setting-account') }}" class="dropdown-item"
                        >Settings</a
                      >
                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                      @php
                        $carts = \App\Models\Cart::where('users_id',Auth::user()->id)->count();
                      @endphp
                      @if ($carts > 0)
                        <img src="/images/icon-card-filled.svg" />
                        <div class="card-badge">{{ $carts }}</div>
                      @else  
                        <img src="/images/icon-card-empty.svg" />
                      @endif
                    </a>
                  </li>
                </ul>

                <ul class="navbar-nav d-block d-lg-none">
                  <li class="nav-item dropdown">
                    <a
                      href="#"
                      class="nav-link"
                      id="navbarDropdown"
                      role="button"
                      data-toggle="dropdown"
                    >
                      Hi, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                      <a href="{{ route('home') }}" class="dropdown-item">Beranda</a>
                      @can('isAdmin')
                        <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Administrator</a>  
                      @endcan
                      <a href="{{ route('dashboard-setting-account') }}" class="dropdown-item"
                        >Settings</a
                      >
                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2 w-100"> Carts
                      @php
                        $carts = \App\Models\Cart::where('users_id',Auth::user()->id)->count();
                      @endphp
                      @if ($carts > 0)
                        <img src="/images/icon-card-filled.svg" class="float-right" />
                        <div class="card-badge float-right">{{ $carts }}</div>
                      @else  
                        <img src="/images/icon-card-empty.svg" class="float-right" />
                      @endif
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>

          <!-- Section Content -->
          @yield('content')
          @include('includes.footer')
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script>
      $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
    </script>
    @stack('addon-script')
  </body>
</html>
