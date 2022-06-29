@extends('admin.layout.master', [
'title' => 'Dashboard',
'breadcrumb' => [
'Dashboard' => true
]
])

@section('content')
<div class="row">
  <div class="col-sm-4 col-md-4">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $membersCount }}</h3>
        <p>Members</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-md-4">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $productsCount }}</h3>
        <p>Jumlah Produk</p>
      </div>
      <div class="icon">
        <i class="fa fa-tag"></i>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-md-4">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $salesCount }}</h3>
        <p>Jumlah Pesanan Selesai</p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-cart"></i>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="m-0 card-title">Pesanan on progress</h4>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
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
              @if($onProgressOrders->count() == 0)
              <tr>
                <td colspan="8" class="text-center p-4">
                  Tidak ada pesanan dalam proses
                </td>
              </tr>
              @endif
              @foreach($onProgressOrders as $order)
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
      </div>
    </div>
  </div>
</div>
@stop