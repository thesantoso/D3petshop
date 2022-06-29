<div class="card_book single_course">
  <div class="course_head d-flex flex-wrap justify-content-center align-content-center">
    <a href="{{ $product->url_show }}" class="d-block">
      <img class="img-fluid" src="{{ $product->url_cover }}" alt="{{ $product->title }}" />
    </a>
    @if($product->category_name)
    <div class="product_category">{{ $product->category_name }}</div>
    @endif
  </div>
  <div class="course_content p-3">
    <h4 class="product_title">
      <a title="{{ $product->title }}" href="{{ $product->url_show }}">{{ $product->title }}</a>
    </h4>
    <div class="row">
      <div class="col-12 py-2">
        <span>{{ $product->price_label }}</span>
      </div>
      @if(!isset($button_cart) || $button_cart == true)
      <div class="col-12">
        <button title="Add to cart" class="btn btn-primary btn-block add-to-cart" data-id="{{ $product->product_id }}">
          <i class="ti-shopping-cart"></i>
          Masukkan
        </button>
      </div>
      @endif
    </div>
  </div>
</div>
