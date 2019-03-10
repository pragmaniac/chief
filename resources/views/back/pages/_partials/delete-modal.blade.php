<modal id="delete-page-{{$page->id}}" class="large-modal" title=''>
    <form action="{{route('chief.back.pages.destroy', $page->id)}}" method="POST" id="delete-page-form-{{$page->id}}" slot>
        @method('DELETE')
        @csrf
        <div v-cloak>
            @if( ! $page->isPublished() || $page->isArchived())
                <h2 class="formgroup-label" slot="modal-header">@lang('chief::pages.cleanup')</h2>
                <p>@lang('chief::pages.description', ['action' => ($page->isDraft() || $page->isArchived() ? 'DELETE' : 'ARCHIVE')])</p>
                <div class="input-group stack">
                    <input data-delete-confirmation name="deleteconfirmation" placeholder="{{ $page->isDraft() || $page->isArchived() ? 'DELETE' : 'ARCHIVE' }}" type="text" class="input inset-s" autocomplete="off">
                </div>
            @else
                <h2 class="formgroup-label">@lang('chief::pages.online_warning')</h2>
                <p>@lang('chief::pages.archive_description')</p>
            @endif
        </div>
    </form>

    <div slot="modal-action-buttons">
        <button type="button" class="btn btn-o-tertiary stack" data-submit-form="delete-page-form-{{$page->id}}">@lang('chief::pages.'. $page->isDraft() || $page->isArchived() ? 'remove' : 'arcvhive'  .'_page')</button>
    </div>
</modal>
