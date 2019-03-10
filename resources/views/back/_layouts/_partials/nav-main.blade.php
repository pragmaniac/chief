<!-- Here you find the specific chief navigation for your project -->
{!! Thinktomorrow\Chief\Nav\Nav::fromKeys('singles')->render('Pagina\'s') !!}

{!! Thinktomorrow\Chief\Nav\Nav::fromTags('page')
    ->rejectKeys('singles')
    ->renderItems(trans('chief::nav.collections'))
!!}

{!! Thinktomorrow\Chief\Nav\Nav::allManagers()
    ->rejectKeys('singles')
    ->rejectTags(['page', 'module', 'pagesection'])
    ->renderItems(trans('chief::nav.models'))
!!}
