@php /** @var \App\Models\Lead $lead */
$breadcrumbs = ['breadcrumb' => 'leads.create', 'model' => $lead];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/business/leads/form.js') }}"></script>
@endpush

@section('title', __('action.Create Model', ['model' => $lead->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
			@include('business.leads._form', ['lead' => $lead, 'action' => route('leads.store')])
        </div>
    </div>
@endsection