<nav
  class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
  data-aos="fade-down"
>
  <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand">
      <img src="/images/logo.svg" alt="logo" />
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarResponsive"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
          <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item {{ Request::is('products*') ? 'active' : '' }}">
          <a href="{{ route('products') }}" class="nav-link">Products</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link disabled">Promo</a>
        </li>
        @guest
          <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link btn btn-success px-4 text-white"
              >Sign In</a
            >
          </li>
        @endguest
      </ul>
      @auth
        <ul class="navbar-nav d-none d-lg-flex">
          <li class="nav-item dropdown">
            <a
              href="#"
              class="nav-link"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
            >
              <img
                src="{{ Storage::url( Auth::user()->photo ? Auth::user()->photo : 'assets/user/userDefault.png' ) }}"
                class="rounded-circle mr-2 profile-picture"
                style="width: 45px;height: 45px"
              />
              Hi, {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu">
              <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
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
          <li class="nav-item">
            <a href="#" class="nav-link"> Hi, Sandy </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('cart') }}" class="nav-link d-inline-block"> Cart </a>
          </li>
        </ul>
      @endauth
    </div>
  </div>
</nav>
