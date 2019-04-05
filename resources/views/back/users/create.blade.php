@extends('chief::back._layouts.master')

@section('page-title', trans('chief::users.invite_title'))

@chiefheader
	@slot('title', trans('chief::users.new_invite'))
	<button data-submit-form="createForm" type="button" class="btn btn-o-primary">@lang('chief::users.send_invite')</button>
@endchiefheader

@section('content')

	<form id="createForm" action="{{ route('chief.back.users.store') }}" method="POST">
		{!! csrf_field() !!}

		@include('chief::back.users._form')

		<button type="submit" class="btn btn-primary right">@lang('chief::users.send_invite')</button>
	</form>

@endsection
