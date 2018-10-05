@php /** @var \App\Models\Lead $lead */
$breadcrumbs = ['breadcrumb' => 'leads.edit', 'model' => $lead];
@endphp

@extends("$layout.app")

@push('scripts')
	<script src="{{ asset('js/business/leads/form.js') }}"></script>
@endpush

@section('title', __('action.Edit Model', ['model' => $lead->classLabel(true)]))

@section('content')
    <div class="m-content">
        <div class="m-portlet">
            @include('business.leads._form', ['method' => 'put', 'action' => route('leads.update', $lead)])
        </div>
    </div>
@endsection