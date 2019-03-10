@extends('chief::back._layouts.solo')

@section('content')
    <h2>@lang('chief::errorpage.message')</h2>
    <a href="{{ url('/admin') }}">
    <button>
        @lang('chief::errorpage.back')
    </button>
    </a>
@endsection
