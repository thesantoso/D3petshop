@php
$route_name = request()->route()->getName();
@endphp

<h4>Menu Member</h4>
<div class="list-group secondary categories">
  <a href="{{ route('front::account.index') }}" class="{{ $route_name == 'front::account.index' ? 'active' : '' }} list-group-item list-group-item-action">
    <i class="mr-2 text-primary ti ti-user"></i>
    Profil
  </a>
  <a href="{{ route('front::account.orders') }}" class="{{ $route_name == 'front::account.orders' ? 'active' : '' }} list-group-item list-group-item-action">
    <i class="mr-2 text-primary ti ti-shopping-cart-full"></i>
    Pembelian
  </a>
  <a href="{{ route('front::member-address.index') }}" class="{{ $route_name == 'front::member-address.index' ? 'active' : '' }} list-group-item list-group-item-action">
    <i class="mr-2 text-primary ti ti-map-alt"></i>
    Kelola Alamat
  </a>
  <a href="{{ route('front::account.change-password') }}" class="{{ $route_name == 'front::account.change-password' ? 'active' : '' }} list-group-item list-group-item-action">
    <i class="mr-2 text-primary ti ti-lock"></i>
    Ubah Password
  </a>
  <a href="{{ route('front::logout') }}" class="text-danger list-group-item list-group-item-action">
    <i class="mr-2 ti ti-close text-warning"></i>
    Logout
  </a>
</div>