@extends('userlayout')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Update Income')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expense Manager')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('allIncome')}}" class="text-muted text-hover-primary">{{__('Income')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Update')}}</li>
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
                        <h3 class="fw-bolder m-0 text-dark">{{__('Update Income')}}</h3>
                    </div>
                </div>

                <form action="{{ route('putIncome',$income->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('put')
                    <div class="card-body px-9 pt-6 pb-4">
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2">{{__('Name')}}</label>
                            <input type="text" class="form-control form-control-solid" placeholder="{{__('Name of income')}}" value="{{ (old('name')) ? old('name') : $income->name }}" name="name" required>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Category')}}</label>
                            <div class="col-lg-12">
                              <select name="category" id="category" class="form-select form-select-solid" required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $item)
                                        <option @if($income->categoryID == $item->id) selected @endif value="{{ $item->id }}">{{ $item->Name }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label required fw-bold fs-6">{{__('Sub Category')}}</label>
                            <div class="col-lg-12">
                              <select name="subcategory" id="subcategory" class="form-select form-select-solid" required>
                                    <option value="">Select sub category</option>
                                    @foreach($subcategories as $item)
                                        <option @if($income->subcategoryID == $item->id) selected @endif value="{{ $item->id }}">{{ $item->Name }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2 mt-5">{{__('Amount')}}</label>
                            <input type="number" class="form-control form-control-solid" placeholder="{{__('Amount')}}" value="{{ (old('amount')) ? old('amount') : $income->amount }}" name="amount" required>
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2 mt-5">{{__('Date')}}</label>
                            <input type="text" class="form-control  form-control-solid" placeholder="{{__('Date')}}" value="{{ (old('singleDate')) ? old('singleDate') : $income->date }}"  name="singleDate" required>
                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-12">
                                <label class="required fs-5 fw-bold mb-2">{{__('Description')}}</label>
                                <input type="hidden" id="quill_html" name="description" value="{{ (old('description')) ? old('description') : $income->description }}">
                                <div data-toggle="quill" data-quill-placeholder="{{__('Describe your income')}}">{!! (old('description')) ? old('description') : $income->description !!}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-bold mb-2 mt-5">{{__('Attach Invoice')}}</label>
                            <input type="file" name="file" class="form-control form-control-solid" placeholder="{{__('Attach Invoice')}}" >
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-primary px-6">{{__('Update Income')}}</button>
                    </div>
                </form>
             </div>
        </div>
   
    </div>
@endsection

@section('script')

<script>
    $(function() {
      $('input[name="singleDate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
    });


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