@extends('front.layout.master', ['title' => $product->title])

@section('content')
<section id="content">
  <div class="container py-md-5 py-3">
    <article>
      <div class="row">
        <div class="col-md-3">
          <img src="{{ $product->url_cover }}" alt="{{ $product->title }}" class="img-thumbnail">
        </div>
        <div class="col-md-6">
          <h1>{{ $product->title }}</h1>
          @if($product->category)
          <div class="">
            <a href="{{ route('front::products.index', ['category' => $product->category->slug]) }}">
              <i class="ti-tag"></i>
              {{ $product->category_name }}
            </a>
          </div>
          <div class="description mt-3">
            {!! nl2br($product->description) !!}
          </div>
          @endif
        </div>
        <div class="col-md-3">
          <h4 class="text-muted">Harga</h4>
          <h3>{{ $product->price_label }}</h3>
          <hr>
          <button class="btn add-to-cart btn-primary btn-block" data-id="{{ $product->product_id }}">
            <i class="ti-shopping-cart"></i> Masukkan ke Keranjang
          </button>
        </div>
      </div>
    </article>
    <hr class="my-5">
    <h2>Produk Lainnya</h2>
    <div class="row mt-4">
      @foreach($other_products as $other_product)
      <div class="col-md-2">
        @include('front.partials.card-book', ['product' => $other_product, 'button_cart' => false])
      </div>
      @endforeach
    </div>
  </div>
</section>
@stop
