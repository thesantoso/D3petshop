@extends('front.layout.master', ['title' => 'Detail Pembelian: ' . $order->code])

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
        <h1>Detail Pembelian</h1>
        <table class="table table-bordered table-striped table-hover m-0">
          <tr>
            <td class="text-left" width="200">Tanggal</td>
            <td class="text-bold">
              {{ $order->created_at->format('d M Y, H:i') }}
            </td>
          </tr>
          <tr>
            <td class="text-left" width="200">Kode Transaksi</td>
            <td class="text-bold">
              {{ $order->code }}
            </td>
          </tr>
          <tr>
            <td class="text-left" width="200">Pengiriman</td>
            <td class="text-bold">
              {{ $order->province_name }} / {{ $order->regency_name }} / {{ $order->district_name }} / {{ $order->subdistrict_name }}
              <br>
              <span>{{ $order->address }}</span>
            </td>
          </tr>
          <tr>
            <td class="text-left" width="200">Telepon Penerima</td>
            <td class="text-bold">
              {{ $order->phone }}
            </td>
          </tr>
          <tr>
            <td class="text-left" width="200">Status</td>
            <td class="text-bold">
              {{ $order->status }}
            </td>
          </tr>
        </table>

        <hr>
        <h4>Rincian Pembayaran</h4>
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th width="70" class="text-center">Cover</th>
              <th class="text-left">Produk</th>
              <th width="150" class="text-right">Harga</th>
              <th width="100" class="text-center">Qty</th>
              <th width="200" class="text-right">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->details as $detail)
            <tr>
              <td width="70" class="text-center">
                <img src="{{ $detail->product->url_cover }}" alt="Cover" class="img-thumbnail">
              </td>
              <td class="text-left">
                {{ $detail->product->title }}
              </td>
              <td width="150" class="text-right">
                {{ $detail->price_label }}
              </td>
              <td width="100" class="text-center">
                {{ $detail->qty }}
              </td>
              <td width="200" class="text-right">
                {{ $detail->subtotal_label}}
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">Ongkos Kirim</td>
              <td class="text-right">
                {{ $order->shipping_cost_label }}
              </td>
            </tr>
            <tr>
              <td colspan="4" class="text-bold">TOTAL</td>
              <td class="text-right text-bold">
                {{ $order->total_amount_label }}
              </td>
            </tr>
          </tfoot>
        </table>
        @if($order->status == 'pending')
        <a href="{{ route('front::payment-confirmation.form', ['code' => $order->code]) }}" class="btn btn-primary">
          Konfirmasi Pembayaran
        </a>
        @endif
      </div>
    </div>
  </div>
</section>
@stop
