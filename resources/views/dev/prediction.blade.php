<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.4/jquery.rateyo.min.css">

    <title>PREDICTION</title>
  </head>
  <body style="background-color: #efefef;">
    <div class="container py-5">
      <h1 class="text-center">PREDICTION</h1>
      <form action="">

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">User</span>
                </div>
                <select name="user_id" class="form-control">
                  @foreach($users as $user)
                    <option {{ request('user_id') == $user->getKey() ? 'selected' : '' }} value="{{ $user->getKey() }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Buku</span>
                </div>
                <select name="book_id" class="form-control">
                  @foreach($books as $book)
                    <option {{ request('book_id') == $book->getKey() ? 'selected' : '' }} value="{{ $book->getKey() }}">{{ $book->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-primary btn-block">EXPLAIN</button>
      </form>
      @if(isset($explainer))
      <hr>
      <div>
        <h1 class="text-center">STEPS</h1>
        @foreach($explainer->getExplanations() as $i => $explanation)
        <div class="card mb-3">
          <div class="card-header">
            <h5 class="card-title m-0">{{ $i + 1 }}. {{ $explanation['title'] }}</h5>
          </div>
          <div class="card-body">
            {!! $explanation['detail'] !!}
          </div>
        </div>
        @endforeach
      </div>
      @endif
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

    </script>
  </body>
</html>
