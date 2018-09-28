@extends("$layout.app")@section('title', __('Home'))

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush

@section('content')
    <div class="m-content my-3">
        <div class="row" id="highcharts_month" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <hr/>
        <div class="row" id="highcharts_year" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
@endsection