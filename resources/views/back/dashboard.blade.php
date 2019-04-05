@extends('chief::back._layouts.master')

@section('page-title')
    @lang('chief::dashboard.title')
@stop

@section('topbar-right')

@stop

@section('content')
    <div class="row gutter stack-l">
        <div class="column-4 stretched-xl">
            <h1>@lang('chief::dashboard.welcome'), {{ Auth::user()->firstname }}</h1>
            <p>@lang('chief::dashboard.inspiring')</p>
        </div>
        <div class="gutter column-8 inset right">
            @foreach(app(\Thinktomorrow\Chief\Management\Managers::class)->findByTag(['page', 'dashboard']) as $manager)

                @if(!$manager->can('index')) @continue @endif

                @if($manager->findAllManaged()->count() > 0)
                    <div class="column-6">
                        <div class="panel panel-default --raised">
                            <div class="panel-body inset">
                                <div class="btn btn-o-primary btn-circle">
                                    <i class="icon icon-box"></i>
                                </div>
                                <div class="stack">
                                    <h1 class="--remove-margin">{{ $manager->findAllManaged()->count() }}</h1>
                                    <p>{{ $manager->details()->plural }}</p>
                                    <a class="btn btn-secondary" href="{{ $manager->route('index') }}">@lang('chief::dashboard.goto') {{ $manager->details()->plural }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    </div>
@stop
