<div id="modal-form-member-address" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="ti-map"></i>
          <span>Alamat</span>
        </h4>
      </div>
      <form action="" method="POST">
        <div class="modal-body p-3">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Label Alamat</label>
                <input class="form-control" name="name" required/>
                <small class="help-block">Contoh: rumah, kantor, dsb.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No. Telepon</label>
                <input class="form-control" name="phone" required/>
                <small class="help-block">Nomor telepon penerima di alamat terkait.</small>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="province_id" required></select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kab/Kota</label>
                <select class="form-control" name="regency_id" required></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" name="district_id" required></select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kelurahan</label>
                <select class="form-control" name="subdistrict_id" required></select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Jalan, No. Rumah</label>
            <textarea name="address" rows="2" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn btn-default" data-dismiss="modal">Batal</a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('scripts')
  @parent
  <script>
  window.MemberAddress = {
    add: function() {
      this.fillFormData({});
      $("#modal-form-member-address").find('form').attr('action-type', 'add');
      $("#modal-form-member-address").find('form').attr('action', '{{ route("front::member-address.add") }}');
      $("#modal-form-member-address").find('.modal-title span').text('Tambah Alamat');
      $("#modal-form-member-address").modal('show');
    },
    edit: function(member_address_id) {
      MemberAddress.load(member_address_id).done(function(res) {
        MemberAddress.fillFormData(res.data);
        $("#modal-form-member-address").find('form').attr('action-type', 'edit');
        $("#modal-form-member-address").find('form').attr('action', '{{ route("front::member-address.update", [":id"]) }}'.replace(':id', member_address_id));
        $("#modal-form-member-address").find('.modal-title span').text('Edit Alamat');
        $("#modal-form-member-address").modal('show');
      });
    },
    load: function(member_address_id) {
      return $.getJSON("{{ route('front::member-address.find', [':id']) }}".replace(':id', member_address_id));
    },
    fillFormData: function(data) {
      var $form = $("#modal-form-member-address").find("form");
      $form.find("input[name='name']").val(data.name || '');
      $form.find("input[name='phone']").val(data.phone || '');
      $form.find("textarea[name='address']").val(data.address || '');

      this.loadProvincesOptions(data.province_id || '');
      this.loadRegenciesOptions(data.province_id, data.regency_id);
      this.loadDistrictsOptions(data.regency_id, data.district_id);
      this.loadSubdistrictOptions(data.district_id, data.subdistrict_id);
    },
    loadProvincesOptions: function(value) {
      var $select = $("#modal-form-member-address").find("select[name='province_id']");

      return $.getJSON("{{ route('front::region.provinces') }}").done(function(res) {
        $select.html("<option value=''>-- Pilih Provinsi --</option>");
        res.data.forEach(function(province) {
          $select.append("<option value='"+province.id+"'>"+province.name+"</option>");
        });

        if (value) {
          $select.val(value);
        }
      });
    },
    loadRegenciesOptions: function(province_id, value) {
      var $select = $("#modal-form-member-address").find("select[name='regency_id']");

      if (!province_id) {
        return $select.html("<option value=''>-- Pilih Provinsi Dahulu --</option>");
      }

      return $.getJSON("{{ route('front::region.regencies') }}", {province_id: province_id}).done(function(res) {
        $select.html("<option value=''>-- Pilih Kab/Kota --</option>");
        res.data.forEach(function(regency) {
          $select.append("<option value='"+regency.id+"'>"+regency.name+"</option>");
        });

        if (value) {
          $select.val(value);
        }
      });
    },
    loadDistrictsOptions: function(regency_id, value) {
      var $select = $("#modal-form-member-address").find("select[name='district_id']");

      if (!regency_id) {
        return $select.html("<option value=''>-- Pilih Kab/Kota Dahulu --</option>");
      }

      return $.getJSON("{{ route('front::region.districts') }}", {regency_id: regency_id}).done(function(res) {
        $select.html("<option value=''>-- Pilih Kecamatan --</option>");
        res.data.forEach(function(district) {
          $select.append("<option value='"+district.id+"'>"+district.name+"</option>");
        });

        if (value) {
          $select.val(value);
        }
      });
    },
    loadSubdistrictOptions: function(district_id, value) {
      var $select = $("#modal-form-member-address").find("select[name='subdistrict_id']");

      if (!district_id) {
        return $select.html("<option value=''>-- Pilih Kecamatan Dahulu --</option>");
      }

      return $.getJSON("{{ route('front::region.subdistricts') }}", {district_id: district_id}).done(function(res) {
        $select.html("<option value=''>-- Pilih Kelurahan --</option>");
        res.data.forEach(function(subdistrict) {
          $select.append("<option value='"+subdistrict.id+"'>"+subdistrict.name+"</option>");
        });

        if (value) {
          $select.val(value);
        }
      });
    },
  }

  $(function() {
    var $modal = $("#modal-form-member-address");

    $(".btn.add-member-address").click(function(e) {
      e.preventDefault();
      MemberAddress.add();
    });

    $(document).on('click', ".btn.edit-member-address[data-id]", function(e) {
      e.preventDefault();
      MemberAddress.edit($(this).attr('data-id'));
    });

    $modal.find("select[name='province_id']").change(function() {
      MemberAddress.loadRegenciesOptions($(this).val(), '');
      MemberAddress.loadDistrictsOptions('');
      MemberAddress.loadSubdistrictOptions('');
    });

    $modal.find("select[name='regency_id']").change(function() {
      MemberAddress.loadDistrictsOptions($(this).val(), '');
      MemberAddress.loadSubdistrictOptions('');
    });

    $modal.find("select[name='district_id']").change(function() {
      MemberAddress.loadSubdistrictOptions($(this).val(), '');
    });

    $modal.find("form").submit(function(e) {
      e.preventDefault();

      var url = $(this).attr('action');
      var actionType = $(this).attr('action-type');

      $.ajax({
        type: "POST",
        url: url,
        data: $(this).serialize(),
      })
      .fail(function(xhr) {
        alert('Terjadi kesalahan saat menyimpan alamat.');
      })
      .done(function(res) {
        alert('Alamat berhasil disimpan.');
        $modal.modal('hide');

        if (actionType == 'add') {
          $modal.trigger('add.success', [res]);
        } else if(actionType == 'edit') {
          $modal.trigger('edit.success', [res]);
        }
      });
    });
  });
  </script>
@stop
