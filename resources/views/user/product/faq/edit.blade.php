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
                    <a href="{{route('website.faq')}}" class="text-muted text-hover-primary">{{__('Faq')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
                <div class="card-title flex-column">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Edit Question')}}</h3>
                </div>
            </div>
            <form action="{{route('update.faq.store', ['id'=>$val->id])}}" method="post">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row mb-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6 required">{{__('Question')}}</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-solid" value="{{$val->question}}" placeholder="{{__('Question')}}" name="question" required>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-bold mb-2">{{__('Category')}}</label>
                        <select name="cat_id" class="form-select form-select-solid" required>
                            <option value="">{{__('Select a catgory')}}</option>
                            @foreach(getStoreFaqCat($user->storefront()->id) as $cat)
                            <option value="{{$cat->id}}" @if($cat->id==$val->cat_id) selected @endif>{{$cat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-20">
                        <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Question')}}</label>
                        <div class="col-lg-12">
                            <textarea type="text" rows="4" class="form-control form-control-solid" name="answer" required>{{$val->answer}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary px-6">{{__('Save Changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>

</script>
@endsection