@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Generate Report')}}</h1>
      <ul class="breadcrumb fw-bold fs-base my-1">
          <li class="breadcrumb-item text-muted">
              <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
          </li>            
            <li class="breadcrumb-item text-muted">
              <a href="{{route('expense.dashboard')}}" class="text-muted text-hover-primary">{{__('Expenses Manager')}}</a>
          </li>
          <li class="breadcrumb-item text-dark">{{__('Generate Report')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="card">
      <div class="card-header card-header-stretch">
        <div class="card-title d-flex align-items-center">
          <h3 class="fw-bolder m-0 text-dark">{{__('Generate Report')}}</h3>
        </div>
      </div>
      <form action="{{route('postReport')}}" method="post">
        @csrf
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row mb-6">
            <div class="col-lg-12">
              <select class="form-select form-select-solid" name="type" required>
                <option value="">Select Report type</option>
                <option value="expense">Expense</option>
                <option value="income">Income</option>
                <option value="expensevsincome">Expense VS Income</option>
              </select>
            </div>
          </div>
          <div class="row mb-6">
            <div class="col-lg-12">
              <div class="input-group input-group-solid">
                <input type="text" class="form-control form-control-solid" name="startDate" required>
                <span class="input-group-prepend">
                  <span class="input-group-text text-xs text-dark">{{__('Start date')}}</span>
                </span>
              </div>
            </div>        
          </div> 
          <div class="row mb-6">
            <div class="col-lg-12">
              <div class="input-group input-group-solid">
                <input type="text" class="form-control form-control-solid" name="endDate" required>
                <span class="input-group-prepend">
                  <span class="input-group-text text-xs text-dark">{{__('End date')}}</span>
                </span>
              </div>
            </div>        
          </div> 
          <div class="row mb-6">
            <div class="col-lg-12">
              <select name="category" id="category" class="form-select form-select-solid" required>
                    <option value="">Select category</option>
                    <option value="all">All Categories</option>
                    @foreach($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->Name }}</option>
                    @endforeach
              </select>
            </div>
        </div>
        <div class="row mb-6">
            <div class="col-lg-12">
              <select name="subcategory" id="subcategory" class="form-select form-select-solid" required>
                    <option value="">Select sub category</option>
              </select>
            </div>
        </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <button type="submit" class="btn btn-primary px-6">{{__('Generate Report')}}</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
  $(function() {
      $('input[name="startDate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
    });

    $(function() {
      $('input[name="endDate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
    });
    
    let CategoryDropdown = document.querySelector('#category')
    CategoryDropdown.addEventListener('change',() => {
    let SubCategoryDropdown = document.querySelector('#subcategory')
        if(CategoryDropdown.value == 'all'){
          SubCategoryDropdown.classList.add('d-none')
          SubCategoryDropdown.innerHTML = "";
          SubCategoryDropdown.removeAttribute('required');
        }else{
          if(SubCategoryDropdown.classList.contains('d-none')){
            SubCategoryDropdown.classList.remove('d-none');
            SubCategoryDropdown.setAttribute('required',true);
          }
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
            SubCategoryDropdown.innerHTML = ""
            let newOption = new Option("Select sub category","");
              SubCategoryDropdown.add(newOption,undefined);
              options.forEach(item => {
                  let newOption = new Option(item.Name,item.id);
                  SubCategoryDropdown.add(newOption,undefined);
              })
          })
        }

    });
</script>
@endsection