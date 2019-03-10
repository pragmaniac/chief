<div class="row bg-white inset panel panel-default stack">
    <div class="column-9">

            @if($page->isArchived())
                <span class="text-black bold" title="@lang('chief::pages.archived_edit_error', ['pagetype' => {{ $page->collectionDetails()->singular }}])">
                    {{ $page->getTranslationFor('title') }}
                </span>
            @else
                <a class="text-black bold" href="{{ route('chief.back.pages.edit',$page->getKey()) }}">
                    {{ $page->getTranslationFor('title') }}
                </a>
            @endif

            <div>
                <span class="text-subtle">@lang('chief::pages.last_edit') {{ $page->updated_at->format('d/m/Y') }}</span>
            </div>
            <div class="stack-s font-s">
                {{ teaser($page->content,250,'...') }}
            </div>
    </div>
    <div class="column-3 text-right">
        @include('chief::back.pages._partials.context-menu')
    </div>
</div>
