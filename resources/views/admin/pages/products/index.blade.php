@extends('admin.layout.master', [
'title' => 'Daftar Produk',
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Produk' => true
]
])

@section('content')
@include('admin.partials.alert-messages')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-8">
        <form class="form-inline" method="GET" action="{{ route('admin::products.index') }}">
          <div class="form-group">
            <div class="input-group">
              @if(request('keyword'))
              <div class="input-group-prepend">
                <a href="{{ route('admin::products.index') }}" class="btn btn-warning">
                  <i class="fas fa-times"></i>
                </a>
              </div>
              @endif
              <input type="text" class="form-control" name="keyword" placeholder="Pencarian..." value="{{ request('keyword') }}">
              <div class="input-group-append">
                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-4 text-right">
        <a href="{{ route('admin::products.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Produk</a>
      </div>
    </div>
  </div>
  @if($products->count() === 0)
  <div class="card-body p-5 text-center text-muted">
    <h4 class="m-0">Data Kosong</h4>
  </div>
  @else
  <div class="card-body p-0">
    <table class="table table-bordered table-striped table-hover m-0">
      <thead>
        <tr>
          <th width="70" class="text-center">Foto Produk</th>
          <th>Nama Produk</th>
          <th width="300" class="text-left">Kategori</th>
          <th width="120" class="text-right">Harga</th>
          <th width="120" class="text-center">Stok</th>
          <th width="200" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td class="text-center"><img src="{{ $product->url_cover }}" class="img-thumbnail" alt="Cover"></td>
          <td>
            <a href="{{ $product->url_show }}" target="_blank">{{ $product->title }}</a>
          </td>
          <td class="text-left">{{ $product->categories->pluck('name')->implode(', ') }}</td>
          <td class="text-right">{{ $product->price_label }}</td>
          <td class="text-center">{{ $product->stock_label }}</td>
          <td class="text-center">
            <a href="{{ route('admin::products.edit', $product->product_id) }}" class="btn btn-primary btn-edit btn-sm">Edit</a>
            <form action="{{ route('admin::products.delete', $product->product_id) }}" class="d-inline" method="post">
              @csrf
              <button class="btn btn-danger btn-sm" onclick="return confirm('Apa kamu yakin ingin menghapus produk ini?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {!! $products->appends($_GET)->links() !!}
  </div>
</div>
@endif
@stop