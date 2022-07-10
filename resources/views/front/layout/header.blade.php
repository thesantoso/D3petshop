@php
$route_name = request()->route()->getName();
@endphp
<!--================ Start Header Menu Area =================-->
<header class="header_area navbar_fixed">
  <div class="main_menu">
    <div class="search_input" id="search_input_box">
      <div class="container">
        <form class="d-flex justify-content-between" method="" action="{{ route('front::products.index') }}">
          <input type="text" class="form-control" id="search_input" name="keyword" value="{{ request('keyword') }}" placeholder="Search Here" />
          <button type="submit" class="btn"></button>
          <span class="ti-close" id="close_search" title="Close Search"></span>
        </form>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-purple">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand logo_h" href="{{ route('front::home') }}">
          {{-- <img src="{{ asset('edustage') }}/img/logo.png" alt=""/> --}}
          <strong>D3 PetsShop</strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar"></span> <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
          <ul class="nav navbar-nav menu_nav ml-auto">
            <li class="nav-item {{ $route_name == 'front::home' ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('front::home') }}">Beranda</a>
            </li>
            <li class="nav-item {{ $route_name == 'front::products.index' ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('front::products.index') }}">Produk</a>
            </li>
            {{-- <li class="nav-item submenu dropdown">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
                >Blog</a
              >
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="nav-link" href="blog.html">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="single-blog.html"
                    >Blog Details</a
                  >
                </li>
              </ul>
            </li> --}}
            @if(auth()->user() && auth()->user()->isMember())
            <li class="nav-item submenu dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Akun Saya</a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('front::account.index') }}">Profil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('front::account.orders') }}">Pembelian</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('front::member-address.index') }}">Kelola Alamat</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('front::account.change-password') }}">Ubah Password</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('front::logout') }}">Logout</a>
                </li>
              </ul>
            </li>
            @else
            <li class="nav-item {{ $route_name == 'front::login.form' ? 'active' : '' }}">
              <a href="{{ route('front::login.form') }}" class="nav-link">
                Login
              </a>
            </li>
            <li class="nav-item {{ $route_name == 'front::register.form' ? 'active' : '' }}">
              <a href="{{ route('front::register.form') }}" class="nav-link">
                Register
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="#" class="nav-link toggle-cart">
                <i class="ti-shopping-cart"></i>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link search" id="search">
                <i class="ti-search"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>
<!--================ End Header Menu Area =================-->