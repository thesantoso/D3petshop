<div id="modal-cart" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="ti-shopping-cart"></i> Keranjang Belanja
        </h4>
      </div>
      <div class="modal-body p-0">
        <div class="cart-items">
          <table class="table-cart-items table table-striped table-hover table-bordered m-0">
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="{{ route('front::checkout.form') }}" class="btn btn-primary">Checkout</a>
      </div>
    </div>
  </div>
</div>

@section('scripts')
  @parent
  <script>
  function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  window.Cart = {
    add: function (product_id, show = true) {
      return $.ajax({
        type: 'POST',
        url: '{{ route("front::cart.add") }}',
        data: {
          product_id: product_id
        }
      })
      .fail(function (xhr) {
        alert('Terjadi kesalahan saat menambah item ke keranjang');
      })
      .done(function(res) {
        if (show) {
          Cart.show();
        }
      })
    },
    set: function (product_id, qty) {
      return $.ajax({
        type: 'POST',
        url: '{{ route("front::cart.update") }}',
        data: {
          product_id: product_id,
          qty: qty
        }
      })
      .fail(function (xhr) {
        alert('Terjadi kesalahan saat mengubah qty');
      })
    },
    remove: function (product_id) {
      return $.ajax({
        type: 'POST',
        url: '{{ route("front::cart.delete") }}',
        data: {
          product_id: product_id,
        }
      })
      .fail(function (xhr) {
        alert('Terjadi kesalahan saat menghapus item');
      })
    },
    load: function() {
      return $.getJSON("{{ route('front::cart.items') }}")
      .fail(function() {
        alert('Terjadi kesalahan saat mengambil data keranjang belanja');
      })
    },
    show: function () {
      this.load().done(function(res) {
        var items = res.items;

        $("#modal-cart").find(".table-cart-items tbody").html("");
        items.forEach(function(item, i) {
          $tr = $("<tr data-id='"+item.product.product_id+"' data-price='"+item.product.price+"'></tr>");
          $tr.append("<td width='30'><button class='btn btn-sm btn-danger delete-cart-item'><i class='ti-close'></i></button></td>");
          $tr.append("<td width='50'><img src='"+item.product.url_cover+"' style='height:60px'/></td>");
          $tr.append("<td><a href='"+item.product.url_show+"'>"+item.product.title+"</a></td>");
          $tr.append("<td>"+formatNumber(item.product.price)+"</td>");
          $tr.append("<td width='100'><input type='number' class='form-control cart-item-qty' value='"+item.qty+"' max='"+item.product.stock+"'/></td>");
          $tr.append("<td class='subtotal'>"+formatNumber(item.product.price * item.qty)+"</td>");

          $("#modal-cart").find(".table-cart-items tbody").append($tr);
        });

        $("#modal-cart").modal('show');
      })
    },
    hide: function() {
      $("#modal-cart").modal('hide');
    }
  }

  $(function() {
    $('.toggle-cart').click(function() {
      Cart.show();
    });

    $('.btn.add-to-cart[data-id]').click(function() {
      var product_id = $(this).attr('data-id');
      Cart.add(product_id);
    });

    $(document).on('change', 'input.cart-item-qty', function() {
      var product_id = $(this).closest('tr').attr('data-id');
      var qty = $(this).val();

      Cart.set(product_id, qty);
    });

    $(document).on('keyup', 'input.cart-item-qty', function() {
      var price = parseInt($(this).closest('tr').attr('data-price'));
      var qty = parseInt($(this).val());
      var subtotal = (price * qty);

      if (qty == 0) {
        if (confirm('Apa kamu yakin ingin menghapus item ini dari keranjang?')) {
          $(this).closest('tr').remove();
        } else {
          $(this).val(1).trigger('change');
        }
      } else {
        $(this).closest('tr').find('.subtotal').text(formatNumber(subtotal));
      }
    });

    $(document).on('click', 'button.delete-cart-item', function() {
      if (confirm('Apa kamu yakin ingin menghapus item ini dari keranjang?')) {
        var product_id = $(this).closest('tr').attr('data-id');
        Cart.remove(product_id).done(function() {
          $("#modal-cart").find("tr[data-id='"+product_id+"']").remove();
        });
      }
    });
  });
  </script>
@stop
