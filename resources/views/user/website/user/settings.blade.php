@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="card mb-6">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Settings')}}</h3>
                </div>
            </div>
            <form action="{{route('website.update')}}" method="post" enctype="multipart/form-data">
                <div class="card-body px-9 pt-6 pb-4">
                    @csrf
                    @method('put')
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Website Title')}}</label>
                        <input type="text" class="form-control form-control-solid" value="{{ $user->website->websiteName }}" placeholder="{{__('The name of your store')}}" name="name" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Website Description')}}</label>
                        <textarea class="form-control form-control-solid" rows="5" name="description" type="text" placeholder="{{__('Description')}}" required>{{ $user->website->meta_description }}</textarea>
                    </div>
                    <div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-bold mb-2">{{__('Website link')}}</label>
                            <div class="input-group input-group-solid">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{url('/')}}/website/</span>
                                </span>
                                <input type="text" step="any" value="{{ $user->website->websiteUrl  }}" required class="form-control form-control-solid slug_input" name="url" placeholder="slug">
                            </div>
                        </div>
                        <div class="loader" style="display: none;"><span class="spinner-border spinner-border-sm mb-2"></span></div>
                        <p class="text-danger fs-14 mt-0 mb-2" id="name_exist" style="display: none;"><i class="fal fa-ban"></i> Slug is already taken, try another one.</p>
                        <p class="text-success fs-14 mt-0 mb-2" id="name_available" style="display: none;"><i class="fal fa-check-circle"></i> Slug is available.</p>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Maintenance Mode')}}</label>
                        <div class="col-lg-12">
                            <select name="status" class="form-select form-select-solid" required>
                                <option value='0' @if($user->website->status == 0) selected @endif>{{__('Under maintenance')}}</option>
                                <option value='1' @if($user->website->status == 1) selected @endif>{{__('Website is active')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-lg-12">
                            <div class="form-check form-check-solid mb-6">
                                <input name="checkout_logo" class="form-check-input" type="checkbox" id="customCheckLoging7" value="1" @if($user->checkout_logo == 1)checked @endif>
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customCheckLoging7">{{__('Show Logo')}}</label>
                            </div>
                            <div class="form-check form-check-solid mb-6">
                                <input name="display_blog" class="form-check-input" type="checkbox" id="customBlog" value="1" @if($user->website->display_blog==1)checked @endif>
                                <label class="form-check-label fw-bold ps-2 fs-6" for="customBlog">{{__('Display blog')}}</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="fw-bold fs-6">{{__('Website logo - Default Tryba logo will be used if not provided')}}</p>
                            <div class="image-input image-input-outline mb-5" data-kt-image-input="true" style="background-image: url({{ ($user->website->logo_url) ?  $user->website->logo_url : ""  }})">
                                <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{ ($user->website->logo_url) ?  $user->website->logo_url : "" }})"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-50px h-50px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change image">
                                            <i class="fal fa-image fs-1 text-dark"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Website Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Website Image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fw-bolder mb-6 text-dark">{{__('SEO (Search engine optimization)')}}</h4>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2">{{__('Meta Keywords')}}</label>
                            <input type="text" id="meta_keywords" class="form-control form-control-solid" value="{{ $user->website->meta_keyword }}" placeholder="{{__('Meta keywords')}}" name="meta_keywords">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
        <div class="card px-6">
            <form action="{{route('booking.configuration')}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="card-header p-6 align-items-center">
                    <h3 class="fw-boldest text-dark fs-6x">{{__('Booking Configuration')}}</h3>
                </div>
                <div class="card-body">
                <div class="d-flex flex-column fv-row fv-plugins-icon-container mb-5">
                    <label class="fs-5 fw-bold mb-2">{{__('How do you render service?')}}</label>
                    <select name="serviceType" class="form-select form-select-solid" required>
                        <option value="0" @if($user->website->bookingConfiguration->serviceType == 0) selected @endif>{{__('One customer per booking')}}</option>
                        <option value="1" @if($user->website->bookingConfiguration->serviceType == 1) selected @endif>{{__('More than one customer per booking')}}</option>
                    </select>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Where do you render service?')}}</label>
                    <select id="service_type" name="whereServiceRendered" class="form-select form-select-solid" required>
                        <option value="0" @if($user->website->bookingConfiguration->whereServiceRendered == 0) selected @endif>{{__('Customer home address')}}</option>
                        <option value="1" @if($user->website->bookingConfiguration->whereServiceRendered == 1) selected @endif>{{__('I have a physical location where I receive customers')}}</option>
                    </select>
                </div>
                <div id="store" class="mb-6" @if($user->website->bookingConfiguration->whereServiceRendered  == 1) style="display:none;" @endif>
                    @if($user->website->bookingConfiguration->whereServiceRendered  == 1)
                        <div class="row mb-6">
                            <label class="col-lg-3 col-form-label fw-bold fs-6">
                                <span class="required">{{__('County')}}</span>
                            </label>
                            <div class="col-lg-9">
                                <select class="form-control form-control-lg form-control-solid" data-control="select2" id="county" name="county" required>
                                    <option value="">Select County</option>
                                    @foreach(getInvoiceState($user->getCountry()->iso) as $val)
                                        <option value="{{$val->id}}" @if($user->website->bookingConfiguration->county == $val->id) selected @endif>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                    <div class="row mb-6">
                        <label class="col-lg-3 col-form-label fw-bold fs-6">
                            <span class="required">{{__('County')}}</span>
                        </label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-lg form-control-solid" data-control="select2" id="county" name="county" required>
                                <option value="">Select County</option>
                                @foreach(getInvoiceState($user->getCountry()->iso) as $val)
                                    <option value="{{$val->id}}"  @if($user->website->bookingConfiguration->county == $val->id)== $val->id) selected @endif>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-6">
                        <label class="col-lg-3 col-form-label fw-bold fs-6">
                            <span class="required">{{__('City')}}</span>
                        </label>
                        <div class="col-lg-9">
                            <input type="text" id="city" name="city" value="{{ $user->website->bookingConfiguration->city  }}" class="form-control form-control-lg form-control-solid" placeholder="City">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Line 1')}}</label>
                        <div class="col-lg-9">
                            <input type="text" id="line_1" name="line" value="{{ $user->website->bookingConfiguration->line  }}" class="form-control form-control-lg form-control-solid" placeholder="Line 1">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="required col-lg-3 col-form-label fw-bold fs-6">{{__('Post Code')}}</label>
                        <div class="col-lg-9">
                            <input type="text" id="postal_code" name="postcode" value="{{ $user->website->bookingConfiguration->postCode }}" class="form-control form-control-lg form-control-solid" placeholder="Zip/Postal code">
                        </div>
                    </div>
                    <div class="form-text">{{__('Location will be displayed on your website')}}</div>
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Daily limit')}}</label>
                    <input type="number" class="form-control form-control-solid" value="{{ $user->website->bookingConfiguration->dailyLimit }}" placeholder="{{__('The maximum amount of bookings per day, leave this empty if you need no limit')}}" name="dailyLimit">
                </div>
                <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                    <label class="fs-5 fw-bold mb-2">{{__('Service review')}}</label>
                    <select id="service_review" name="review" class="form-select form-select-solid" required>
                        <option value="1" @if($user->website->bookingConfiguration->collectReview == 1) selected @endif>{{__('Allow service review after completion')}}</option>
                        <option value="0" @if($user->website->bookingConfiguration->collectReview == 0) selected @endif>{{__('I don\'t need service review')}}</option>
                    </select>
                </div>
                <h4 class="fw-bolder mb-6 text-dark">{{__('Business Hours')}}</h4>
                @foreach($user->website->bookingConfiguration->businessHours as $key => $days)
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-check form-check-solid mb-6">
                                <input onchange="checkValue(event,'{{ $key.'startTime' }}','{{ $key.'endTime' }}')" name="{{ $key .'status' }}" class="form-check-input" type="checkbox" @if($days['status'] == 1) checked @endif>
                                <label class="form-check-label fw-bold text-capitalize ps-2 fs-6" for="custommon">{{ $key }}</label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="{{ $key.'startTime' }}" @if($days['status'] == 1) @else disabled @endif name="{{ $key.'startTime' }}" required>
                                    @foreach(getStartTime() as  $val)
                                    <option value="{{$val}}" @if($days['startTime'] == $val) selected @endif>{{ $val.':00' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-select form-select-solid" id="{{ $key.'endTime' }}" @if($days['status'] == 1) @else disabled @endif name="{{ $key.'endTime' }}" required>
                                    @foreach(getendTime() as $val)
                                        <option value="{{ $val }}" @if($days['endTime'] == $val) selected @endif>{{ ($val > 12) ? $val - 12 .':00' : $val .':00' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
                <h4 class="fw-bolder mb-3 text-dark">{{__('Vacation Date')}}</h4>
                <p>You won't receive any bookings during this period</p>
                <div class="row mb-6">
                    <div class="col-md-4">
                        <div class="form-check form-check-solid mb-6">
                            <input name="statusHoilday" class="form-check-input" type="checkbox" @if($user->website->bookingConfiguration->startDateNoBookings) checked @endif id="customva">
                            <label class="form-check-label fw-bold ps-2 fs-6" for="customva">{{__('Status')}}</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control form-control-solid" id="vacation" value="{{ $user->website->bookingConfiguration->startDateNoBookings .'-'. $user->website->bookingConfiguration->endDateNoBookings  }}" name="date" placeholder="Pick date rage" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
            </div>
        </div>
    </form>
    </div>
</div>
</div>
@stop
@section('script')
    <script>
        jQuery(document).ready(function($) {
            $('.clickable-row').on("click", function() {
                window.location.href = $(this).data('href');
            });
        });
    </script>
    <script>
        'use strict';
        var input2 = document.querySelector("#meta_keywords");
        new Tagify(input2);
    </script>

    <script>
        
        function checkValue(event,start,end){
            let startBox = document.querySelector(`#${start}`);
            let endBox = document.querySelector(`#${end}`);
            if(event.currentTarget.checked){
                startBox.disabled = false;
                endBox.disabled = false;
            }else{
                event.currentTarget.value = 0
                startBox.disabled = true;
                endBox.disabled = true;
            }
        }

    </script>
    <script>
    'use strict';

    function service() {
        var type = $("#service_type").find(":selected").val();
        if (type == 0) {
            $('#store').hide();
            $('#county').removeAttr('required', '');
            $('#state').removeAttr('required', '');
            $('#city').removeAttr('required', '');
            $('#line_1').removeAttr('required', '');
            $('#postal_code').removeAttr('required', '');
        } else if (type == 1) {
            $('#store').show();
            $('#state').attr('required', '');
            $('#line_1').attr('required', '');
            $('#postal_code').attr('required', '');
        }
    }
    $("#service_type").change(service);
    service();
</script>
  <script>
    (function($) {
      $(document).on('keyup', ".slug_input", function() {
        $('.loader').show();
        var valName = $(this).val();
        var url = "{{route('check.storeURL')}}";
        $.post(url, {
          url: valName,
          "_token": "{{ csrf_token() }}"
        }, function(json) {
          if (json.st == 1) {
            $('.register_button').prop('disabled', false);
            $('.loader').hide();
            $("#name_exist").slideUp();
            $("#name_available").slideDown();
          } else {
            $('.register_button').prop('disabled', true);
            $('.loader').hide();
            $("#name_available").slideUp();
            $("#name_exist").slideDown();
          }
        }, 'json');
        return false;
      });
    })(jQuery);
  </script>
@endsection

