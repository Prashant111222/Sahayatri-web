@extends('layouts.app', ['activePage' => 'map', 'titlePage' => __('Map')])

@section('content')
<div id="map"></div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    demo.initGoogleMaps();
  });
</script>
@endpush