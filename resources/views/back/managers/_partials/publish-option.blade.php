@if($manager->isAssistedBy('publish'))
    @if($manager->assistant('publish')->isPublished())

        <a data-submit-form="draftForm-{{ $manager->details()->id }}" class="block squished-s text-warning --link-with-bg">@lang('chief::managers.draft')</a>

        <form class="--hidden" id="draftForm-{{ $manager->details()->id }}" action="{{ $manager->assistant('publish')->route('draft') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit">@lang('chief::managers.draft')</button>
        </form>

    @elseif($manager->assistant('publish')->isDraft())

        <a data-submit-form="publishForm-{{ $manager->details()->id }}" class="block squished-s --link-with-bg">@lang('chief::managers.publish')</a>

        <form class="--hidden" id="publishForm-{{ $manager->details()->id }}" action="{{ $manager->assistant('publish')->route('publish') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit">@lang('chief::managers.publish')</button>
        </form>

    @endif
@endif
