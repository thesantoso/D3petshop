@foreach(['info', 'success', 'warning', 'danger'] as $type)
  @if(session($type))
  <div class="alert alert-{{ $type }}">
    <b class="close" data-dismiss="alert">&times;</b>
    {!! session($type) !!}
  </div>
  @endif
@endforeach
