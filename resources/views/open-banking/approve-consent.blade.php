@extends('openbankinglayout')

@section('content')
<div class="col-8 col-md-8 col-lg-8 mx-auto">

    <h1 class="fw-bold text-center">{{__('Authorise ')}} {{strtoupper($consent->TppName)}}</h1>
    <div class="col-8 col-md-8 col-lg-8 mx-auto">
        <h4 class="fw-bold text-center">{{__('About this request ')}}</h4>
        <p class="mb-6 text-dark"> {{$consent->AppName}} is trying to access your Tryba account information using Open Banking. The permissions being requested are shown below: </p>
        @php
        $permissions = explode(",", $consent->Permissions);
        @endphp
        @foreach ($permissions as $permission)
        <p>{!! $permission !!}</p>
         @endforeach 
         If this is okay by you, go ahead and approve it below. If it's not, click on reject and your account wont be impacted.</p>
    </div>
<div class="d-flex justify-content-center">
        <div class="col-md-4 col-sm-12 mx-2 p-2">
            <a href="{{route('consent.decision', ['consentId' => $consent->ConsentId, 'decision'=> 'reject'])}}" class="btn w-100 btn-warning mb-5 mt-5">{{__('Reject')}}</a> 
        </div>
        <div class="col-md-4 col-sm-12 mx-2 p-2">
        <a href="{{route('consent.decision', ['consentId' => $consent->ConsentId, 'decision'=> 'approve'])}}" class="btn w-100 btn-primary mb-5 mt-5">{{__('Approve')}}</a> 
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