@php
$orders_counts = DB::table('orders')
  ->select('status')
  ->selectRaw('count(orders.order_id) as count')
  ->groupBy('status')
  ->get()
  ->pluck('count', 'status')
  ->toArray();
@endphp

<div class="sidebar">
  <!-- Sidebar user (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ auth()->user()->url_avatar }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info" style="margin-top: -10px">
      <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      <a href="{{ route('admin::logout') }}"><small><i class="fa fa-sign-out-alt"></i> Logout</small></a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('admin::dashboard.index') }}" class="nav-link">
          <i class="nav-icon fas fa-home nav-icon"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin::users.index') }}" class="nav-link">
          <i class="nav-icon fas fa-user nav-icon"></i>
          <p>
            Users
          </p>
        </a>
      </li>
      {{-- MENU Produc --}}
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Produk
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin::products.index') }}" class="nav-link">
              <i class="fas fa-table nav-icon"></i>
              <p>Daftar Produk</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::products.create') }}" class="nav-link">
              <i class="fas fa-plus-circle nav-icon"></i>
              <p>Tambah Produk</p>
            </a>
          </li>
        </ul>
      </li>
      {{-- MENU KATEGORI --}}
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Kategori
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin::categories.index') }}" class="nav-link">
              <i class="fas fa-table nav-icon"></i>
              <p>Daftar Kategori</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::categories.create') }}" class="nav-link">
              <i class="fas fa-plus-circle nav-icon"></i>
              <p>Tambah Kategori</p>
            </a>
          </li>
        </ul>
      </li>
      {{-- MENU PESANAN --}}
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            Pesanan
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin::orders.index', ['status' => 'pending']) }}" class="nav-link">
              <i class="fas fa-clock nav-icon"></i>
              <p>
                Pending
                @if(isset($orders_counts['pending']))
                <span class="right badge badge-warning">{{ $orders_counts['pending'] }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::orders.index', ['status' => 'processing']) }}" class="nav-link">
              <i class="fas fa-spinner nav-icon"></i>
              <p>
                Proses
                @if(isset($orders_counts['processing']))
                <span class="right badge badge-warning">{{ $orders_counts['processing'] }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::orders.index', ['status' => 'shipping']) }}" class="nav-link">
              <i class="fas fa-truck nav-icon"></i>
              <p>
                Dikirim
                @if(isset($orders_counts['shipping']))
                <span class="right badge badge-warning">{{ $orders_counts['shipping'] }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::orders.index', ['status' => 'finish']) }}" class="nav-link">
              <i class="fas fa-check nav-icon"></i>
              <p>
                Selesai
                @if(isset($orders_counts['finish']))
                <span class="right badge badge-warning">{{ $orders_counts['finish'] }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin::orders.index', ['status' => 'canceled']) }}" class="nav-link">
              <i class="fas fa-ban nav-icon"></i>
              <p>
                Dibatalkan
                @if(isset($orders_counts['canceled']))
                <span class="right badge badge-warning">{{ $orders_counts['canceled'] }}</span>
                @endif
              </p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
