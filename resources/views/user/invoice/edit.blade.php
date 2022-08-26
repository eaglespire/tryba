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
        <li class="breadcrumb-item text-dark">{{__('Edit')}}</li>
      </ul>
    </div>
    <div class="d-flex py-2">
      <a href="{{ route('user.add-invoice') }}" class="btn btn-dark">{{__('New Invoice')}}</a>
    </div>
  </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
  <div class="container">
    <div class="card">
      <div class="card-header py-5 py-md-0 py-lg-5 py-xxl-0">
        <div class="card-title flex-column">
          <h3 class="fw-bolder m-0 text-dark">{{__('Edit Invoice')}}</h3>
        </div>
        <div class="card-toolbar">
          <a href="{{route('preview.invoice', ['id' => $invoice->ref_id])}}" class="btn btn-info btn-color-light btn-sm">{{__('Preview')}}</a>
        </div>
      </div>
      <form action="{{route('update.invoice')}}" method="post">
        @csrf
        @method('put')
        <div class="card-body px-9 pt-6 pb-4">
          <div class="row">
            <div class="col-lg-12 mb-6">
              <select class="form-select form-select-solid" name="customer_id" required>
                <option value="">{{__('Select a customer')}}</option>
                @foreach($customer as $val)
                  <option value="{{$val->id}}" @if($invoice->customer_id == $val->id) selected @endif> {{ $val->first_name.' '.$val->last_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 mb-6">
              <div class="input-group input-group-solid">
                <input type="text" class="form-control form-control-solid" value="{{ $invoice->due_date }}" name="due_date" required>
                <span class="input-group-prepend">
                  <span class="input-group-text text-xs text-dark">{{__('Due date')}}</span>
                </span>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <div class="col-lg-12">
              <select class="form-select form-select-solid" name="invoice_type" id="invoice_type" required>
                <option value="">Select Invoice type</option>
                <option value="single"  @if($invoice->invoice_type == "single") selected @endif>One-time Payment</option>
                <option value="recurring" @if($invoice->invoice_type == "recurring") selected @endif>Recurring Payment</option>
              </select>
            </div>
          </div>
          <div id="invoiceTypeContent" class="row @if($invoice->invoice_type !== "recurring") d-none @endif mb-6">
            <div class="col-lg-12">  
              <select class="form-select form-select-solid" name="invoice_time" id="invoice_time" required>
                <option value="">Set Interval</option>
                <option @if($invoice->hourstoNextDue == 24) selected @endif value="daily">Daily</option>
                <option @if($invoice->hourstoNextDue == 730) selected @endif value="monthly">Monthly</option>
                <option @if($invoice->hourstoNextDue == 2190) selected @endif value="quarterly">Quarterly (3 months)</option>
                <option @if($invoice->hourstoNextDue == 4380) selected @endif value="semiannually">Semi annually (6 months)</option>
                <option @if($invoice->hourstoNextDue == 8760) selected @endif value="yearly">Yearly</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="id" value="{{$invoice->id}}">
          <div class="field_wrapper">
            @foreach(json_decode($invoice->item) as $key=>$value)
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-lg-12 mb-6">
                    <input type="text" name="item_name[]" value="{{$value}}" class="form-control form-control-solid" placeholder="Item name" autocomplete="off" required>
                  </div>
                  <div class="col-lg-12 mb-6">
                    <textarea type="text" rows="1" maxlength="40" name="note[]" class="form-control form-control-solid" placeholder="Description" required>{{$notes[$key]}}</textarea>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <span class="input-group-prepend">
                        <span class="input-group-text">{{$currency->symbol}}</span>
                      </span>
                      <input type="number" min="1" step="any" value="{{$amount[$key]}}" class="form-control form-control-solid" name="amount[]" autocomplete="off" placeholder="{{__('How much?')}}" min="1" required>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <input type="number" name="quantity[]" value="{{$quantity[$key]}}" class="form-control form-control-solid" min="1" autocomplete="off" placeholder="{{__('Quantity')}}" required>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <input type="number" name="tax[]" value="{{$tax[$key]}}" step="any" class="form-control form-control-solid" autocomplete="off" min="0" required placeholder="{{__('Tax')}}">
                      <span class="input-group-append">
                        <span class="input-group-text">%</span>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-3 mb-6">
                    <div class="input-group input-group-solid">
                      <input type="number" name="discount[]" value="{{$discount[$key]}}" step="any" class="form-control form-control-solid" min="0" required autocomplete="off" placeholder="{{__('Discount')}}">
                      <span class="input-group-append">
                        <span class="input-group-text">%</span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              @if(!$loop->first)
              <div class="col-md-12">
                <a href="javascript:void(0);" class="remove_buttonx btn btn-light-danger btn-block" title="Remove field">
                  Remove Item
                </a>
              </div>
              @endif
            </div>
            <div class="row mb-6">

            </div>
            @endforeach
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
  $(document).ready(function() {
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
                            <div class="row mb-6">
                              <div class="col-lg-12">
                                <textarea type="text" rows="1" maxlength="40" name="note[]"  autocomplete="off" class="form-control form-control-solid" placeholder="Description" required></textarea>
                              </div>
                            </div><a href="javascript:void(0);" class="remove_button btn btn-block btn-light-danger mb-6" title="Remove field">Remove Item</a></div>`; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
      }
    });
    $(wrapper).on('click', '.remove_buttonx', function(e) {
      e.preventDefault();
      $(this).parent('div').parent('div').remove(); //Remove field html
    });
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
      e.preventDefault();
      $(this).parent('div').remove(); //Remove field html
      x--; //Decrement field counter
    });
  });



  let invoiceType = document.querySelector('#invoice_type')
  let invoiceContent = document.querySelector('#invoiceTypeContent');
  let invoiceTime  = document.querySelector('#invoice_time');
  let nofRecurring = document.querySelector('#nofRecurring');

  invoiceType.addEventListener('change',() => {
    if(invoiceType.value == 'recurring'){
      if(invoiceContent.classList.contains('d-none')){
        invoiceContent.classList.remove('d-none');
        invoiceTime.setAttribute('required',true);
        nofRecurring.setAttribute('required',true);
      }
    }else{
        invoiceContent.classList.add('d-none');
        invoiceTime.removeAttribute('required');
        nofRecurring.removeAttribute('required');
    }

      
  });
</script>
@endsection