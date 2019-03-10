@extends('chief::back._layouts.master')

@section('title', '| '.trans('chief::permissions.edit_title'))

@section('content')

	<div class='col-lg-4 col-lg-offset-4'>

		{{-- @include ('errors.list') --}}

		<h1><i class='fa fa-key'></i> @lang('chief::permissions.edit') {{$permission->name}}</h1>
		<br>
		<form action="{{ route('permissions.update', $permission->id) }}" method="POST">
			{!! method_field('put') !!}
			{!! csrf_field() !!}
			<div class="form-group">
				<label for="name">@lang('chief::permissions.name')</label>
				<input type="text" name="name" value="{{ $permission->name }}" class="form-control">
			</div>
			<br>

			<button type="submit" value="Submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
		</form>

	</div>

@endsection
