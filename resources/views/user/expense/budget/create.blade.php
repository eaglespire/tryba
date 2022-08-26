@extends('userlayout')

@section('content')

    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Create Budget')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('allBudget')}}" class="text-muted text-hover-primary">{{__('Budget')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Add new ')}}</li>
                </ul> 
            </div>      
        </div>
    </div>
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container">
            <div class="card">
                <div class="card-header card-header-stretch">
                    <div class="card-title d-flex align-items-center">
                        <h3 class="fw-bolder m-0 text-dark">{{__('New Budget')}}</h3>
                    </div>
                </div>

                <form action="{{ route('postBudget') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="card-body px-9 pt-6 pb-4">
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Month')}}</label>
                            <div class="col-lg-12">
                              <select name="month" class="form-select form-select-solid" required>
                                    <option value="">Select month</option>
                                    @foreach($months as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Year')}}</label>
                            <div class="col-lg-12">
                              <select name="year" class="form-select form-select-solid" required>
                                    @foreach($years as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Category')}}</label>
                            <div class="col-lg-12">
                              <select name="category" id="category" class="form-select form-select-solid" required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->Name }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Sub Category')}}</label>
                            <div class="col-lg-12">
                              <select name="subcategory" id="subcategory" class="form-select form-select-solid" required>
                                    <option value="">Select sub category</option>
                              </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2 mt-5">{{__('Amount')}}</label>
                            <input type="number" class="form-control form-control-solid" placeholder="{{__('Amount')}}" value="{{ (old('price')) ? old('price') : "" }}" name="amount" required>
                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-12">
                                <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                                <input type="hidden" id="quill_html" name="description" value="{{ (old('description')) ? old('description') : "" }}">
                                <div data-toggle="quill" data-quill-placeholder="{{__('Describe your budget')}}">{!! (old('description')) ? old('description') : "" !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary px-6">{{__('Create Budget')}}</button>
                    </div>
                </form>
             </div>
        </div>
   
    </div>
@endsection

@section('script')
<script>
       let CategoryDropdown = document.querySelector('#category')
    CategoryDropdown.addEventListener('change',() => {
        fetch("{{ route('AllSubCategoryExpenseApi') }}", {
            method: 'POST',
            headers: {
                'content-type': 'application/json'
            },
            body: JSON.stringify({
                id: CategoryDropdown.value,
                _token: "{{ csrf_token() }}",
            })
        })
        .then(response => response.json())
        .then(data => {
           let options = data 
           let SubCategoryDropdown = document.querySelector('#subcategory')
           SubCategoryDropdown.innerHTML = ""
           let newOption = new Option("Select sub category","");
            SubCategoryDropdown.add(newOption,undefined);
            options.forEach(item => {
                let newOption = new Option(item.Name,item.id);
                SubCategoryDropdown.add(newOption,undefined);
            })
        })

    });
</script>
@endsection
