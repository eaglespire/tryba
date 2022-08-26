@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Compliance')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th></th> 
                                    <th>{{ __('Name')}}</th> 
                                    <th>{{ __('Email')}}</th>  
                                    <th>{{__('Status')}}</th>  
                                    <th>{{__('Created')}}</th>     
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($compliance as $k=>$val)
                                <tr>
                                    <td>{{ ++$k }}.</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a href="{{route('user.manage', ['id' => $val->user_id])}}" class="dropdown-item">{{__('Manage User')}}</a>
                                                <a href="{{route('user.compliance.view', ['slug' => $val->url])}}" class="dropdown-item">{{__('View More')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $val->user->first_name }} {{ $val->user->last_name }}</td>
                                    <td>{{ $val->user->email }}</td>
                                    <td>
                                        @if($val->responded==0)
                                            <span class="badge badge-pill  badge-danger">{{__('No Response')}}</span>
                                        @elseif($val->responded ==1)
                                            <span class="badge badge-pill badge-primary">{{__('Responded')}}</span> 
                                        @endif
                                    </td>
                                    <td>{{ date("d M,Y h:i:A", strtotime($val->created_at)) }}</td>                 
                                </tr>
                                @endforeach               
                            </tbody>                    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @foreach($compliance as $k=>$val)
        <div class="modal fade" id="update{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">   
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Edit Subscription plan')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.admin.plans',$val->id) }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control select" name="name" value="{{ $val->name }}" placeholder="Name" required />
                                </div>
                            </div>  
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Duration</label>
                                    <input type="number" class="form-control select" name="duration" value="{{ $val->duration }}" placeholder="Duration"  required />
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Type</label>
                                    <select class="form-control select" name="durationType" required>
                                        <option value="month">Month</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="">Amount</label>
                                    <input type="number" class="form-control select" name="amount" value="{{ $val->amount }}" placeholder="Amount"  required />
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Email Limit</label>
                                    <input type="number" class="form-control select" name="email_limit" value="{{ $val->email_limit }}" placeholder="Email LImit"  required />
                                </div>
                                <div class="col-lg-6">
                                    <label for="">SMS Limit</label>
                                    <input type="number" class="form-control select" name="sms_limit" value="{{ $val->sms_limit }}" placeholder="SMS Limit"  required />
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Start interval</label>
                                    <input type="number" class="form-control select" name="annualstartPrice" value="{{ $val->annualstartPrice }}" placeholder="Amount"  required />
                                </div>
                                <div class="col-lg-6">
                                    <label for="">End Interval</label>
                                    <input type="number" class="form-control select" name="annualendPrice" value="{{ $val->annualendPrice }}" placeholder="Amount"  required />
                                </div>
                            </div> 
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-block">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach  
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#datatable-custom').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
</script>
@endsection