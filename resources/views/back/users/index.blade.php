@extends('chief::back._layouts.master')

@section('page-title', trans('chief::users.index_title'))

@chiefheader
    @slot('title', 'Gebruikers')
    <a href="{{ route('chief.back.users.create') }}" class="btn btn-link text-primary">@lang('chief::users.invite_new_user')</a>
@endchiefheader

@section('content')
    @foreach($users as $user)
        <div class="block stack panel panel-default inset-s center-y">
            <div>
                <a href="{{ route('chief.back.users.edit', $user->id) }}">{{ $user->fullname }}</a>
                {!! $user->present()->enabledAsLabel() !!}
                {!! optional(optional($user->invitation)->present())->stateAsLabel() !!}
            </div>

            <div style="margin-left:auto;">
                <div class="inline-block">
                    @foreach($user->roleNames() as $roleName)
                        <span class="label label-o--primary">{{ $roleName }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <hr>
    @endforeach
@endsection
