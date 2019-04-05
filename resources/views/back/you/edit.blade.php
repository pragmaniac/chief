@extends('chief::back._layouts.master')

@section('page-title', $user->fullname)

@chiefheader
@slot('title', trans('chief::you.manage'))
<div class="inline-group">
    <button data-submit-form="updateForm" type="button" class="btn btn-o-primary">@lang('chief::you.save')</button>
</div>
@endchiefheader

@section('content')

    <form id="updateForm" action="{{ route('chief.back.you.update',$user->id) }}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">

        @include('chief::back.you._form')

        <button type="submit" class="btn btn-primary right">@lang('chief::you.save')</button>
    </form>

@endsection
