@extends('admin.layout.master', [
'title' => 'Daftar Kategori',
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Kategori' => true
]
])

@section('content')
@include('admin.partials.alert-messages')
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-8">
        <form class="form-inline" method="GET" action="{{ route('admin::categories.index') }}">
          <div class="form-group">
            <div class="input-group">
              @if(request('keyword'))
              <div class="input-group-prepend">
                <a href="{{ route('admin::categories.index') }}" class="btn btn-warning">
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
        <a href="{{ route('admin::categories.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Kategori</a>
      </div>
    </div>
  </div>
  @if($categories->count() === 0)
  <div class="card-body p-5 text-center text-muted">
    <h4 class="m-0">Data Kosong</h4>
  </div>
  @else
  <div class="card-body p-0">
    <table class="table table-bordered table-striped table-hover m-0">
      <thead>
        <tr>
          <th>Nama</th>
          <th width="200" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td class="text-center">
            <a href="{{ route('admin::categories.edit', $category->category_id) }}" class="btn btn-primary btn-edit btn-sm">Edit</a>
            <form action="{{ route('admin::categories.delete', $category->category_id) }}" class="d-inline" method="post">
              @csrf
              <button class="btn btn-danger btn-sm" onclick="return confirm('Apa kamu yakin ingin menghapus pesanan ini?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {!! $categories->appends($_GET)->links() !!}
  </div>
</div>
@endif
@stop