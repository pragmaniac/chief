@extends('chief::back._layouts.master')

@section('page-title',trans('chief::audit.audit'))

@component('chief::back._layouts._partials.header')
    @slot('title', trans('chief::audit.events_for').' "'. $causer->fullname . '"')
@endcomponent

@section('content')
    <div class="treeview stack-l">
        <div class="row">
            <div class="column-3 center-y">
                <strong>@lang('chief::audit.activity')</strong>
            </div>
            <div class="column-3 center-y">
                <strong>@lang('chief::audit.model')</strong>
            </div>
            <div class="column-3 center-y">
                <strong>@lang('chief::audit.timestamp')</strong>
            </div>
        </div>
        @foreach($activity as $event)
            <div class="row">
                <div class="column-3 center-y">
                    {{ $event->description }}
                </div>
                <div class="column-3 center-y">
                    {{ $event->subject_type }}
                </div>
                <div class="column-3 center-y">
                    {{ $event->created_at }}
                </div>
            </div>
        @endforeach
    </div>

@stop
