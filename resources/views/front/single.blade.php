@extends('layout')
@section('css')

@stop
@section('content')
<div class="pb-10"></div>
<section class="pt-8 pt-md-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
            <h1 class="display-4 text-center">{{$post->title}}</h1>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
<section class="pt-6 pt-md-8 pb-8">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
            <p>{!!$post->details!!}</p>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
<div class="position-relative">
      <div class="shape shape-bottom shape-fluid-x text-light">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"></path></svg>      </div>
    </div>
<section class="py-8 py-md-11 bg-light">
    <div class="container">
        <div class="row">
            @foreach($posts as $vblog)
                <div class="col-12 col-md-6 col-lg-4 d-flex">
                    <div class="card mb-6 mb-lg-0 shadow-light-lg lift lift-lg">
                        <a class="card-img-top" href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">
                            <img src="{{asset('asset/thumbnails/'.$vblog->image)}}" alt="..." class="card-img-top">
                            <div class="position-relative">
                                <div class="shape shape-bottom shape-fluid-x text-white">
                                    <svg viewBox="0 0 2880 480" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2160 0C1440 240 720 240 720 240H0v240h2880V0h-720z" fill="currentColor"></path></svg>                  
                                </div>
                            </div>
                        </a>
                        <a class="card-body" href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">
                            <h3>{!!  str_limit($vblog->title, 40);!!}..</h3>
                            <p class="mb-0 text-muted">{!!  str_limit($vblog->details, 80);!!}</p>
                        </a>
                        <a class="card-meta mt-auto" href="{{url('/')}}/single/{{$vblog->id}}/{{str_slug($vblog->title)}}">
                        <hr class="card-meta-divider">
                        <p class="h6 text-uppercase text-muted mb-0 ms-auto">
                            <time datetime="2019-05-02">{{date("M j", strtotime($vblog->created_at))}}</time>
                        </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
@stop