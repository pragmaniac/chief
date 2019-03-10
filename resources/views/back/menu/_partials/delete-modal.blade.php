<modal id="delete-menuitem-{{$menuitem->id}}" class="large-modal" title=''>
    <form id="deleteForm-menuitem-{{$menuitem->id}}" v-cloak action="{{route('chief.back.menuitem.destroy', $menuitem->id)}}" method="POST">
        @method('DELETE')
        @csrf

        <h2>@lang('chief::menu.delete', ['label' => $menuitem->label])</h2>
        <p>@lang('chief::menu.delete_confirm')</p>
    </form>

    <div slot="modal-action-buttons" v-cloak>
        <button data-submit-form="deleteForm-menuitem-{{$menuitem->id}}" class="btn btn-o-tertiary inline-s" type="button"><span class="icon icon-trash"></span> @lang('chief::menu.confirm_removal')</button>
    </div>
</modal>
