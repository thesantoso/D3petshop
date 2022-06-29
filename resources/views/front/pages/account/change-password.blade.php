@extends('front.layout.master', ['title' => 'Ubah Password'])

@php
$user = auth()->user();
@endphp

@section('content')
<section id="content">
  <div class="container py-md-5 py-3">
    <div class="row">
      <div class="col-md-3">
        @include('front.partials.menu-member')
      </div>
      <div class="col-md-9">
        <h1>Ubah Password</h1>
        <div class="row">
          <div class="col-md-5">
            @include('front.partials.alert-messages')
            <form action="{{ route('front::account.submit-change-password') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Password saat ini</label>
                <input type="password" class="form-control" name="current_password">
                <div class="help-block text-danger">{{ $errors->first('current_password') }}</div>
              </div>
              <hr>
              <div class="form-group">
                <label>Password Baru</label>
                <input type="password" class="form-control" name="new_password">
                <div class="help-block text-danger">{{ $errors->first('new_password') }}</div>
              </div>
              <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="password_confirmation">
                <div class="help-block text-danger">{{ $errors->first('password_confirmation') }}</div>
              </div>
              <button class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
  @parent
  <script>
    $("#modal-form-member-address").on('edit.success add.success', function() {
      window.location.reload();
    });
  </script>
@stop
