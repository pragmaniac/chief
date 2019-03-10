<modal id="delete-module-{{$module->id}}" class="large-modal" title=''>
    <form v-cloak action="{{route('chief.back.modules.destroy', $module->id)}}" method="POST" id="delete-module-form-{{$module->id}}" slot>
        @method('DELETE')
        @csrf
        <div v-cloak>
            <h2 class="formgroup-label" slot="modal-header">@lang('chief::modules.remove_title')</h2>
            <p>@lang('chief::modules.remove_description')</p>
            <div class="input-group">
                <input data-delete-confirmation name="deleteconfirmation" placeholder="" type="text" class="input inset-s" autocomplete="off">
            </div>
        </div>
    </form>

    <div v-cloak slot="modal-action-buttons">
        <button type="button" class="btn btn-o-tertiary stack" data-submit-form="delete-module-form-{{$module->id}}">@lang('chief::modules.remove_module')</button>
    </div>
</modal>
