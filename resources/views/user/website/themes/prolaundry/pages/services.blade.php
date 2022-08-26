@extends('user.website.themes.prolaundry.layout')

@section('content')

@include('user.website.themes.prolaundry.components.breadcrumb')
<main id="tt-pageContent">
    <div class="lazyload subpage-bg-left subpage-bg__position02" data-bg="{{  asset('asset/themes/website/prolaundry/images/wrapper-subpage-left03.png') }}">
    <div class="lazyload subpage-bg-right subpage-bg__position02" data-bg="{{  asset('asset/themes/website/prolaundry/images/wrapper-subpage-right03.png') }}">
        <div class="section-indent mb-5">
            <div class="container container-fluid-lg">
                <div class="title-block text-center mb-5">
                    <div class="title-block__label">
                        [ Our Services ]
                    </div>
                    <h4 class="title-block__title">
                        Dry Cleaning & Laundry, <br>Free Delivery
                    </h4>
                </div>
                <div class="row img-box__wrapper">
                    @foreach($services as $key => $item)
                        <div class="col-custom-450 col-6 col-md-4">
                            <div class="img-box">
                                <div class="img-box__img">
                                    <a href="{{ route('single.service',['id'=>$website->websiteUrl , 'service' =>  $item->id ]) }}"><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload service-image" data-src="{{  $item->image }}" alt=""></a>
                                    <div class="img-box__label icons-747310"></div>
                                </div>
                                <a href="{{ route('single.service',['id'=>$website->websiteUrl , 'service' =>  $item->id ]) }}" class="img-box__title">{{ $item->name }}</a>
                                <p>
                                    {{ substr($item->description,0,150) }}
                                </p>
                                <a href="{{ route('single.service',['id'=>$website->websiteUrl , 'service' =>  $item->id ]) }}" class="tt-btn">
                                    <span class="mask">More Info</span>
                                    <div class="button">More Info</div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection