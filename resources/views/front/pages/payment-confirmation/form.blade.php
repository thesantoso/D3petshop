@extends('front.layout.master', ['title' => 'Konfirmasi Pembayaran'])

@section('content')
<section id="content" class="py-md-5 py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2 class="text-center">Konfirmasi Pembayaran</h2>
        @include('front.partials.alert-messages')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('front::payment-confirmation.submit') }}" method="POST" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="form-group">
                <label for="">Kode Transaksi</label>
                <input autofocus name="code" value="{{ request('code') }}" type="text" maxlength="9" class="form-control" style="text-transform:uppercase" required>
                <div class="help-block text-danger">{{ $errors->first('code') }}</div>
              </div>
              <div class="form-group">
                <label for="">Bukti Pembayaran</label>
                <input name="payment_proof" type="file" accept="jpeg,png,jpg" class="form-control" required>
                <div class="help-block text-danger">{{ $errors->first('payment_proof') }}</div>
              </div>
              <div class="form-group">
                <label for="">Rekening Tujuan</label>
                <select name="bank_account_id" class="form-control" required>
                  <option value="">-- Pilih Rekening Tujuan --</option>
                  @foreach($bank_accounts as $bank_account)
                  <option value="{{ $bank_account->bank_account_id }}">
                    {{ $bank_account->bank_name }}
                    &mdash;
                    {{ $bank_account->account_no }}
                  </option>
                  @endforeach
                </select>
                <div class="help-block text-danger">{{ $errors->first('bank_account_id') }}</div>
              </div>
              <hr>
              <div class="text-right">
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                <button class="btn btn-primary btn-block">KIRIM</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
