<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ isset($title) ? $title : config('app.name') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @section('styles')
    @include('admin.layout.styles')
  @show
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    @include('admin.layout.navbar-menu-left')
    {{-- @include('admin.layout.search-form') --}}
    @include('admin.layout.navbar-menu-right')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('adminlte') }}/index3.html" class="brand-link">
      <img src="{{ asset('adminlte') }}/dist/img/AdminLTELogo.png"
           alt="Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    @include('admin.layout.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-3">
    @if(isset($title))
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          @if(isset($breadcrumb) && is_array($breadcrumb))
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @foreach($breadcrumb as $label => $url)
              <li class="breadcrumb-item {{ $url === true ? 'active' : '' }}">
                @if($url === true)
                <span>{!! $label !!}</span>
                @else
                <a href="{{ $url ?: '#' }}">{!! $label !!}</a>
                @endif
              </li>
              @endforeach
            </ol>
          </div>
          @endif
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endif

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('admin.layout.footer')

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@section('scripts')
  @include('admin.layout.scripts')
@show
</body>
</html>
