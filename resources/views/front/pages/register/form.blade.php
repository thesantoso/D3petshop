@extends('front.layout.master', ['title' => 'Register Member'])

@section('content')
<section id="content" class="py-md-5 py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="text-center">Register Member</h2>
        @include('front.partials.alert-messages')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('front::register.submit') }}" method="POST">
              {!! csrf_field() !!}
              <div class="form-group">
                <label>Nama</label>
                <input autofocus name="name" type="text" class="form-control" required>
                <div class="help-block text-danger">{{ $errors->first('name') }}</div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email</label>
                    <input autofocus name="email" type="email" class="form-control" required>
                    <div class="help-block text-danger">{{ $errors->first('email') }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>No. Handphone</label>
                    <input autofocus name="phone" type="text" class="form-control" required>
                    <div class="help-block text-danger">{{ $errors->first('phone') }}</div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input name="birth_date" type="date" class="form-control" required>
                    <div class="help-block text-danger">{{ $errors->first('birth_date') }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                      <option value="male">Pria</option>
                      <option value="female">Wanita</option>
                    </select>
                    <div class="help-block text-danger">{{ $errors->first('gender') }}</div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" required>
                    <div class="help-block text-danger">{{ $errors->first('password') }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" class="form-control" required>
                    <div class="help-block text-danger">{{ $errors->first('password_confirmation') }}</div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-right">
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                <button class="btn btn-primary btn-block">Register</button>
              </div>
            </form>
          </div>
        </div>
        <div class="mt-3">
          <span>Sudah punya akun?</span>
          <a href="{{ route('front::login.form', ['redirect' => request('redirect')]) }}">login</a>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
