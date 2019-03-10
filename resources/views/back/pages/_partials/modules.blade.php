<?php
    $page = $manager->model();
?>

<h2>@lang('chief::pages.modules.title')</h2>
<p>@lang('chief::pages.modules.description')</p>
@if($page->modules->isEmpty())
    <div class="center-center stack-xl">
        <div>
            <a @click="showModal('create-module')" class="btn btn-primary squished">
            <i class="icon icon-zap icon-fw"></i>@lang('chief::pages.modules.add')
            </a>
        </div>
    </div>
@endif

@if(!$page->modules->isEmpty())
    <div class="row gutter-s">
        @foreach($page->modules->reject(function($module){ return $module->morph_key == 'pagetitle'; }) as $module)
            @include('chief::back.managers._partials._rowitem', ['manager' => app(\Thinktomorrow\Chief\Management\Managers::class)->findByModel($module)])
        @endforeach
    </div>


    <div class="stack">
        <a @click="showModal('create-module')" class="btn btn-primary">
        <i class="icon icon-plus"></i>
            @lang('chief::modules.add')
        </a>
    </div>
@endif

@push('portals')
    @include('chief::back.modules._partials.create-modal', ['page_id' => $page->id])
@endpush
