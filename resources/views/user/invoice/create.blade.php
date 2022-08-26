@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Invoice')}}</h1>
      <ul class="breadcrumb fw-bold fs-base my-1">
          <li class="breadcrumb-item text-muted">
              <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
          </li>            
          <li class="breadcrumb-item text-muted">
              <a href="{{route('user.invoice')}}" class="text-muted text-hover-primary">{{__('Invoice')}}</a>
          </li>          
          <li class="breadcrumb-item text-dark">{{__('Create')}}</li>
      </ul>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="card">
      <div class="card-header card-header-stretch">
        <div class="card-title d-flex align-items-center">
          <h3 class="fw-bolder m-0 text-dark">{{__('New Invoice')}}</h3>
        </div>
      </div>
      <form action="{{route('submit.invoice')}}" method="post">
        @csrf
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row mb-6">
            <div class="col-lg-12">
              <select class="form-select form-select-solid" name="customer_id" required>
                <option value="">Select a customer</option>
                @foreach($customer as $val)
                  <option value="{{ $val->id }}">{{$val->first_name.' '.$val->last_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-6">
            <div class="col-lg-12">
              <div class="input-group input-group-solid">
                <input type="text" class="form-control form-control-solid" name="due_date" required>
                <span class="input-group-prepend">
                  <span class="input-group-text text-xs text-dark">{{__('Due date')}}</span>
                </span>
              </div>
            </div>        
          </div> 
          <div class="row mb-6">
            <div class="col-lg-12">
              <select class="form-select form-select-solid" id="invoice_type" name="invoice_type" required>
                <option value="">Select Invoice type</option>
                <option value="single">One-time Payment</option>
                <option value="recurring">Recurring Payment</option>
              </select>
            </div>
          </div>
          <div id="invoiceTypeContent" class="row d-none mb-6">
            <div class="col-lg-12">
              <select class="form-select form-select-solid" name="invoice_time" id="invoice_time" required>
                <option value="">Set Interval</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly (3 months)</option>
                <option value="semiannually">Semi annually (6 months)</option>
                <option value="yearly">Yearly</option>
              </select>
            </div>
          </div>
          <div class="field_wrapper">
            <div class="row">
              <div class="col-lg-3 mb-6">
                <input type="text" name="item_name[]" class="form-control form-control-solid" placeholder="Item name"  autocomplete="off" required>
              </div>
              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <span class="input-group-prepend">
                        <span class="input-group-text">{{$currency->symbol}}</span>
                      </span>
                      <input type="number" min="1" step="any" class="form-control form-control-solid" name="amount[]" autocomplete="off" placeholder="{{__('How much?')}}" min="1"required>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <input type="number" name="quantity[]" class="form-control form-control-solid" min="1"  autocomplete="off" placeholder="{{__('Quantity')}}" required>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <input type="number" name="tax[]" step="any" min="0" value="0" required class="form-control form-control-solid"  autocomplete="off" placeholder="{{__('Tax')}}">
                      <span class="input-group-append">
                        <span class="input-group-text">%</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <input type="number" name="discount[]" step="any" min="0" value="0" required class="form-control form-control-solid"  autocomplete="off" placeholder="{{__('Discount')}}">
                      <span class="input-group-append">
                          <span class="input-group-text">%</span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 mb-6">
                <textarea type="text" name="note[]" rows="1" maxlength="40" class="form-control form-control-solid" placeholder="{{__('Description')}}" required></textarea>
              </div>
            </div>
          </div>
          <a href="javascript:void(0);" class="add_button btn btn-block btn-light-info" title="Add field">{{__('Add a new item')}}</a>                                              
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
  $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = `<div>
                      <div class="row">
                        <div class="col-lg-3 mb-6">
                          <input type="text" name="item_name[]"  autocomplete="off" class="form-control form-control-solid" placeholder="Item name" required>
                        </div>
                        <div class="col-lg-9">
                          <div class="row">
                            <div class="col-lg-3 mb-6">
                              <div class="input-group input-group-solid">
                                <span class="input-group-prepend">
                                  <span class="input-group-text">{{$currency->symbol}}</span>
                                </span>
                                <input type="number" min="1"  step="any" class="form-control form-control-solid" name="amount[]"  autocomplete="off" placeholder="How much?" min="1"required>
                                </div>
                                  </div>
                                    <div class="col-lg-3 mb-6">
                                      <input type="number" min="1" name="quantity[]"  autocomplete="off" class="form-control form-control-solid" min="1" placeholder="Quantity" required>
                                    </div>
                                    <div class="col-lg-3 mb-6">
                                      <div class="input-group input-group-solid">
                                        <input type="number" name="tax[]"  autocomplete="off" step="any" min="0" value="0" required class="form-control form-control-solid" placeholder="Tax">
                                        <span class="input-group-append">
                                          <span class="input-group-text">%</span>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="col-lg-3">
                                      <div class="input-group input-group-solid">
                                        <input type="number" name="discount[]" min="0" value="0" required autocomplete="off" step="any" class="form-control form-control-solid" placeholder="Discount">
                                        <span class="input-group-append">
                                          <span class="input-group-text">%</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <div class="row my-6">
                              <div class="col-lg-12">
                                <textarea type="text" rows="1" maxlength="40" name="note[]"  autocomplete="off" class="form-control form-control-solid" placeholder="Description" required></textarea>
                              </div>
                            </div><a href="javascript:void(0);" class="remove_button btn btn-block btn-light-danger mb-6" title="Remove field">Remove Item</a></div>`; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

  let invoiceType = document.querySelector('#invoice_type')
  let invoiceContent = document.querySelector('#invoiceTypeContent');
  let invoiceTime  = document.querySelector('#invoice_time');

  invoiceType.addEventListener('change',() => {
    if(invoiceType.value == 'recurring'){
      if(invoiceContent.classList.contains('d-none')){
        invoiceContent.classList.remove('d-none');
        invoiceTime.setAttribute('required',true);
      }
    }else{
        invoiceContent.classList.add('d-none');
        invoiceTime.removeAttribute('required');
    }

      
  });
</script>
@endsection