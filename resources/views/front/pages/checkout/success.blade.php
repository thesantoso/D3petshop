@extends('front.layout.master', ['title' => 'Pesanan Diterima'])

@section('content')
<section id="content">
  <div class="container py-md-6 py-3">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center mt-3">Pesanan Diterima</h1>
        <h3 class="text-danger p-3 my-3 text-center">HARAP CATAT INFORMASI BERIKUT</h3>
        <div class="card">
          <div class="card-body">
            <div class="mb-3 text-center">
              <h5 class="m-0 text-muted">Kode Transaksi</h5>
              <h3 class="m-0">{{ $order->code }}</h3>
            </div>
            <div class="mb-3 text-center">
              <h5 class="m-0 text-muted">Jumlah yang Harus Dibayar</h5>
              <h3 class="m-0">{{ number_format($order->total_amount, 0, ',', '.') }}</h3>
            </div>
            <hr>
            <div class="mb-3">
              <p>Harap lakukan pembayaran ke salah satu rekening dibawah ini:</p>
              <div class="list-group">
                @foreach($bank_accounts as $bank_account)
                <div class="list-group-item flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $bank_account->bank_name }}</h5>
                  </div>
                  <p class="mb-1">{{ $bank_account->account_no }}</p>
                  <small>Atas Nama: {{ $bank_account->account_owner }}</small>
                </div>
                @endforeach
              </div>
            </div>
            <div>
              <p>Jika sudah, harap melakukan konfirmasi pembayaran pada tautan dibawah ini:</p>
              <div class="alert text-center">
                <a href="{{ route('front::payment-confirmation.form') }}"><button type="button" class="btn btn-dark">Klik Disini</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop