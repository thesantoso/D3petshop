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
          <div class="formaction">
            <h4 class="text-muted">Harga</h4>
            <h3>{{ $product->price_label }}</h3>
            <hr>
              {{-- <button class="btn add-to-cart btn-primary btn-block" data-id="{{   $product->product_id }}">
                <i class="ti-shopping-cart"></i> Keranjang
              </button>
              <button class="btn whislist btn-whislist btn-block" data-id="{{ $product->product_id }}">
                <i class="fa fa-heart"></i> Whislist
              </button> --}}
<div class="css-qiunk2">
    <div class="css-c1hnei">
        <button data-unify="Button" type="button" class="btn add-to-cart" id="cart" data-id="{{   $product->product_id }}">
            <span cursorshover="true">+ Keranjang</span>
        </button>
            <button data-unify="Button" type="button" class="css-w1lafs-unf-btn eg8apji0" data-testid="pdpBtnNormalSecondary" cursorshover="true">
              <a href="{{ route('front::checkout.form') }}">
                <span cursorshover="true">Beli Langsung</span>
              </a>
          </button>
    </div>
    <div id="pdpBuyerSubActions">
        <div class="css-cbvz5p">
            <button type="button" data-testid="btnPDPFooterChat" class="css-1ptm0es">
                <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/0e8c0fc1.svg" alt="">Chat
            </button>
            <button type="button" data-testid="btnPDPFooterWishlist" class="css-1ptm0es">
                <img data-testid="viewUnwishlisted" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/88abeb07.svg" alt="">Wishlist
            </button>
            <button type="button" aria-label="Share" data-testid="pdpShareButton" class="css-1aleyzt" cursorshover="true">
              <a href="https://api.whatsapp.com/send?text={{urlencode(url()->current()) }}">
                <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/d9a5893b.svg" alt="">
                    <span cursorshover="true">Share</span>
              </a>
            </button>
        </div>
    </div>
</div>
          </div>
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
