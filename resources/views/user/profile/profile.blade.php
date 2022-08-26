@extends('user.profile.index')

@section('mainpage')
    @include('user.profile.partials.top', ['title'=>'Profile'])

    <div class="card mt-5">
        <form action="{{route('user.profile.update')}}" method="post">
            @csrf
        <div class="card-body">
            <div class="row g-8">
                <div class="col-lg-6">
                    <input type="text" readonly name="first_name" class="py-5 bg-light-primary form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{__('First name')}}" value="{{ucwords(strtolower($user->first_name))}}" required>
                </div>
                <div class="col-lg-6">
                    <input type="text" readonly name="last_name" class="py-5 bg-light-primary form-control form-control-lg form-control-solid" placeholder="{{__('Last name')}}" value="{{ucwords(strtolower($user->last_name))}}" required>
                </div>
                <div class="col-lg-12">
                    <div class="input-group input-group-solid bg-light-primary">
                          <span class="input-group-prepend">
                            <span class="input-group-text">+{{$user->getCountry()->phonecode}}</span>
                          </span>
                        <input type="tel" name="phone" maxlength="14" class="py-5 form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - with country code')}}" value="{{str_replace('+'.$user->getCountry()->phonecode, '', $user->phone)}}">
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="email" name="email" class="py-5 bg-light-primary form-control form-control-lg form-control-solid" placeholder="{{__('Email address')}}" value="{{$user->email}}" required>
                </div>
                <div class="col-lg-12">
                    <select class="py-5 bg-light-primary form-control form-control-lg form-control-solid" id="mcc" name="mcc" required @if($user->mcc!=null)disabled @endif>
                        <option value="">{{__('What are your services?')}}</option>
                        @foreach(getMcc() as $val)
                            <option value="{{$val->id}}" @if($user->mcc==$val->id)selected @endif>{{$val->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="password" name="password"  class="py-5 bg-light-primary form-control form-control-lg form-control-solid" placeholder="{{__('Password')}}" value="" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary py-5">{{__('Save Changess')}}</button>
            </div>
        </div>
        </form>
    </div>
{{--    <form action="{{route('user.profile.update')}}" method="post">--}}
{{--        @csrf--}}
{{--        <div class="card mb-6">--}}
{{--            <div class="card-body px-9 pt-6 pb-4">--}}
{{--                <div class="row mb-6">--}}
{{--                    <label class="col-lg-3 col-form-label required fw-bold--}}
{{--              fs-6">{{__('Full Name')}}</label>--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <input type="text" readonly name="first_name"--}}
{{--                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{__('First name')}}" value="{{ucwords(strtolower($user->first_name))}}" required>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <input type="text" readonly name="last_name" class="form-control form-control-lg form-control-solid" placeholder="{{__('Last name')}}" value="{{ucwords(strtolower($user->last_name))}}" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mb-6">--}}
{{--                    <label class="col-lg-3 col-form-label fw-bold fs-6">--}}
{{--                        <span class="required">{{__('Contact Phone')}}</span>--}}
{{--                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="{{__('Phone number must be active')}}" aria-label="{{__('Phone number must be active')}}"></i>--}}
{{--                    </label>--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <div class="input-group input-group-solid">--}}
{{--                          <span class="input-group-prepend">--}}
{{--                            <span class="input-group-text">+{{$user->getCountry()->phonecode}}</span>--}}
{{--                          </span>--}}
{{--                            <input type="tel" name="phone" maxlength="14" class="form-control form-control-lg form-control-solid" placeholder="{{__('Phone number - with country code')}}" value="{{str_replace('+'.$user->getCountry()->phonecode, '', $user->phone)}}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mb-6">--}}
{{--                    <label class="col-lg-3 col-form-label fw-bold fs-6">--}}
{{--                        <span class="required">{{__('Email Address')}}</span>--}}
{{--                    </label>--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="{{__('Email address')}}" value="{{$user->email}}" required>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mb-6">--}}
{{--                    <label class="col-lg-3 col-form-label fw-bold fs-6">--}}
{{--                        <span class="required">{{__('Industry')}}</span>--}}
{{--                    </label>--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <select class="form-control form-control-lg form-control-solid" id="mcc" name="mcc" required @if($user->mcc!=null)disabled @endif>--}}
{{--                            <option value="">{{__('What are your services?')}}</option>--}}
{{--                            @foreach(getMcc() as $val)--}}
{{--                                <option value="{{$val->id}}" @if($user->mcc==$val->id)selected @endif>{{$val->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mb-6">--}}
{{--                    <label class="col-lg-3 col-form-label fw-bold fs-6">--}}
{{--                        <span class="required">{{__('Password')}}</span>--}}
{{--                    </label>--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <input type="password" name="password"  class="form-control form-control-lg form-control-solid" placeholder="{{__('Password')}}" value="" required>--}}
{{--                    </div--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-footer d-flex justify-content-end py-6 px-9">--}}
{{--                <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}
    </div>
@endsection
