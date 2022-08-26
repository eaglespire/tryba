@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Reply ticket')}}</h1>
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.ticket')}}" class="text-muted text-hover-primary">{{__('Ticket')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Reply')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    @if($ticket->files!=null)
    <div class="d-flex flex-wrap flex-stack my-5">
      <!--begin::Title-->
      <h2 class="fw-bold fs-2 my-2">{{__('Attachements')}}</h2>
      <!--end::Title-->
    </div>
    <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
      @foreach(json_decode($ticket->files) as $val)
      <div class="col-lg-3">
        <!--begin::Card-->
        <div class="card h-100">
          <div class="card-body d-flex justify-content-center text-center flex-column p-8">
            <a href="{{asset('asset/profile/'.$val)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
              <!--begin::Image-->
              <div class="symbol symbol-75px mb-8">
                <i class="fal fa-file fa-2x text-dark"></i>
              </div>
              <!--end::Image-->
              <!--begin::Title-->
              <div class="fs-6 mb-2">{{$val}}</div>
              <!--end::Title-->
            </a>
            <!--end::Name-->
          </div>
          <!--end::Card body-->
        </div>
      </div>
      @endforeach
    </div>
    @endif
    <div class="card" id="kt_chat_messenger">
      <div class="card-header" id="kt_chat_messenger_header">
        <div class="card-title">
          <div class="d-flex justify-content-center flex-column me-3">
            <div class="fs-4 fw-bolder text-dark text-hover-primary me-1 mb-2 lh-1">{{__('Log')}}</div>
          </div>
        </div>
        <div class="card-toolbar">
          <div class="me-n3">
            @if($ticket->status==0)
            <a href="{{route('ticket.resolve', ['id'=>$ticket->id])}}" class="btn btn-sm btn-primary"><i class="fal fa-thumbs-up"></i> {{__('Mark as Resolved')}}</a>
            @else
            <span class="badge badge-pill badge-success"><i class="fal fa-check"></i> {{__('Resolved')}}</span>
            @endif
          </div>
        </div>
      </div>
      <div class="card-body" id="kt_chat_messenger_body">
        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 266px;">
          <div class="d-flex justify-content-start mb-10">
            <div class="d-flex flex-column align-items-start">
              <div class="d-flex align-items-center mb-2">
                <div class="ms-3">
                  <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{__('You')}}</a>
                  <span class="text-muted fs-7 mb-1">{{$ticket->created_at->diffforHumans()}}</span>
                </div>
              </div>
              <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">{{$ticket->message}}</div>
            </div>
          </div>
          @foreach($reply as $df)
          @if($df->status==1)
          <div class="d-flex justify-content-start mb-10">
            <div class="d-flex flex-column align-items-start">
              <div class="d-flex align-items-center mb-2">
                <div class="ms-3">
                  <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{__('You')}}</a>
                  <span class="text-muted fs-7 mb-1">{{$df->created_at->diffforHumans()}}</span>
                </div>
              </div>
              <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">{{$df->reply}}</div>
            </div>
          </div>
          @else
          <div class="d-flex justify-content-end mb-10">
            <div class="d-flex flex-column align-items-end">
              <div class="d-flex align-items-center mb-2">
                <div class="me-3">
                  <span class="text-muted fs-7 mb-1">{{$df->created_at->diffforHumans()}}</span>
                  <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">@if($df->staff_id==1) {{__('Administrator')}} @else {{$df->staff['first_name'].' '.$df->staff['last_name']}} - <span class="badge badge-pill badge-success">Staff</span> @endif</a>
                </div>
              </div>
              <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">{{$df->reply}}</div>
            </div>
          </div>
          @endif
          @endforeach
        </div>
      </div>
      <!--begin::Card footer-->
      <div class="card-footer pt-4" id="kt_chat_messenger_footer">
        <form action="{{url('user/reply-ticket')}}" method="post">
          @csrf
          <!--begin::Input-->
          <textarea name="details" class="form-control form-control-flush mb-3" rows="3" required data-kt-element="input" placeholder="Type a message"></textarea>
          <input name="id" value="{{$ticket->ticket_id}}" type="hidden">
          <!--end::Input-->
          <!--begin:Toolbar-->
          <div class="d-flex flex-stack">
            <button class="btn btn-primary" type="submit" data-kt-element="send">{{__('Send')}}</button>
          </div>
        </form>
        <!--end::Toolbar-->
      </div>
      <!--end::Card footer-->
    </div>
  </div>
</div>
</div>
@stop