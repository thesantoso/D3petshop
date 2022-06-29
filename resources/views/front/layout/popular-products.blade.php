<!--================ Start Popular Courses Area =================-->
<div class="popular_courses">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="main_title">
          <h2 class="mb-3">Produk Populer</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- single course -->
      <div class="col-lg-12">
        <div class="owl-carousel active_course">
          @foreach($products as $product)
          @include('front.partials.card-book', ['product' => $product])
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!--================ End Popular Courses Area =================-->