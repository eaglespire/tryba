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
                    <a href="{{route('user.product')}}" class="text-muted text-hover-primary">{{__('Product')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        @if(count($user->shipping())==0)
        <div class="notice d-flex bg-light-warning rounded border border-warning rounded p-6 mb-8">
            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
                    <rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
                </svg>
            </span>
            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                <div class="mb-3 mb-md-0 fw-bold">
                    <h4 class="text-gray-800 fw-bolder">{{__('Setup shipping rates & regions')}}</h4>
                    <div class="fs-6 text-dark pe-7">{{__('You\'re yet to add a region and shipping rate')}}</div>
                </div>
                <a href="{{route('user.shipping')}}" class="btn btn-warning px-6 align-self-center text-nowrap">{{__('Setup')}}</a>
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Product')}}</h3>
                </div>
            </div>
            <form action="{{route('submit.product')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('The name of your product')}}" value="@if(session('name')){{session('name')}}@endif" name="name" required>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <input type="hidden" id="quill_html" name="description" value="@if(session('description')){{session('description')}}@endif">
                            <div data-toggle="quill" data-quill-placeholder="{{__('Describe your product')}}">@if(session('description')){!!session('description')!!}@endif</div>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <input type="hidden" id="quill_html1" name="specification" value="@if(session('specification')){{session('specification')}}@endif">
                            <div data-toggle="quill1" data-quill-placeholder="{{__('Product specification')}}">@if(session('specification')){!!session('specification')!!}@endif</div>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <input type="hidden" id="quill_html2" name="details" value="@if(session('details')){{session('details')}}@endif">
                            <div data-toggle="quill2" data-quill-placeholder="{{__('More details about your product')}}">@if(session('details')){!!session('details')!!}@endif</div>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Category')}}</label>
                        <select name="category" class="form-select form-select-solid" required>
                            @foreach(getProductCategory() as $val)
                            <option value="{{$val->id}}" @if(session('category')==$val->id) selected @endif>{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2 required">{{__('Amount')}}</label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                                <span class="input-group-text">{{$currency->symbol}}</span>
                            </span>
                            <input type="number" step="any" autocomplete="off" class="form-control form-control-solid" name="amount" min="1" value="@if(session('amount')){{session('amount')}}@endif" placeholder="{{__('How much?')}}">
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2 required">{{__('Quantity')}}</label>
                        <input type="number" autocomplete="off" class="form-control form-control-solid" value="@if(session('quantity')){{session('quantity')}}@endif" name="quantity" min="1" required>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Discount')}}</label>
                        <div class="col-lg-12">
                            <div class="input-group input-group-solid">
                                <input type="number" step="any" autocomplete="off" class="form-control form-control-solid" value="@if(session('discount')){{session('discount')}}@endif" name="discount" placeholder="{{__('Discount')}}">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Tags')}}</label>
                        <div class="col-lg-12">
                            <input type="text" id="kt_tagify_2" value="@if(session('tags')){{session('tags')}}@endif" class="form-control form-control-solid" name="tags">
                        </div>
                        <div class="form-text">{{__('Tags help makes your product easy to find. Please enter a comma after each tag')}}</div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Featured')}}</label>
                        <div class="col-lg-9">
                            <select name="featured" class="form-select form-select-solid" required>
                                <option value='0'>No</option>
                                <option value='1'>Yes</option>
                            </select>
                        </div>
                    </div>
                    <label class="col-form-label fw-bold fs-6">{{__('Product Image')}}</label>
                    <div class="row mb-6">
                        <div class="col-md-2 imgUp">
                            <div class="imagePreview mb-6" style="background:url('{{asset('asset/images/product-placeholder.jpg')}}');">
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="images[]" accept=".png, .jpg, .jpeg" required>
                                </label>
                            </div>
                        </div>
                        <span class="imgAdd btn btn-block btn-light-info" title="Add Image">
                            <i class="fal fa-plus"></i> Add another image
                        </span>
                    </div>
                    <div class="accordion accordion-icon-toggle mb-8" id="kt_accordion_1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_1_header_2">
                                <button class="accordion-button fs-5 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="true" aria-controls="kt_accordion_1_body_2">
                                    {{__('Advanced options')}}
                                </button>
                            </h2>
                            <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                                <div class="accordion-body">
                                    <div class="row mb-6">
                                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Size')}}</label>
                                        <div class="col-lg-12">
                                            <input type="text" id="kt_tagify_size" value="@if(session('size')){{session('size')}}@endif" class="form-control form-control-solid" name="size">
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Length')}}</label>
                                        <div class="col-lg-12">
                                            <div class="input-group input-group-solid">
                                                <input type="text" id="kt_tagify_length" value="@if(session('length')){{session('length')}}@endif" class="form-control form-control-solid" name="length">
                                                <span class="input-group-append">
                                                    <select class="form-select form-select-solid" name="length_unit" required>
                                                        <option value="inch" @if(session('length_unit')=="inch" ) selected @endif>inch</option>
                                                        <option value="ft" @if(session('length_unit')=="ft" ) selected @endif>Feet</option>
                                                        <option value="yd" @if(session('length_unit')=="yd" ) selected @endif>yd</option>
                                                        <option value="ml" @if(session('length_unit')=="ml" ) selected @endif>ml</option>
                                                        <option value="cm" @if(session('length_unit')=="cm" ) selected @endif>cm</option>
                                                        <option value="m" @if(session('length_unit')=="m" ) selected @endif>m</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Weight')}}</label>
                                        <div class="col-lg-12">
                                            <div class="input-group input-group-solid">
                                                <input type="text" id="kt_tagify_weight" value="@if(session('weight')){{session('weight')}}@endif" class="form-control form-control-solid" name="weight">
                                                <span class="input-group-append">
                                                    <select class="form-select form-select-solid" name="weight_unit" required>
                                                        <option value="g" @if(session('weight_unit')=="g" ) selected @endif>g</option>
                                                        <option value="kg" @if(session('weight_unit')=="kg" ) selected @endif>kg</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field_wrapper">
                                        <div class="row mb-6">
                                            <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Color')}}</label>
                                            <div class="col-lg-12">
                                                <input type="color" value="@if(session('color')){{session('color')}}@endif" class="form-control form-control-solid " name="color[]">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="add_button btn btn-block btn-light-info" title="Add field">{{__('Add a new color')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" @if(count($user->shipping())==0) disabled @endif class="btn btn-primary px-6">{{__('Create Product')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>
    var maxField = 6;
    var x = 1;
    $(".imgAdd").click(function() {
        if (x < maxField) {
            x++;
            $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview mb-6"><span class="me-4 btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow del" title="Remove Image"><i class="fal fa-times fs-2"></i></span><label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"><i class="bi bi-pencil-fill fs-7"></i><input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="images[]" accept=".png, .jpg, .jpeg" required></label></div></div>');
        }
    });
    $(document).on("click", ".del", function() {
        $(this).parent().parent().remove();
        x--;
    });
    $(function() {
        $(document).on("change", ".uploadFile", function() {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                }
            }

        });
    });
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div class="row mb-6"><div class="col-lg-11"><input type="color" value="@if(session("color")){{session("color")}}@endif" class="form-control form-control-solid" name="color[]"></div><div class="col-lg-1"><a href="javascript:void(0);" class="remove_button text-danger" title="Remove field"><i class="fal fa-times"></i></a></div></div></div>'; //New input field html 
        var d = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (d < maxField) {
                d++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
            d--; //Decrement field counter
        });
    });
    'use strict';
    var input2 = document.querySelector("#kt_tagify_2");
    new Tagify(input2);
    var inputsize = document.querySelector("#kt_tagify_size");
    new Tagify(inputsize);
    var inputlength = document.querySelector("#kt_tagify_length");
    new Tagify(inputlength);
    var inputweight = document.querySelector("#kt_tagify_weight");
    new Tagify(inputweight);
</script>
@endsection
@php
Session::forget('name');
Session::forget('description');
Session::forget('quantity');
Session::forget('cat_id');
Session::forget('amount');
Session::forget('tags');
Session::forget('size');
Session::forget('color');
Session::forget('length');
Session::forget('weight');
Session::forget('length_unit');
Session::forget('weight_unit');
Session::forget('discount');
@endphp