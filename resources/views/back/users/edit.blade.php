@extends('chief::back._layouts.master')

@section('page-title', $user->fullname)

@chiefheader
	@slot('title', $user->fullname)
	<div class="inline-group">
		{!! $user->present()->enabledAsLabel() !!}
		@if($user->isEnabled())
			<button data-submit-form="updateForm" type="button" class="btn btn-o-primary">@lang('chief::users.save')</button>
		@endif
		<options-dropdown class="inline-block">
			<div v-cloak>
				<div>
					<a class="block inset-s" href="{{ route('chief.back.invites.resend', $user->id) }}">@lang('chief::users.send_new_invite')</a>
				</div>
				<hr>
				<div class="inset-s font-s">
					@if($user->isEnabled())
						<form method="POST" action="{{ route('chief.back.users.disable', $user->id) }}">
							{{ csrf_field() }}
							<p>@lang('chief::users.block_account', ['name' =>$user->firstname])</p>
						</form>
					@else
						<form method="POST" action="{{ route('chief.back.users.enable', $user->id) }}">
							{{ csrf_field() }}
							<p>@lang('chief::users.blocked', ['name' => $user->firstname])</p>
						</form>
					@endif
				</div>
			</div>
		</options-dropdown>
	</div>
@endchiefheader

@section('content')

	<form id="updateForm" action="{{ route('chief.back.users.update',$user->id) }}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">

		@include('chief::back.users._form')

		<button type="submit" class="btn btn-primary right">@lang('chief::users.save_changes')</button>
	</form>

@endsection
