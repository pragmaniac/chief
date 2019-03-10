@extends('chief::back._layouts.master')

@section('page-title', $modelManager->details()->singular .' '.trans('chief::managers.archive_title'))

@component('chief::back._layouts._partials.header')
    @slot('title', $modelManager->details()->singular .' '.trans('chief::managers.archive_title'))
    @slot('subtitle')
        <a class="center-y" href="{{ $modelManager->route('index') }}"><span class="icon icon-arrow-left"></span> @lang('chief::managers.back_all'){{ $modelManager->details()->plural }}</a>
    @endslot
@endcomponent

@section('content')

    <div class="row gutter-s">
        @foreach($managers as $manager)
            @include('chief::back.managers.archive._rowitem')
            @include('chief::back.managers._partials.delete-modal')
        @endforeach
    </div>

@stop
