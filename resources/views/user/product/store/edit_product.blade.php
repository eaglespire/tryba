@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <!--begin::Title-->
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Edit Product')}}</h1>
      <!--end::Title-->
      <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
        </li>
        <li class="breadcrumb-item text-muted">
          <a href="{{route('user.product')}}" class="text-muted text-hover-primary">{{__('Product')}}</a>
        </li>
        <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      <a href="{{route('new.product')}}" class="btn btn-dark btn-active-light me-4"><i class="fal fa-cart-plus"></i> {{__('Add a new product')}}</a>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="row g-xl-8">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
            <div class="card-title flex-column">
              <h3 class="fw-bolder m-0 text-dark">{{__('Product')}}</h3>
            </div>
            <div class="card-toolbar">
              <a target="_blank" href="{{route('sproduct.link', ['id'=>$user->storefront()->store_url,'product'=>$product->ref_id])}}" class="btn btn-info btn-color-light btn-sm">{{__('Preview')}}</a>
            </div>
          </div>
          <form action="{{route('product.feature.submit')}}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" value="{{$product->id}}" name="id">
            <div class="card-body px-9 pt-6 pb-4">
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Name')}}</label>
                <div class="col-lg-12">
                  <input type="text" name="name" placeholder="The name of your product" value="{{$product->name}}" required class="form-control form-control-solid mb-3 mb-lg-0">
                </div>
              </div>
              <div class="row mb-20">
                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Description')}}</label>
                <div class="col-lg-12">
                  <input type="hidden" id="quill_html" name="description" value="{{$product->description}}">
                  <div data-toggle="quill" data-quill-placeholder="{{__('Describe your product')}}">{!!$product->description!!}</div>
                </div>
              </div>              
              <div class="row mb-20">
                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Specification')}}</label>
                <div class="col-lg-12">
                  <input type="hidden" id="quill_html1" name="specification" value="{{$product->specification}}">
                  <div data-toggle="quill1" data-quill-placeholder="{{__('Product specification')}}">{!!$product->specification!!}</div>
                </div>
              </div>              
              <div class="row mb-20">
                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Details')}}</label>
                <div class="col-lg-12">
                  <input type="hidden" id="quill_html2" name="details" value="{{$product->details}}">
                  <div data-toggle="quill2" data-quill-placeholder="{{__('More details about your product')}}">{!!$product->details!!}</div>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Category')}}</label>
                <div class="col-lg-12">
                  <select name="cat_id" class="form-select form-select-solid" required>
                    <option value="">Select a product category</option>
                    @foreach($category as $val)
                    <option value="{{$val->id}}" @if($val->id==$product->cat_id) selected @endif>{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Amount')}}</label>
                <div class="col-lg-12">
                  <div class="input-group input-group-solid">
                    <span class="input-group-prepend">
                      <span class="input-group-text">{{$currency->symbol}}</span>
                    </span>
                    <input type="number" step="any" autocomplete="off" class="form-control form-control-solid" value="{{$product->amount}}" name="amount" placeholder="{{__('How much?')}}" required>
                  </div>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Discount')}}</label>
                <div class="col-lg-12">
                  <div class="input-group input-group-solid">
                    <input type="number" step="any" autocomplete="off" class="form-control form-control-solid" value="{{$product->discount}}" name="discount" placeholder="{{__('Discount')}}">
                    <span class="input-group-prepend">
                      <span class="input-group-text">%</span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Quantity')}}</label>
                <div class="col-lg-12">
                  <input type="number" autocomplete="off" value="{{$product->quantity}}" class="form-control form-control-solid" name="quantity" min="1" required>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Tags')}}</label>
                <div class="col-lg-12">
                  <input type="text" id="kt_tagify_2" value="{{$product->tags}}" class="form-control form-control-solid" name="tags">
                </div>
                <div class="form-text">{{__('Tags help makes your product easy to find. Please enter a comma after each tag')}}</div>
              </div>
              <label class="col-form-label fw-bold fs-6">{{__('Product Image')}}</label>
              <div class="row mb-6">
                @foreach($images as $k=>$val)
                <div class="col-md-2 imgUp">
                  <div class="imagePreview mb-6" style="background:url('{{asset('asset/profile/'.$val->image)}}');background-repeat:no-repeat;background-size:cover;">
                    @if(!$loop->first)<span class="me-4 btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow del" title="Remove Image"><i class="fal fa-times fs-2"></i></span>@endif
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow">
                      <i class="bi bi-pencil-fill fs-7"></i>
                      <input type="file" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" name="old[]" accept=".png, .jpg, .jpeg">
                      <input type="hidden" name="pid[]" value="{{$val->id}}">
                      <input type="hidden" id="changed" name="changed[]" value="0">
                    </label>
                  </div>
                </div>
                @endforeach
                <span class="imgAdd btn btn-block btn-light-info" title="Add Image">
                  <i class="fal fa-plus"></i> Add another image
                </span>
              </div>
              <div class="row mb-6">
                <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Visible')}}</label>
                <div class="col-lg-9">
                  <select name="status" class="form-select form-select-solid" required>
                    <option value='0' @if($product->status==0) selected @endif>No</option>
                    <option value='1' @if($product->status==1) selected @endif>Yes</option>
                  </select>
                </div>
              </div>              
              <div class="row mb-6">
                <label class="col-lg-3 col-form-label required fw-bold fs-6">{{__('Featured')}}</label>
                <div class="col-lg-9">
                  <select name="featured" class="form-select form-select-solid" required>
                    <option value='0' @if($product->featured==0) selected @endif>No</option>
                    <option value='1' @if($product->featured==1) selected @endif>Yes</option>
                  </select>
                </div>
              </div>
              <p>Product extra properties</p>
              <div class="row mb-6">
                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Size')}}</label>
                <div class="col-lg-9">
                  <input type="text" id="kt_tagify_size" value="{{$product->size}}" class="form-control form-control-solid" name="size">
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Length')}}</label>
                <div class="col-lg-9">
                  <div class="input-group input-group-solid">
                    <input type="text" id="kt_tagify_length" value="{{$product->length}}" class="form-control form-control-solid" name="length">
                    <span class="input-group-append">
                      <select class="form-select form-select-solid" name="length_unit">
                        <option value="inch" @if($product->length_unit=="inch")selected @endif>inch</option>
                        <option value="ft" @if($product->length_unit=="ft")selected @endif>ft</option>
                        <option value="yd" @if($product->length_unit=="yd")selected @endif>yd</option>
                        <option value="ml" @if($product->length_unit=="ml")selected @endif>ml</option>
                        <option value="cm" @if($product->length_unit=="cm")selected @endif>cm</option>
                        <option value="m" @if($product->length_unit=="m")selected @endif>m</option>
                      </select>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-lg-3 col-form-label fw-bold fs-6">{{__('Weight')}}</label>
                <div class="col-lg-9">
                  <div class="input-group input-group-solid">
                    <input type="text" id="kt_tagify_weight" value="{{$product->weight}}" class="form-control form-control-solid" name="weight">
                    <span class="input-group-append">
                      <select class="form-select form-select-solid" name="weight_unit">
                        <option value="g" @if($product->weight_unit=="g")selected @endif>g</option>
                        <option value="kg" @if($product->weight_unit=="kg")selected @endif>kg</option>
                      </select>
                    </span>
                  </div>
                </div>
              </div>
              <div class="field_wrapper">
                <div class="row">
                  <label class="col-lg-12 col-form-label fw-bold fs-6">{{__('Color')}}</label>
                  @if($product->color!=null)
                  @foreach(json_decode($product->color) as $key=>$val)
                  <div class="row mb-6">
                    <div class="col-11">
                      <input type="color" value="{{$val}}" class="form-control form-control-solid " name="color[]">
                    </div>
                    <div class="col-1">
                      <a href="javascript:void(0);" class="remove_buttonx text-danger" title="Remove field">
                        <i class="fal fa-times"></i>
                      </a>
                    </div>
                  </div>
                  @endforeach
                  @endif
                </div>
              </div>
              <a href="javascript:void(0);" class="add_button btn btn-block btn-light-info" title="Add field">{{__('Add a new color')}}</a>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('script')
<script>
    var ff=@php echo count($images); @endphp;
    var maxField = 6-ff;
    var x = 0;
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
                    uploadFile.closest(".imgUp").find('#changed').val(1);
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
    $(wrapper).on('click', '.remove_buttonx', function(e) {
      e.preventDefault();
      $(this).parent('div').parent('div').remove(); //Remove field html
    });
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
  var inputcolor = document.querySelector("#kt_tagify_color");
  new Tagify(inputcolor);
  var inputlength = document.querySelector("#kt_tagify_length");
  new Tagify(inputlength);
  var inputweight = document.querySelector("#kt_tagify_weight");
  new Tagify(inputweight);
</script>
@endsection