@extends('front.layout.master', ['title' => 'Pembelian'])

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
        <h1>Pembelian</h1>
        <table class="table table-bordered table-striped table-hover m-0">
          <thead>
            <tr>
              <th width="100" class="text-center">Tanggal</th>
              <th width="100" class="text-center">Kode</th>
              <th class="text-right">Total Pembayaran</th>
              <th width="50" class="text-center">Status</th>
              <th colspan="2" width="50" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td class="text-center" >
                <a>
                  {{ $order->created_at->format('d/M/Y') }}
                </a>
              </td>
              <td class="text-center">{{ $order->code }}</td>
              <td class="text-right">{{ $order->total_amount_label }}</td>
              <td class="text-center">{{ $order->status }}</td>
              <td width="50" class="text-center">
                <a href="{{ route('front::account.order-detail', $order->order_id) }}" class="btn btn-info btn-edit text-body">
                  <i class="fa fa-search"></i> Detail Pembelian
                </a>
              </td>
              <td width="50" class="text-center">
                @if($order->status == 'pending')
                <a href="{{ route('front::payment-confirmation.form', ['code' => $order->code]) }}" class="btn btn-info btn-edit text-body">
                  Konfirmasi Pembayaran
                </a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {!! $orders->links() !!}
      </div>
    </div>
  </div>
</section>
@stop
