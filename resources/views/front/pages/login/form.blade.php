@extends('front.layout.master', ['title' => 'Login Member'])

@section('content')
<section id="content" class="py-md-5 py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2 class="text-center">Login Member</h2>
        @include('front.partials.alert-messages')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('front::login.submit') }}" method="POST">
              {!! csrf_field() !!}
              <div class="form-group">
                <label for="">Email</label>
                <input autofocus name="email" type="email" class="form-control" required>
                <div class="help-block text-danger">{{ $errors->first('email') }}</div>
              </div>
              <div class="form-group">
                <label for="">Password</label>
                <input name="password" type="password" class="form-control" required>
                <div class="help-block text-danger">{{ $errors->first('password') }}</div>
              </div>
              <hr>
              <div class="text-right">
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                <button class="btn btn-primary btn-block">Login</button>
              </div>
            </form>
          </div>
        </div>
        <div class="mt-3">
          <span>Belum punya akun?</span>
          <a href="{{ route('front::register.form', ['redirect' => request('redirect')]) }}">daftar</a>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
