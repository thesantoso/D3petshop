@php
$is_edit = $user->exists;
$action = $is_edit ? route('admin::users.update', $user->user_id) : route('admin::users.store');
@endphp

@extends('admin.layout.master', [
'title' => $title,
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar User' => route('admin::users.index'),
$title => true,
]
])

@section('content')
<div class="card">
  <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
      <div class="form-group row">
        <label for="input-name" class="col-sm-2 col-lg-1 col-form-label">Nama</label>
        <div class="col-sm-4 col-lg-3">
          <input type="text" name="name" class="form-control" id="input-name" placeholder="Nama"
            value="{{ $user->name }}">
          <div class="help-block text-danger">{{ $errors->first('name') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-email" class="col-sm-2 col-lg-1 col-form-label">Email</label>
        <div class="col-sm-4 col-lg-3">
          <input required name="email" type="email" class="form-control" id="input-email" placeholder="Email"
            value="{{ $user->email }}">
          <div class="help-block text-danger">{{ $errors->first('email') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-title" class="col-sm-2 col-lg-1 col-form-label">Password</label>
        <div class="col-sm-4 col-lg-3">
          <input required name="price" type="password" class="form-control" id="input-price" placeholder="Password"
            value="">
          <div class="help-block text-danger">{{ $errors->first('password') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-status" class="col-sm-2 col-lg-1 col-form-label">Status</label>
        <div class="col-sm-4 col-lg-3">
          <select name="status" id="input-status" class="form-control" required>
          <option value="{{$user->status}}" selected>{{$user->status}}</option>
            <option value="pending">pending</option>
            <option value="active">active</option>
            <option value="blocked">blocked</option>
          </select>
          <div class="help-block text-danger">{{ $errors->first('status') }}</div>
        </div>
      </div>
      <div class="form-group row">
        <label for="input-type" class="col-sm-2 col-lg-1 col-form-label">Type</label>
        <div class="col-sm-4 col-lg-3">
          <select name="type" id="input-type" class="form-control" required>
          <option value="{{$user->type}}" selected>{{$user->type}}</option>
            <option value="admin">admin</option>
            <option value="member">member</option>
          </select>
          <div class="help-block text-danger">{{ $errors->first('type') }}</div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-2 col-lg-1"></div>
        <div class="col-sm-10 col-lg-11">
          <a href="{{ route('admin::users.index') }}" onclick="return confirm('Keluar dari halaman?')"
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
