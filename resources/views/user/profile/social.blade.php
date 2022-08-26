@extends('user.profile.index')

@section('mainpage')
    @include('user.profile.partials.top', ['title'=>'Social Account'])
    <form action="{{route('user.social')}}" method="post">
      @csrf
      <div class="card mb-6">
      <div class="card-body px-9 pt-6 pb-4">
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/facebook-3.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="facebook" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://facebook.com" value="{{$user->facebook}}">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/youtube-3.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="youtube" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://youtube.com" value="{{$user->youtube}}">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/twitter.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="twitter" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://twitter.com" value="{{$user->twitter}}">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/instagram-2-1.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="instagram" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://instagram.com" value="{{$user->instagram}}">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/linkedin.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="linkedin" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://linkedin.com" value="{{$user->linkedin}}">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-lg-1 col-form-label fw-boldest fs-6"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/whatsapp.svg')}}" class="w-30px me-6" alt=""></label>
          <div class="col-lg-11">
            <input type="url" name="whatsapp" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="https://wa.me" value="{{$user->whatsapp}}">
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
      </div>
      </div>
    </form>
@endsection
