@php
$is_edit = $category->exists;
$action = $is_edit ? route('admin::categories.update', $category->category_id) : route('admin::categories.store');
$title = $is_edit ? "Edit Kategori" : "Tambah Kategori";
@endphp

@extends('admin.layout.master', [
'title' => $title,
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Produk' => route('admin::categories.index'),
$name => true,
]
])

@section('content')
<div class="card">
  <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
      <div class="form-group row">
        <label for="input-name" class="col-sm-2 col-lg-1 col-form-label">Nama Kategori</label>
        <div class="col-sm-4 col-lg-3">
          <input type="text" name="name" class="form-control" id="input-name" placeholder="Nama Kategori" value="{{ $category->name }}">
          <div class="help-block text-danger">{{ $errors->first('name') }}</div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-2 col-lg-1"></div>
        <div class="col-sm-10 col-lg-11">
          <a href="{{ route('admin::categories.index') }}" onclick="return confirm('Keluar dari halaman?')" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Batal
          </a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </form>
</div>
@stop