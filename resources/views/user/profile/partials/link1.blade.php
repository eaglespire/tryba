<a role="button" href="{{route("$routeName")}}" class="@if(route("$routeName") == url()->current()) menu_container_not_active @else menu_container_active @endif d-inline-block my-5">
@if(route("$routeName") == url()->current())
    <div class="card card-body bg-primary rounded-0 mb-8" style="border-left: 4px solid darkblue;">
@endif
            <div class="d-flex justify-content-center @if(route("$routeName") == url()->current()) mx-10 @endif">
            <span class="fas fa-stack fa-2x menu_container_span">
                <i class="fas fa-regular fa-circle fa-stack-2x menu_container_span_color @if(route("$routeName") == url()->current()) text-white @endif"></i>
                <i class="fas fa-{{$icon}} fa-solid  fa-stack-1x fa-inverse fa-sm @if(route("$routeName") == url()->current()) text-primary @else menu_icon_color @endif"></i>
            </span>
            <div class="ms-2">
                <h6 class="font-weight-bolder">
                    <span class="@if(route("$routeName") == url()->current()) text-white @else text-dark @endif font-weight-bold">{{__("$linkName")}}</span>
                </h6>
                <p @if(route("$routeName") == url()->current()) style="color: #CFF0FC" @endif>
                    Lorem ipsum dolor.
                </p>
            </div>
            </div>
@if(route("$routeName") == url()->current())
    </div>
@endif
</a>
