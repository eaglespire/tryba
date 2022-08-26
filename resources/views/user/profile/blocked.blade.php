@extends('loginlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">
  <h1 class="mb-0 fw-bold">{{__('Notice')}}</h1>
  <p class="mb-6 text-muted">{{ $reason }}</p>
 
  @if(route('user.blocked') == url()->current())
    <p class="mb-0 fs-sm text-muted">{{__('Click')}} <a href="{{ $url }}">{{__('here')}}</a> {{__('to download your data.')}}. 
  @else 
    <p class="mb-0 fs-sm text-muted">{{__('Click')}} <a href="https://helpdesk.tryba.io/">{{__('here')}}</a> {{__('to contact administrator.')}}. 
  @endif
  </p>
</div>
@endsection