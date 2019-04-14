@extends('chief::back._layouts.master')

@section('page-title', trans('chief::menu.edit_menuitem_title'))

@component('chief::back._layouts._partials.header')
    @slot('title', trans('chief::menu.edit_menuitem'))
    @slot('subtitle')
        <div class="inline-block">
            <a class="center-y" href="{{ route('chief.back.menus.index', $menuitem->menu_type) }}"><span class="icon icon-arrow-left"></span>@lang('chief::menu.back')</a>
        </div>
    @endslot
        <span class="btn btn-link inline-block inline-s" @click="showModal('delete-menuitem-{{$menuitem->id}}')">
            @lang('chief::menu.remove')
        </span>
        <button data-submit-form="updateForm" type="button" class="btn btn-primary">Opslaan</button>
    @endcomponent

    @section('content')

        <form id="updateForm" method="POST" action="{{ route('chief.back.menuitem.update', $menuitem->id) }}" enctype="multipart/form-data" role="form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            @include('chief::back.menu._form')

        </form>
        @include('chief::back.menu._partials.delete-modal')
    @stop
