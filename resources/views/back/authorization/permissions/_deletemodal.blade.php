<!-- Admin Form Popup -->
<div id="remove-permission-modal-{{ $permission->id }}" class="popup-basic admin-form mfp-with-anim mfp-hide">
    <div class="panel">
        <div class="panel-heading text-center">
              <span class="panel-title text-danger">@lang('chief::permissions.remove')</span>
        </div>
        <div class="panel-body text-center">
            @lang('chief::permissions.total_delete')<br>
            <em>{{ $permission->name }}</em>.
            <br><br>@lang('chief::permissions.confirm')
        </div>
        <div class="panel-footer">
            <div class="text-center">
                <form action="{{ route('chief.back.permissions.destroy', $permission->id) }}" method="POST" class="admin-form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-danger btn-lg" type="submit">@lang('chief::permissions.confirm_remove')</button>
                </form>
            </div>
        </div>

    </div>
    <!-- end: .panel -->
</div>
<!-- end: .admin-form -->
