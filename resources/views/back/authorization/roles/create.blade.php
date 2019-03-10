@extends('chief::back._layouts.master')

@section('page-title', trans('chief::roles.create'))

@chiefheader
@slot('title', 'Nieuwe rol toevoegen')
	<div class="center-y right inline-group">
		<button data-submit-form="createForm" type="button" class="btn btn-o-primary">@lang('chief:roles.add_role')</button>
	</div>
@endchiefheader

@section('content')

	<form id="createForm" action="{{ route('chief.back.roles.store') }}" method="POST">
		{!! csrf_field() !!}

		@include('chief::back.authorization.roles._form')

		<button type="submit" class="btn btn-primary right">@lang('chief:roles.add_role')</button>
	</form>

@endsection
