@extends('chief::back._layouts.master')

@section('page-title', trans('chief::modules.index_title'))

@component('chief::back._layouts._partials.header')
    @slot('title', 'Vaste modules')
        <div class="inline-group-s">
            <a @click="showModal('create-module')" class="btn btn-primary row center-y">
                <i class="icon icon-plus"></i>
                @lang('chief::modules.add_module')
            </a>
        </div>
    @endcomponent

    @section('content')

        @if($modules->isEmpty())
            <div class="center-center stack-xl">
                <div>
                    <a @click="showModal('create-module')" class="btn btn-primary squished">
                        <i class="icon icon-zap icon-fw"></i>@lang('chief::modules.add_first_module')
                    </a>
                    <p class="stack">
                        <strong>@lang('chief::modules.what_title')</strong><br>
                        @lang('chief::modules.what_description')
                    </p>
                </div>

            </div>
        @endif

        @if(!$modules->isEmpty())
            @foreach($modules as $groupLabel => $module_group)

                <div class="stack">
                    <h2>{{ ucfirst($groupLabel) }}</h2>
                    <div class="row gutter-s">
                        @foreach($module_group as $module)
                            @include('chief::back.managers._partials._rowitem', ['manager' => app(\Thinktomorrow\Chief\Management\Managers::class)->findByModel($module)])
                            @include('chief::back.managers._partials.delete-modal', ['manager' => app(\Thinktomorrow\Chief\Management\Managers::class)->findByModel($module)])
                        @endforeach
                    </div>
                </div>

            @endforeach
        @endif

    @include('chief::back.modules._partials.create-modal')
@stop
