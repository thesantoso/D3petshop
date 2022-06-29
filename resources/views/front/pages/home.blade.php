@extends('front.layout.master')

@section('content')
  @include('front.layout.home-banner')

  {{-- <div class="pt-5">
    @include('front.layout.popular-products', ['products' => $popular_products])
  </div> --}}

  <hr>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="main_title">
          <h2 class="mb-3">Produk Terbaru</h2>
        </div>
      </div>
      @foreach($newest_products->chunk(4) as $chunk)
        <div class="row">
          @foreach($chunk as $product)
          <div class="col-md-3 mb-4">
            @include('front.partials.card-book', ['product' => $product])
          </div>
          @endforeach
        </div>
      @endforeach
      <div class="mt-5 text-center">
        <a href="{{ route('front::products.index') }}" class="btn btn-primary">
          Lihat Selengkapnya
        </a>
      </div>
    </div>
  </div>
@stop
