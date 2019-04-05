@extends('chief::back._layouts.solo')

@section('page-title', trans('chief::users.invite_invalid'))

@section('content')
    <div class="stack-l">

        <div class="stack">
            <h1>@lang('chief::users.denied_title')</h1>

            @lang('chief::users.denied_description', ['appname' => chiefSetting('client.app_name')])

            <div class="stack">
                <a class="btn btn-o-primary" href="mailto:{{ chiefSetting('contact.email') }}">@lang('chief::users.contact') ({{ chiefSetting('contact.name') }})</a>
                <a class="btn btn-link" href="{{ route('chief.back.login') }}">@lang('chief::users.to_login')</a>
            </div>

        </div>

    </div>
@endsection
