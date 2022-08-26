@extends('marketlayout')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-4 col-lg-3 col-xl-3 leftColumn aside">
                    <div class="tt-btn-col-close">
                        <a href="#">{{__('Close')}}</a>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">{{__('PRODUCT CATEGORIES')}}</h3>
                        <div class="tt-collapse-content" style="">
                            <ul class="tt-list-row mb-4">
                                @foreach($category as $val)
                                <li>
                                    <a href="{{route('market.cat', ['cat' => $val->id])}}">{{$val->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{route('user.storefront')}}" class="btn btn-warning text-uppercase d-block d-sm-none fs-9" target="_blank">Set up you store for free</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="container-indent0">
                        <div class="container-fluid">
                            <div class="tt-filters-options mb-3">
                                <div class="tt-btn-toggle">
                                    <a href="#" class="text-dark">{{__('CATEGORY')}}</a>
                                </div>
                                <div class="tt-sort">
                                    <div class="dropdown">
                                        <button class="btn bg-white text-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fal fa-globe"></i> Wordwide
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            @foreach($country as $val)
                                            <li><a class="dropdown-item" href="{{route('market.country', ['id' => $val->id])}}">{{$val->real['nicename']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row tt-layout-promo-box">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        @foreach($category as $val)
                                        <div class="col-sm-4">
                                            <a href="{{route('market.cat', ['cat' => $val->id])}}" class="tt-promo-box tt-one-child hover-type-2">
                                                <img src="{{asset('asset/images/'.$val->image)}}" data-src="{{asset('asset/images/'.$val->image)}}" alt="{{$val->name}}" class="loaded" data-was-processed="true">
                                                <div class="tt-description">
                                                    <div class="tt-description-wrapper">
                                                        <div class="tt-background"></div>
                                                        <div class="tt-title-small">{{$val->description}}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop