@extends('front.layout.master', ['title' => 'List Products'])

@section('content')
<section id="content">
  <div class="container py-md-5 py-3">
    <div class="row">
      <div class="col-md-3">
        <form action="{{ route('front::products.index') }}">
          <h4>Pencarian</h4>
          <div class="form-group mb-3">
            <div class="input-group">
              @if(request('keyword'))
              <div class="input-group-prepend">
                <a href="{{ route('front::products.index', ['category' => request('category')]) }}" class="btn btn-danger text-white"><i class="ti-close"></i></a>
              </div>
              @endif
              <input type="text" class="form-control" name="keyword" placeholder="Kata kunci" value="{{ request("keyword") }}">
              <div class="input-group-append">
                <button class="btn btn-primary"><i class="ti-search"></i></button>
              </div>
            </div>
          </div>
          @if(request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
        </form>
        <h4>Kategori</h4>
        @if(request('category'))
        <a href="{{ route('front::products.index', ['keyword' => request("keyword")]) }}" class="btn btn-primary btn-block mb-3 text-white">Semua Kategori</a>
        @endif
        <div class="list-group secondary categories">
          @foreach($categories as $i => $category)
          <a
            href="{{ route('front::products.index', ['category' => $category->slug, 'keyword' => request('keyword')]) }}"
            class="
              list-group-item
              list-group-item-action
              {{ ($i >= 10 && request('category') != $category->slug) ? 'hidden d-none' : '' }}
              {{ request('category') == $category->slug ? 'active' : '' }}">
            {{ $category->name }}
          </a>
          @endforeach
        </div>
        @if($categories->count() > 10)
        <div class="py-3 text-center">
          <a href="#" class="text-secondary toggle-categories">
            Tampilkan semua kategori
          </a>
        </div>
        @endif
        @if($recommendation)
        <h4>Produk Rekomendasi</h4>
        <a href="{{ $recommendation->product->url_show }}">
          <img src="{{ $recommendation->product->url_cover }}" alt="{{ $recommendation->product->title }}" class="img-thumbnail"/>
        </a>
        @endif
      </div>
      <div class="col-md-9">
        <div class="books">
          @foreach($products->chunk(4) as $chunk)
            <div class="row">
              @foreach($chunk as $product)
              <div class="col-md-3 col-6 mb-md-5 mb-3">
                @include('front.partials.card-book', ['product' => $product])
              </div>
              @endforeach
            </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center pb-5">
          {!! $products->appends($_GET)->links() !!}
        </div>
      </div>
      </div>
    </div>
</section>
@stop

@section('scripts')
  @parent
  <script>
    $(function() {
      $('.toggle-categories').click(function() {
        var showAll = $('.list-group.categories').hasClass("show-all");
        if (showAll) {
          $('.list-group.categories').find('.hidden').addClass('d-none');
          $(this).text('Tampilkan semua kategori');
        } else {
          $('.list-group.categories').find('.hidden').removeClass('d-none');
          $(this).text('Tampilkan sedikit kategori');
        }
        $('.list-group.categories').toggleClass('show-all');
      });
    });
  </script>
@stop
