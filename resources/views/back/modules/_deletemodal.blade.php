<!-- Admin Form Popup -->
<div id="remove-module-modal" class="popup-basic admin-form mfp-with-anim mfp-hide">
    <div class="panel">
        <div class="panel-heading text-center">
              <span class="panel-title text-danger">Remove this module?</span>
        </div>
        <div class="panel-body text-center">
            This will permanently remove module entitled:<br>
            <em>{{ $module->strippedTitle }}</em>.
            <br><br>Are you sure?
        </div>
        <div class="panel-footer">
            <div class="text-center">
                <form action="{{ route('admin.modules.destroy',$module->id) }}" method="POST" class="admin-form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-danger btn-lg" type="submit">Yes, delete module</button>
                </form>
            </div>
        </div>

    </div>
    <!-- end: .panel -->
</div>
<!-- end: .admin-form -->
