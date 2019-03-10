<options-dropdown class="inline-block">
    <div class="inset-s" v-cloak>

        <a data-submit-form="unarchiveForm-{{ $manager->details()->id }}" class="block squished-s text-warning --link-with-bg">@lang('chief::managers.restore')</a>

        <form class="--hidden" id="unarchiveForm-{{ $manager->details()->id }}" action="{{ $manager->assistant('archive')->route('unarchive') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit">@lang('chief::managers.restore')</button>
        </form>

        @if($manager->can('delete'))
            <a v-cloak @click="showModal('delete-manager-<?= str_slug($manager->route('delete')); ?>')" class="block squished-s text-error --link-with-bg">
                @lang('chief::managers.remove')
            </a>
        @endif

    </div>
</options-dropdown>
