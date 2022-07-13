@extends('front.layout.master', ['title' => 'Checkout'])

@section('content')
<section id="content" class="">
  <div class="container py-3">
    @if(count($items) > 0)
    <form action="{{ route('front::checkout.submit') }}" method="POST">
      {!! csrf_field() !!}
      <div class="row justify-content-center">
        <div class="col-md-12">
          <h2 class="mb-3">Checkout</h2>
          @include('front.partials.alert-messages')
          <div class="card">
            <div class="card-body">
              {{-- ALAMAT PENGIRIMAN --}}
              <h4>Alamat Pengiriman</h4>
              @if($addresses->count() == 0)
              <div class="alert alert-secondary text-center p-4">
                Tambah alamat dulu yukk!
                <br>
                <br>
                <button class="btn add-member-address btn-primary">
                  Tambah Alamat
                </button>
              </div>
              @else
              <div class="form-group mt-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Pilih Alamat</span>
                  </div>
                  <select name="member_address_id" class="form-control">
                    @foreach($addresses as $address)
                    <option value="{{ $address->member_address_id }}" {{ $address->is_default == 1 ? 'selected' : '' }}>{{ $address->name }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-primary add-member-address">Tambah Alamat Lain</button>
                  </div>
                </div>
              </div>
              <table class="table mt-3 table-bordered table-hover">
                <tbody>
                  <tr>
                    <td width="200">No. Telepon</td>
                    <td width="20" class="text-center">:</td>
                    <td class="phone"></td>
                  </tr>
                  <tr>
                    <td width="200">Provinsi</td>
                    <td width="20" class="text-center">:</td>
                    <td class="province"></td>
                  </tr>
                  <tr>
                    <td width="200">Kab/Kota</td>
                    <td width="20" class="text-center">:</td>
                    <td class="regency"></td>
                  </tr>
                  <tr>
                    <td width="200">Kecamatan</td>
                    <td width="20" class="text-center">:</td>
                    <td class="district"></td>
                  </tr>
                  <tr>
                    <td width="200">Kelurahan</td>
                    <td width="20" class="text-center">:</td>
                    <td class="subdistrict"></td>
                  </tr>
                  <tr>
                    <td width="200">Jalan, No. Rumah</td>
                    <td width="20" class="text-center">:</td>
                    <td class="address"></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><button class="btn btn-sm btn-secondary edit-member-address" data-id="">Edit Alamat</button></td>
                  </tr>
                </tfoot>
              </table>
              @endif

              <hr>

              {{-- KERANJANG BELANJA --}}
              <h4 class="mt-4">Rincian Pembayaran</h4>
              <table class="table table-striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">Cover</th>
                    <th>Judul</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @php($total = 0)
                  @foreach($items as $item)
                  <tr>
                    <td width="75"><img class="img-thumbnail" src="{{ $item['product']->url_cover }}"/></td>
                    <td><a href="{{ $item['product']->url_show }}">{{ $item['product']->title }}</a></td>
                    <td width="200" class="text-right">{{ $item['product']->price_label }}</td>
                    <td width="100" class="text-center">{{ $item['qty'] }}</td>
                    <td width="200" class="text-right">Rp {{ number_format($item['product']->price * $item['qty'], 0, ',', '.') }}</td>
                  </tr>
                  @php($total += $item['product']->price * $item['qty'])
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"><h4 class="m-0">ONGKOS KIRIM | JNE Reguler</h4></td>
                    <td class="text-right"><h4 class="m-0 shipping-cost"></h4></td>
                  </tr>
                  <tr>
                    <td colspan="4"><h4 class="m-0">TOTAL</h4></td>
                    <td class="text-right"><h4 class="m-0 total"></h4></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="text-right mt-3">
        <button onclick="return confirm('Apa kamu yakin ingin meneruskan pemesanan ini?')" class="btn btn-primary btn-lg">CHECKOUT PESANAN</button>
      </div>
    </form>
    @else
    <div class="alert alert-secondary text-center py-md-5 py-3 my-md-5 my-3">
      <i class="ti-shopping-cart"></i>
      <br>
      <p>
        Opps! Keranjang belanja anda masih kosong.
      </p>
      <a href="{{ route('front::products.index') }}" class="btn btn-primary">Lanjut Belanja</a>
    </div>
    @endif
  </div>
</section>
@stop

@if(count($items) > 0)
@section('scripts')
  @parent
  <script>
    var total_items = {{ $total }};
    var shipping_cost = 0;

    function loadAddress() {
      var value = $("select[name='member_address_id']").val();
      if (value) {
        MemberAddress.load(value).done(function(res) {
          fillAddress(res.data);
          updateShippingCost(res.data.regency_id);
        });
      } else {
        updateShippingCost('');
      }
    }

    function fillAddress(data) {
      $(".phone").text(data.phone);
      $(".province").text(data.province ? data.province.name : '');
      $(".regency").text(data.regency ? data.regency.name : '');
      $(".district").text(data.district ? data.district.name : '');
      $(".subdistrict").text(data.subdistrict ? data.subdistrict.name : '');
      $(".address").text(data.address);
      $("[data-id]").attr('data-id', data.member_address_id);
    }

    function updateShippingCost(regency_id) {
      if (!regency_id) {
        $(".shipping-cost").text('');
        updateTotal();
      } else {
        $.getJSON("{{ route('front::shipping-cost.cost', [null]) }}/" + regency_id).done(function(res) {
          shipping_cost = res.cost;
          $(".shipping-cost").text(formatNumber(shipping_cost));
          $(".shipping-cost").show();
          updateTotal();
        });
      }
    }

    function updateTotal() {
      $(".total").text(formatNumber(total_items + shipping_cost));
    }

    $(function() {
      loadAddress();
      $("select[name='member_address_id']").change(loadAddress);

      $("#modal-form-member-address").on('add.success', function(e, res) {
        $select = $("select[name='member_address_id']");
        if (!$select.length) {
          return location.reload();
        }

        $select.append("<option value='"+res.data.member_address_id+"'>"+res.data.name+"</option>");
        $select.val(res.data.member_address_id).trigger('change');
      });

      $("#modal-form-member-address").on('edit.success', function(e, res) {
        loadAddress();
      });
    })
  </script>
@stop
@endif
