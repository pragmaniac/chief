<hr>
@if($manager->isAssistedBy('archive'))

    @if(! $manager->assistant('archive')->isArchived())
        <a data-submit-form="archiveForm-{{ $manager->details()->id }}" class="block squished-s text-warning --link-with-bg">@lang('chief::managers.archive')</a>
        <form class="--hidden" id="archiveForm-{{ $manager->details()->id }}" action="{{ $manager->assistant('archive')->route('archive') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit">@lang('chief::managers.archive')</button>
        </form>
    @else
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
    @endif

@elseif($manager->can('delete'))
    <a v-cloak @click="showModal('delete-manager-<?= str_slug($manager->route('delete')); ?>')" class="block squished-s text-error --link-with-bg">
        @lang('chief::managers.remove')
    </a>
@endif
