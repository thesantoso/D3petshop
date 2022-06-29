<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta-tags')

    <link rel="icon" href="{{ asset('edustage') }}/img/favicon.png" type="image/png" />
    <title>{{ isset($title) ? $title : config('app.name') }}</title>

    @section('styles')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('edustage') }}/css/bootstrap.css" />
    <link rel="stylesheet" href="{{ asset('edustage') }}/css/flaticon.css" />
    <link rel="stylesheet" href="{{ asset('edustage') }}/css/themify-icons.css" />
    <link rel="stylesheet" href="{{ asset('edustage') }}/vendors/owl-carousel/owl.carousel.min.css" />
    {{-- <link rel="stylesheet" href="{{ asset('edustage') }}/vendors/nice-select/css/nice-select.css" /> --}}
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('edustage') }}/css/style.css" />
    <link rel="stylesheet" href="{{ asset('front/custom.css') }}" />
    @show
  </head>

  <body>
    @include('front.layout.header')

    @yield('content')

    @include('front.layout.footer')
    @include('front.layout.modal-cart')
    @if(auth()->user())
      @include('front.layout.modal-form-member-address')
    @endif

    @section('scripts')
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('edustage') }}/js/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('edustage') }}/js/popper.js"></script>
    <script src="{{ asset('edustage') }}/js/bootstrap.min.js"></script>
    {{-- <script src="{{ asset('edustage') }}/vendors/nice-select/js/jquery.nice-select.min.js"></script> --}}
    <script src="{{ asset('edustage') }}/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ asset('edustage') }}/js/owl-carousel-thumb.min.js"></script>
    <script src="{{ asset('edustage') }}/js/jquery.ajaxchimp.min.js"></script>
    <script src="{{ asset('edustage') }}/js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="{{ asset('edustage') }}/js/gmaps.min.js"></script>
    <script>
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>
    <script src="{{ asset('edustage') }}/js/theme.js"></script>
    @show
  </body>
</html>
