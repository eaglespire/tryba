@if(route("$routeName") == url()->current())
    <a role="button" href="{{route("$routeName")}}" class="d-inline-block my-5 py-6 ps-10 pe-24 bg-primary menu_container_active" style="border-left: 4px solid #4282FF;">
        <div class="d-flex justify-content-center align-items-center">
            <span class="fas fa-stack fa-2x menu_container_span">
                <i class="fas fa-regular fa-circle fa-stack-2x menu_container_span_color text-white"></i>
                <i class="fas fa-{{$icon}} fa-solid  fa-stack-1x fa-inverse fa-sm text-primary"></i>
            </span>
            <div class="ms-2">
                <h6 class="font-weight-bolder">
                    <span class="text-white font-weight-bold">{{__("$linkName")}}</span>
                </h6>
                <p class="text-white">
                    Lorem ipsum dolor.
                </p>
            </div>
        </div>
    </a>
@else
    <a role="button" href="{{route("$routeName")}}" class="d-inline-block my-5 py-3 ps-10 menu_container_not_active" style="border-left: 4px solid white;">
        <div class="d-flex justify-content-center">
            <span class="fas fa-stack fa-2x menu_container_span">
                <i class="fas fa-regular fa-circle fa-stack-2x menu_container_span_color text-dark"></i>
                <i class="fas fa-{{$icon}} fa-solid  fa-stack-1x fa-inverse fa-sm text-primary"></i>
            </span>
            <div class="ms-2">
                <h6 class="font-weight-bolder">
                    <span class="text-dark font-weight-bold">{{__("$linkName")}}</span>
                </h6>
                <p>
                    Lorem ipsum dolor.
                </p>
            </div>
        </div>
    </a>
@endif


