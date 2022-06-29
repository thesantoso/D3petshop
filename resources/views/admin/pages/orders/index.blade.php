@extends('admin.layout.master', [
'title' => 'Daftar Pesanan' . ($status ? " : ".ucwords($status) : ""),
'breadcrumb' => [
'Dashboard' => route('admin::dashboard.index'),
'Daftar Pesanan' => true
]
])

@section('content')
@include('admin.partials.alert-messages')
<div class="card">
  @if($orders->count() === 0)
  <div class="card-body p-5 text-center text-muted">
    <h4 class="m-0">Data Kosong</h4>
  </div>
  @else
  <div class="card-body p-0">
    <table class="table table-bordered table-striped table-hover m-0">
      <thead>
        <tr>
          <th width="120" class="text-center">Tanggal</th>
          <th width="100" class="text-center">Kode</th>
          <th class="text-left">Pembeli</th>
          <th class="text-left">Pengiriman</th>
          <th width="120" class="text-right">Ongkos Kirim</th>
          <th width="120" class="text-right">Subtotal</th>
          <th width="120" class="text-right">Total Harga</th>
          <th width="200" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        <tr>
          <td class="text-center">
            {{ $order->created_at->format('d M Y') }}
            <br>
            <small class="text-muted">
              {{ $order->created_at->format('H:i') }}
            </small>
          </td>
          <td class="text-center">{{ $order->code }}</td>
          <td>
            {{ $order->member_name }}
            <br>
            <small class="text-muted">{{ $order->member_email }}</small>
          </td>
          <td class="text-left">
            {{ $order->regency_name }} / {{ $order->district_name }} / {{ $order->subdistrict_name }}
            <br>
            <small class="text-muted">
              Telp: {{ $order->phone }}
            </small>
          </td>
          <td class="text-right">{{ $order->shipping_cost_label }}</td>
          <td class="text-right">{{ $order->details_amount_label }}</td>
          <td class="text-right">{{ $order->total_amount_label }}</td>
          <td class="text-center">
            <a href="{{ route('admin::orders.show', $order->order_id) }}" class="btn btn-info btn-edit btn-sm"><i class="fa fa-search"></i> Detail</a>
            <form action="{{ route('admin::orders.delete', $order->order_id) }}" class="d-inline" method="post">
              @csrf
              <button class="btn btn-danger btn-sm" onclick="return confirm('Apa kamu yakin ingin menghapus pesanan ini?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {!! $orders->appends($_GET)->links() !!}
  </div>
</div>
@endif
@stop