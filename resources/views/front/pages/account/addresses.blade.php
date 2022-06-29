@extends('front.layout.master', ['title' => 'Kelola Alamat'])

@php
$user = auth()->user();
@endphp

@section('content')
<section id="content">
  <div class="container py-md-5 py-3">
    <div class="row">
      <div class="col-md-3">
        @include('front.partials.menu-member')
      </div>
      <div class="col-md-9">
        <h1>Kelola Alamat</h1>
        <table class="table table-bordered table-striped table-hover m-0">
          <thead>
            <tr>
              <th width="100" class="text-left">Label</th>
              <th class="text-left">Alamat</th>
              <th width="200" class="text-left">No. Telepon</th>
              <th colspan="2" width="200" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($addresses as $address)
            <tr>
              <td class="text-left">
                {{ $address->name }}
                @if($address->is_default == 1)
                <small class="text-info text-bold">(default)</small>
                @endif
              </td>
              <td class="text-left">
                {{ $address->province_name }} / {{ $address->regency_name }} / {{ $address->district_name }} / {{ $address->subdistrict_name }}
                <br>
                <span>{{ $address->address }}</span>
              </td>
              <td class="text-left">{{ $address->phone }}</td>
              <td width="130">
                <button class="btn btn-primary btn-edit edit-member-address btn-sm text-white" data-id="{{ $address->member_address_id }}">
                  Edit
                </button>
                <form class="d-inline" action="{{ route('front::member-address.delete', $address->member_address_id) }}" method="POST">
                  @csrf
                  <button onclick="return confirm('Hapus alamat ini?')" class="btn btn-danger btn-edit btn-sm text-white">
                    Hapus
                  </button>
                </form>
              </td>
              <td width="50">
                @if($address->is_default == 0)
                <form action="{{ route('front::member-address.set-default', $address->member_address_id) }}" method="POST">
                  @csrf
                  <button onclick="return confirm('Jadikan alamat ini sebagai default?')" class="btn btn-sm btn-secondary">
                    Set default
                  </button>
                </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>
        <button class="btn btn-primary add-member-address">Tambah Alamat</button>
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
  @parent
  <script>
    $("#modal-form-member-address").on('edit.success add.success', function() {
      window.location.reload();
    });
  </script>
@stop
