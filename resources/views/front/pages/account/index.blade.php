@extends('front.layout.master', ['title' => 'Profil'])

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
        <h1>Profil</h1>
        <table class="table table-bordered">
          <tr>
            <td width="120">Nama</td>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <td width="120">Email</td>
            <td>{{ $user->email }}</td>
          </tr>
        </table>
        <hr>
        <h4>Produk yang Pernah Anda Beli</h4>
        @if($products->count() == 0)
        <div class="card">
          <div class="card-body p-5 text-center">
            Kamu belum pernah membeli Product.
            <br>
            <a href="{{ route('front::products.index') }}" class="btn mt-2 btn-primary btn-sm">
              Cari Product
            </a>
          </div>
        </div>
        @else
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th width="70" class="text-center">Cover</th>
              <th>Judul</th>
              <th width="120" class="text-center">Rating Anda</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $item)
            <tr>
              <td width="70">
                <img src="{{ $item->product->url_cover }}" alt="Cover" class="img-thumbnail">
              </td>
              <td><a href="{{ $item->product->url_show }}">{{ $item->product->title }}</a></td>
              <td class="text-center">
                <div class="rating-stars" data-rating="{{ auth()->user()->getRating($item->product) ?: 0 }}" data-product-id="{{ $item->product_id }}"></div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {!! $products->links() !!}
        @endif
      </div>
    </div>
  </div>
</section>
@stop

@section('styles')
  @parent
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@stop

@section('scripts')
  @parent
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
  <script>
    $('.rating-stars').each(function() {
      $(this).rateYo({
        rating: $(this).data('rating'),
        normalFill: "#aaaaaa",
        ratedFill: "#fdc632",
        starWidth: "20px",
        fullStar: true,
        onSet: function(rating) {
          var product_id = $(this).attr('data-product-id');
          $.ajax({
            method: 'POST',
            url: "{{ route('front::rating') }}",
            data: {
              product_id: product_id,
              rating: rating,
            },
            dataType: 'json'
          })
          .done(function() {
            window.location.reload();
          })
          .fail(function() {
            alert('Terjadi kesalahan saat menyimpan rating.');
          });
        }
      });
    });
  </script>
@stop
