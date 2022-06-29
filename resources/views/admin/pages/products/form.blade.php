@php
$is_edit = $product->exists;
$action = $is_edit ? route('admin::products.update', $product->product_id) : route('admin::products.store');
$categories = DB::table('categories')->orderBy('name')->get();
$product_category_ids = $is_edit ? $product->categories()->pluck('product_categories.category_id')->toArray() : [];
@endphp

@extends('admin.layout.master', [
'title' => $title,
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Produk' => route('admin::products.index'),
$title => true,
]
])

@section('content')
<div class="card">
  <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
      <div class="form-group row">
        <label for="input-title" class="col-sm-2 col-lg-1 col-form-label">Judul</label>
        <div class="col-sm-4 col-lg-3">
          <input type="text" name="title" class="form-control" id="input-title" placeholder="Judul"
            value="{{ $product->title }}">
          <div class="help-block text-danger">{{ $errors->first('title') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-stock" class="col-sm-2 col-lg-1 col-form-label">Stok</label>
        <div class="col-sm-4 col-lg-3">
          <input required name="stock" min="0" type="number" class="form-control" id="input-stock" placeholder="Stok"
            value="{{ $product->stock }}">
          <div class="help-block text-danger">{{ $errors->first('stock') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-title" class="col-sm-2 col-lg-1 col-form-label">Harga</label>
        <div class="col-sm-4 col-lg-3">
          <input required name="price" type="number" class="form-control" id="input-price" placeholder="Harga"
            value="{{ $product->price }}">
          <div class="help-block text-danger">{{ $errors->first('price') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-cover" class="col-sm-2 col-lg-1 col-form-label">Cover</label>
        <div class="col-sm-4 col-lg-3">
          <div class="form-group">
            <input {{ $is_edit ? '' : 'required' }} name="cover" accept=".jpeg,.jpg,.png" type="file" id="cover">
          </div>
          @if($is_edit)
          <div class="help-block text-muted"><i class="fa fa-info-circle m-2"></i> Kosongkan jika tidak ingin mengubah
            gambar.</div>
          @endif
          <div class="help-block text-danger">{{ $errors->first('cover') }}</div>
        </div>
      </div>
      <hr>
      <div class="form-group row">
        <label for="input-description" class="col-sm-2 col-lg-1 col-form-label">Deskripsi</label>
        <div class="col-sm-4 col-lg-3">
          <textarea required name="description" class="form-control" id="input-description" placeholder="Deskripsi"
            rows="7">{{ $product->description }}</textarea>
          <div class="help-block text-danger">{{ $errors->first('title') }}</div>
        </div>
      </div>
      <hr>
      <div class="form-group row">
        <label for="input-categories" class="col-sm-2 col-lg-1 col-form-label">Kategori</label>
        <div class="col-sm-4 col-lg-3">
          <select name="category_ids[]" id="input-categories" class="form-control" multiple required>
            @foreach($categories as $category)
            <option value="{{ $category->category_id }}"
              {{ in_array($category->category_id, $product_category_ids) ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
            @endforeach
          </select>
          <div class="help-block text-danger">{{ $errors->first('title') }}</div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-2 col-lg-1"></div>
        <div class="col-sm-10 col-lg-11">
          <a href="{{ route('admin::products.index') }}" onclick="return confirm('Keluar dari halaman?')"
            class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Batal
          </a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </form>
</div>
@stop
