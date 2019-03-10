<options-dropdown class="inline-block">
    <div class="inset-s" v-cloak>

        @if($page->isPublished())
            <a href="{{ $page->menuUrl() }}" target="_blank" class="block squished-s">@lang('chief::pages.view_online')</a>
        @elseif($page->isDraft())
            <a href="{{ $page->previewUrl() }}" target="_blank" class="block squished-s">@lang('chief::pages.view_preview')</a>
        @endif

        @if(!$page->isArchived())
            @if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'chief.back.pages.edit')
                <a href="{{ route('chief.back.pages.edit',$page->getKey()) }}" class="block squished-s --link-with-bg">@lang('chief::pages.edit')</a>
            @endif
        @endif

        <hr class="stack-s">

        @if($page->isPublished())

            <a data-submit-form="draftForm-{{$page->id}}" class="block squished-s text-warning --link-with-bg">@lang('chief::pages.draft')</a>

            <form class="--hidden" id="draftForm-{{$page->id}}" action="{{ route('chief.back.pages.draft', $page->id) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit">@lang('chief::pages.draft')</button>
            </form>

            <hr class="stack-s">

            <a data-submit-form="archiveForm-{{$page->id}}" class="block squished-s text-error --link-with-bg">@lang('chief::pages.archive') '{{ teaser($page->title,15,'...') }}'</a>

            <form class="--hidden" id="archiveForm-{{$page->id}}" action="{{ route('chief.back.pages.archive', $page->id) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <button type="submit">@lang('chief::pages.archive')</button>
            </form>

        @elseif($page->isDraft())
            <a data-submit-form="publishForm-{{$page->id}}" class="block squished-s --link-with-bg">@lang('chief::pages.publish')</a>

            <form class="--hidden" id="publishForm-{{$page->id}}" action="{{ route('chief.back.pages.publish', $page->id) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit">@lang('chief::pages.publish')</button>
            </form>

            <hr class="stack-s">

            <a v-cloak @click="showModal('delete-page-{{$page->id}}')" class="block squished-s text-error --link-with-bg">
                @lang('chief::pages.remove')
            </a>

        @elseif($page->isArchived())
            <a data-submit-form="draftForm-{{$page->id}}" class="block squished-s --link-with-bg">@lang('chief::pages.open_as_draft')</a>

            <form class="--hidden" id="draftForm-{{$page->id}}" action="{{ route('chief.back.pages.draft', $page->id) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit">@lang('chief::pages.open_as_draft')</button>
            </form>

            <hr class="stack-s">

            <a v-cloak @click="showModal('delete-page-{{$page->id}}')" class="block squished-s text-error --link-with-bg">
                @lang('chief::pages.remove')
            </a>
        @endif
    </div>
</options-dropdown>
