@extends('user.website.user.index')
@section('mainpage')
    <div class="row g-xl-8">
        @foreach(getThemes() as $val)
            <div class="col-xl-4">
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center flex-grow-1">
                                <div class="d-flex flex-column">
                                    @if($val->id == $user->website->theme_id)
                                    <span class="badge badge-pill badge-light-info">Default Theme</span>
                                    @else
                                    <a href="{{route('default.website.theme', ['themeId' => $val->id])}}"><span class="badge badge-pill badge-light-info">Set as Default</span></a>
                                    @endif
                                </div>
                            </div>
                            @if($val->id == $user->website->theme_id)
                                <a href="{{route('theme.edit.store')}}" class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow">
                                    <i class="fal fa-pencil fs-1 text-dark"></i>
                                </a>
                            @else 
                                <div class=" w-50px h-50px"></div>
                            @endif
                        </div>
                        <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom card-rounded-bottom max-h-300px min-h-200px" style="background-image:url({{ $val->previewImage }})"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection