<options-dropdown class="inline-block">
    <div class="inset-s" v-cloak>

        @if(\Illuminate\Support\Facades\Route::currentRouteName() !== 'chief.back.managers.edit')
            <a href="{{ $manager->route('edit') }}" class="block squished-s --link-with-bg">Aanpassen</a>
        @endif

    </div>
</options-dropdown>