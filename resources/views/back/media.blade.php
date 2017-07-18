@extends('back._layouts.master')

@section('page-title')
Mediagalerij
@stop

@section('topbar-right')

@stop

@section('content')
<form action="{{ route('media.remove') }}" method="POST">
  {{ csrf_field() }}
  @include('back.media.filter')
  @include('back.media.gallery')
</form>
@stop

@section('sidebar')
@include('back.media._partials.upload')
{{--@include('back._partials.mediaslidemenu')--}}
@stop

@push('custom-scripts')
<script>
$(document).ready(function(){

  $(document.body).removeClass('sb-r-c');

  $("#showUploadPanel").click(function(){
    $(document.body).toggleClass('sb-r-o');
  });
  $("#showCropPanel").click(function(){
    $(document.body).toggleClass('sb-r-o');
  });

  // SHOW OR HIDE DELETE BUTTON
  $('.showDeleteUptions').click(function(){
    $('.deleteActions').removeClass('hidden');
    $('.showDeleteUptions').addClass('hidden');
  });
  $('.noDelete').click(function(){
    $('.deleteActions').toggle();
    $('.showDeleteUptions').toggle();
  });

  // TOGGLE SELECTED MEDIA WITH THE CHECKBOXES
  var getCheckbox = $(".checkbox-delete > input:checkbox");

  getCheckbox.change(function () {
    if ($(this).is(":checked")) {
      $(this).closest(".media").addClass('selected');
      $(this).closest(".checkbox-delete").addClass('show');
      $('.deleteMedia').removeClass('hidden');
    }
    else {
      $(this).closest(".media").removeClass('selected');
      $(this).closest(".checkbox-delete").removeClass('show');
      $('.deleteMedia').addClass('hidden');
      $('#selectAllMedia').prop('checked', false);
    };
  });

  // CHECKBOX TO SELECT ALL IMAGES
  $('#selectAllMedia').change(function(){
    if ($(this).is(":checked")) {
      getCheckbox.closest(".media").addClass('selected');
      getCheckbox.closest(".checkbox-delete").addClass('show');
      getCheckbox.prop('checked',true);
      $('.deleteMedia').removeClass('hidden');
      $('.selectBtn .fa').removeClass('hidden');
    }
    else{
      getCheckbox.closest(".media").removeClass('selected');
      getCheckbox.closest(".checkbox-delete").removeClass('show');
      getCheckbox.prop('checked',false);
      $('.deleteMedia').addClass('hidden');

    }
  });

  // give file-upload preview onclick functionality
  var fileUpload = $('.fileupload-preview');
  if (fileUpload.length) {
    fileUpload.each(function(i, e) {
      var fileForm = $(e).parents('.fileupload').find('.btn-file > input');
      $(e).on('click', function() {
        fileForm.click();
      });
    });
  }
});
</script>


@endpush
