@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Website')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.storefront')}}" class="text-muted text-hover-primary">{{__('Settings')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Connect domain')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="row g-xl-8">
            <div class="col-xl-12">
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-body">
                        <ol>
                            <li>Changing your nameserver is needed to point your custom domain to Tryba.</li>
                            <li>If you can't find the right place to change your nameserver on your domain registrar account, please contact your domain registrar support.</li>
                            <li>On your domain provider’s website, log in to your account.</li>
                            <li>Find the Name server settings.</li>
                            <li>Change the following records:
                                <ol>
                                    <li>Point your nameservers to the Tryba Nameserver.
                                        <ul>
                                            @foreach(getNameServers() as $ns)
                                            @if($ns['type']=="NS")
                                            <li>{{$ns['target']}}</li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li>Wait for 24-48hrs for the domain to propagate</li>
                                </ol>
                            </li>
                            <li>Navigate to storefront dashboard</li>
                            <li>Add your custom domain to Tryba</li>
                            <li>Save your changes</li>
                            <li>Fill the form below to verify your nameservers points to Tryba's</li>
                        </ol>
                        <div class="col-md-12">
                            <form action="{{route('user.store.custom.domain.verify')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="url" class="form-control form-control-solid mb-3" name="custom_domain" placeholder="{{__('https://mydomain.com')}}" required>
                                <button type="submit" class="btn btn-light-info btn-block px-6">
                                    {{__('Verify Nameserver Connection')}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop