@extends('front.layout.master', ['title' => 'Konfirmasi Pembayaran Diterima'])

@section('content')
<section id="content">
  <div class="container py-md-5 py-3">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h3 class="text-center mt-3">Konfirmasi Pembayaran Diterima</h3>
        <div class="card">
          <div class="card-body text-center p-5">
            <p class="m-0">
              Terima kasih, konfirmasi pembayaran anda telah kami terima.
              Kami akan segera mengeceknya dan secepat mungkin memproses pesanan anda.
            </p>
            <br>
            <a href="{{ route('front::home') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
