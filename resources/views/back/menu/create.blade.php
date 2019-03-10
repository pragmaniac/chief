@extends('chief::back._layouts.master')

@section('page-title', trans('chief::menu.add_menuitem_title'))

@component('chief::back._layouts._partials.header')
    @slot('title', trans('chief::menu.add_menuitem'))
        <button data-submit-form="createForm" type="button" class="btn btn-primary">@lang('chief::menu.add')</button>
    @endcomponent

    @section('content')

        <form id="createForm" method="POST" action="{{ route('chief.back.menuitem.store') }}" enctype="multipart/form-data" role="form">
            {{ csrf_field() }}

            @include('chief::back.menu._form')

        </form>

    @stop
