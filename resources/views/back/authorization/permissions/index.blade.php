@extends('chief::back._layouts.master')

@section('title', '| '. trans('chief::permissions.index_title'))

@section('content')

	<div class="col-lg-10 col-lg-offset-1">
		<h1><i class="fa fa-key"></i>@lang('chief::permissions.available')

			@can('view_users')
				<a href="{{ route('users.index') }}" class="btn btn-default pull-right">@lang('chief::permissions.users')</a>
			@else
				<a class="btn btn-default pull-right disabled">@lang('chief::permissions.users')</a>
			@endcan
			@can('view_roles')
				<a href="{{ route('roles.index') }}" class="btn btn-default pull-right">@lang('chief::roles.index_title')</a>
			@else
				<a class="btn btn-default pull-right disabled">@lang('chief::roles.index_title')</a>
			@endcan
		</h1>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">

				<thead>
				<tr>
					<th>@lang('chief::permissions.index_title')</th>
					<th>@lang('chief::permissions.index_title')Operation</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($permissions as $permission)
					<tr>
						<td>{{ $permission->name }}</td>
						<td>
							@can('edit_permissions')
								<a href="{{ URL::to('admin/permissions/'.$permission->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							@else
								<a class="btn btn-info pull-left disabled" style="margin-right: 3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							@endcan

							@can('delete_permissions')
									<a class="btn btn-error" id="remove-permission-toggle-{{ $permission->id }}" href="#remove-permission-modal-{{ $permission->id }}"><i class="fa fa-trash"></i></a>
							@else
									<a class="btn btn-error disabled"><i class="fa fa-trash"></i></a>
							@endcan
						</td>
					</tr>
					@include('chief::back.authorization.permissions._deletemodal')
					@push('custom-scripts')
					<script>
						;(function ($) {
							// Delete modal
							$("#remove-permission-toggle-{{ $permission->id }}").magnificPopup();
						})(jQuery);
					</script>
					@endpush
				@endforeach
				</tbody>
			</table>
		</div>

		@can('add_permissions')
			<a href="{{ URL::to('admin/permissions/create') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
		@else
			<a class="btn btn-success disabled"><i class="fa fa-plus" aria-hidden="true"></i></a>
		@endcan

	</div>
@endsection
