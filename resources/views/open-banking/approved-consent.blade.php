@extends('openbankinglayout')

@section('content')
<div class="col-8 col-md-8 col-lg-8 mx-auto">

    <div class="col-8 col-md-8 col-lg-8 mx-auto">
        <h4 class="fw-bold text-center">{{__('All Done ')}}</h4>
        @if(isset($response->outcome) && $response->outcome == 'Pass')
            <p class="mb-6 text-dark"> You have approved the permission requested by {{$consent->AppName}} you can close this page and return to the referring application </p>
        @else
            <p class="mb-6 text-dark"> You have rejected the permission requested by {{$consent->AppName}} you can close this page and return to the referring application </p>
        @endIf


    </div>
<div class="d-flex justify-content-center">
        <div class="col-md-4 col-sm-12 mx-2 p-2">
            <a href="#" class="btn w-100 btn-primary mb-5 mt-5">{{__('Back to Third Party')}}</a> 
        </div>
</div>
</div>

@stop
@section('script')
<script>
  ! function($) {
    'use strict';
    $(function() {
      $('[data-toggle="password"]').each(function() {
        var input = $(this);
        var eye_btn = $(this).parent().find('.input-group-text');
        eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
        eye_btn.on('click', function() {
          if (eye_btn.hasClass('input-password-hide')) {
            eye_btn.removeClass('input-password-hide').addClass('input-password-show');
            eye_btn.find('.fa').removeClass('fa-eye').addClass('fa-eye-slash')
            input.attr('type', 'text');
          } else {
            eye_btn.removeClass('input-password-show').addClass('input-password-hide');
            eye_btn.find('.fa').removeClass('fa-eye-slash').addClass('fa-eye')
            input.attr('type', 'password');
          }
        });
      });
    });
  }(window.jQuery);
</script>
@endsection