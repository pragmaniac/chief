@extends('chief::back._layouts.master')

@section('page-title', trans('chief::roles.index_title'))

@chiefheader
	@slot('title', 'Rollen')
	<a href="{{ route('chief.back.roles.create') }}" class="btn btn-link text-primary">@lang('chief::roles.index_add_role')</a>
@endchiefheader

@section('content')
	@foreach($roles as $role)
		<a class="block stack panel panel-default inset-s" href="{{ route('chief.back.roles.edit', $role->id) }}">{{ $role->name }}</a>
	@endforeach
@stop
