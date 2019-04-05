@extends('chief::back._layouts.solo')

@section('page-title', trans('chief::users.expired_title'))

@section('content')
    <div class="stack-l">

        <div class="stack">
            <h1>@lang('chief::users.expired_title')</h1>

            @lang('chief::users.expired_description')

            <div class="stack">
                <a class="btn btn-o-primary" href="mailto:{{ chiefSetting('contact.email') }}">@lang('chief::users.contact') ({{ chiefSetting('contact.name') }})</a>
                <a class="btn btn-link" href="{{ route('chief.back.login') }}">@lang('chief::users.to_login')</a>
            </div>

        </div>

    </div>
@endsection
