<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.4/jquery.rateyo.min.css">

    <title>DEV AREA</title>
  </head>
  <body style="background-color: #efefef;">
    <div class="container-fluid py-3">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title m-0 text-bold">Ratings</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <button class="btn btn-primary" id="random-btn">Set Random Ratings</button>
                <button class="btn btn-danger" id="reset-btn">Reset Ratings</button>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-condensed m-0">
                  <thead>
                    <tr>
                      <th></th>
                      @foreach($members as $member)
                      <th class="text-center">
                        <small>{{ $member->name }}</small>
                        <br>
                        <small>{{ $member->member_profile->age }} tahun</small>
                      </th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                    <tr>
                      <td width="100" class="text-center">
                        <img style="width:50px;" title="{{ $product->title }}" src="{{ $product->url_cover }}" alt="cover" class="img-thumbnail">
                        <br>
                        <small>{{ $product->title }}</small>
                      </td>
                      @foreach($members as $member)
                      <td class="text-center">
                        <div class="d-flex justify-content-center">
                          <div class="rating"
                            data-rating="{{ $member->getRating($product) }}"
                            data-user-id="{{ $member->user_id }}"
                            data-product-id="{{ $product->product_id }}">
                          </div>
                        </div>
                      </td>
                      @endforeach
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header">
              <h4 class="card-title m-0">Pearson Correlation</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      @foreach($products as $product)
                        <th width="160" class="text-center">{{ $product->title }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                      <tr>
                        <td class="text-center">{{ $product->title }}</td>
                        @foreach($products as $other)
                          @php($correlation = $product->getPearsonCorrelation($other))
                          <td class="text-center {{ $product->product_id == $other->product_id ? 'table-secondary' : '' }}">
                            <a href="{{ url("dev/pearson-correlation?product_id_1={$product->product_id}&product_id_2={$other->product_id}") }}"
                               class="{{ $correlation > 0 ? 'text-success font-bold' : 'text-danger' }}">
                              {{ number_format($correlation, 5) }}
                            </a>
                          </td>
                        @endforeach
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header">
              <h4 class="card-title m-0">Prediksi</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th class="text-center" width="50">No.</th>
                      <th>User</th>
                      <th>Buku</th>
                      <th class="text-center" width="150">Prediksi</th>
                      <th class="text-center" width="50">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($predictions as $i => $prediction)
                      <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $prediction->user->name }}</td>
                        <td>{{ $prediction->book->title }}</td>
                        <td class="text-center">{{ $prediction->rating }}</td>
                        <td class="text-center">
                          <a href="{{ url("dev/prediction?user_id={$prediction->user_id}&product_id={$prediction->product_id}") }}" class="btn btn-info btn-sm">
                            <i class="fa fa-search"></i>
                          </a>
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
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.4/jquery.rateyo.min.js"></script>
    <script>
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var user_ids = {!! $members->pluck('user_id')->toJson() !!};
      var product_ids = {!! $products->pluck('product_id')->toJson() !!};
      var prevent_submit = false;

      function postRatings(ratings) {
        return $.ajax({
          type: 'POST',
          url: "{{ url('dev/ratings') }}",
          data: {ratings: ratings},
          dataType: 'json'
        });
      }

      function resetRatings(ratings) {
        return $.ajax({
          type: 'POST',
          url: "{{ url('dev/ratings/reset') }}",
          dataType: 'json'
        });
      }

      $(function() {
        $("#random-btn").click(function() {
          var ratings = [];
          user_ids.forEach(function(user_id) {
            product_ids.forEach(function(product_id) {
              ratings.push({user_id, product_id, rating: Math.ceil(Math.random() * 4)});
            });
          });

          postRatings(ratings).done(function() {
            window.location.reload();
          });
        });

        $("#reset-btn").click(function() {
          resetRatings().done(function() {
            window.location.reload();
          });
        });

        $('.rating').each(function() {
          $(this).rateYo({
            rating: $(this).data('rating'),
            fullStar: true,
            starWidth: '20px',
            normalFill: '#ccc',
            onSet: function(rating) {
              if (prevent_submit) {
                return
              }

              var user_id = $(this).attr('data-user-id');
              var product_id = $(this).attr('data-product-id');
              postRatings([{user_id, product_id, rating}])
              .done(function() {
                console.log('rating updated')
              })
              .fail(function() {
                alert('Terjadi kesalahan');
              });
            }
          });
        });
      });
    </script>
  </body>
</html>
