@extends('admin.layout.master', [
'title' => 'Pesanan '.$order->code,
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Pesanan' => route('admin::orders.index', ['status' => $order->status]),
$order->code => true
]
])

@section('content')
@include('admin.partials.alert-messages')
<div class="card">
  <div class="card-body">
    <h4>Info Pesanan</h4>
    <div class="row">
      <div class="col-md-9">
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
            <td class="text-left" width="200">Pembeli</td>
            <td class="text-bold">
              {{ $order->member_name }} ({{ $order->member_email }})
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
      </div>
      <div class="col-md-3">
        <h4>Ubah Status</h4>
        <form action="{{ route('admin::orders.set-status', $order->order_id) }}" method="POST">
          @csrf
          <div class="form-group">
            <select name="status" class="form-control">
              <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
              <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Proses</option>
              <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Pengiriman</option>
              <option value="finish" {{ $order->status == 'finish' ? 'selected' : '' }}>Selesai</option>
              <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
          <button class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
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
    <hr>
    <h4>Konfirmasi Pembayaran</h4>
    @if($order->payment_confirmations->count() == 0)
    <div class="alert alert-secondary p-5 text-center">
      Belum ada konfirmasi pembayaran.
    </div>
    @else
    <table class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th width="200" class="text-center">Bukti Pembayaran</th>
          <th class="text-left">Rekening Tujuan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->payment_confirmations as $payment_confirmation)
        <tr>
          <td>
            <a href="{{ $payment_confirmation->url_payment_proof }}" target="_blank">
              <img class="img-thumbnail" src="{{ $payment_confirmation->url_payment_proof }}" alt="Bukti pembayaran">
            </a>
          </td>
          <td>
            <h4 class="m-0">
              {{ $payment_confirmation->bank_account_name }}
            </h4>
            <span>
              {{ $payment_confirmation->bank_account_no }}
            </span>
            <br>
            <small>
              {{ $payment_confirmation->bank_account_owner }}
            </small>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@stop