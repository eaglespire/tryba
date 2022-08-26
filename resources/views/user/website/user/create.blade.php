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
                <li class="breadcrumb-item text-dark">{{__('Create website')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('New Website')}}</h3>
                </div>
            </div>
            <form action="{{route('post.website')}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Title')}}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{__('The name of your website')}}" name="name" required>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                        <textarea class="form-control form-control-solid" rows="5" name="description" type="text" placeholder="{{__('Website Description')}}" required></textarea>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-bold mb-2">{{__('Website link')}}</label>
                        <div class="input-group input-group-solid">
                            <span class="input-group-prepend">
                                <span class="input-group-text">{{url('/')}}/website/</span>
                            </span>
                            <input type="text" step="any" required class="form-control form-control-solid slug_input" name="url" placeholder="slug">
                        </div>
                    </div>
                    <div class="loader" style="display: none;"><span class="spinner-border spinner-border-sm mb-2"></span></div>
                    <p class="text-danger fs-14 mt-0 mb-2" id="name_exist" style="display: none;"><i class="fal fa-ban"></i> Slug is already taken, try another one.</p>
                    <p class="text-success fs-14 mt-0 mb-2" id="name_available" style="display: none;"><i class="fal fa-check-circle"></i> Slug is available.</p>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" disabled="disabled" class="btn btn-primary px-6 register_button">{{__('Create Website')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
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