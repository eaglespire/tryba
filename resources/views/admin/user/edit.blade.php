@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            @if($client->plan_id!=null)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center mb-1">
                            <div class="col-6">
                                <h4 class="card-title mb-1 font-weight-bold">{{__('Package')}}</h4>
                            </div>
                            <div class="col-6 text-right">
                                <span class="mb-0 text-dark">{{ucwords($client->plan->name)}}</span><br>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-6">
                                <h4 class="card-title mb-1 font-weight-bold">{{__('Account Balance')}}</h4>
                            </div>
                            <div class="col-6 text-right">
                                <span class="mb-0 text-dark">{{ view_currency2($client->coin['coin_id']).number_format($client->balance,'2','.','') }}</span><br>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-6">
                                <h4 class="card-title mb-1 font-weight-bold">{{__('Monthly Income Transactions')}}</h4>
                            </div>
                            <div class="col-6 text-right">
                                <span class="mb-0 text-dark">{{ getUserCurrency($client). number_format(GetUserMonthlyTransactions($client->id)) }} {{__('of')}} {{view_currency($client->plan->currency_id) . number_format($client->plan->annualendPrice)}}</span><br>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-6">
                                <h4 class="card-title mb-1 font-weight-bold">{{__('Monthly Amount')}}</h4>
                            </div>
                            <div class="col-6 text-right">
                                <span class="mb-0 text-dark">{{ getUserCurrency($client) }} {{number_format($client->used_payments, 2, '.', '')}} /{{getUserCurrency($client)}} {{number_format($client->plan_payments, 2, '.', '')}}</span><br>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-6">
                                <h4 class="card-title mb-1 font-weight-bold">{{__('Expiring Date')}}</h4>
                            </div>
                            <div class="col-6 text-right">
                                <span class="mb-0 text-dark">{{date("d, M Y", strtotime($client->plan_expiring))}}</span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Update Account Information')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('admin/profile-update')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$client->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('First Name')}}</label>
                                <div class="col-lg-10">
                                    <input type="text" name="first_name" class="form-control" value="{{$client->first_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Last Name')}}</label>
                                <div class="col-lg-10">
                                    <input type="text" name="last_name" class="form-control" value="{{$client->last_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Email')}}</label>
                                <div class="col-lg-10">
                                    <input type="email" name="email" class="form-control" readonly value="{{$client->email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Support Email')}}</label>
                                <div class="col-lg-10">
                                    <input type="email" name="support_email" class="form-control" readonly value="{{$client->support_email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Support Mobile')}}</label>
                                <div class="col-lg-10">
                                    <input type="email" name="support_phone" class="form-control" readonly value="{{$client->support_phone}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Mobile')}}</label>
                                <div class="col-lg-10">
                                    <input type="text" name="mobile" class="form-control" value="{{$client->phone}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{__('Status')}}<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        @if($client->email_verify==1)
                                        <input type="checkbox" name="email_verify" id=" customCheckLogin5" class="custom-control-input" value="1" checked>
                                        @else
                                        <input type="checkbox" name="email_verify" id=" customCheckLogin5" class="custom-control-input" value="1">
                                        @endif
                                        <label class="custom-control-label" for=" customCheckLogin5">
                                            <span class="text-muted">{{__('Email verification')}}</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        @if($client->phone_verify==1)
                                        <input type="checkbox" name="phone_verify" id=" customCheckLogin4" class="custom-control-input" value="1" checked>
                                        @else
                                        <input type="checkbox" name="phone_verify" id=" customCheckLogin4" class="custom-control-input" value="1">
                                        @endif
                                        <label class="custom-control-label" for=" customCheckLogin4">
                                            <span class="text-muted">{{__('Phone verification')}}</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        @if($client->fa_status==1)
                                        <input type="checkbox" name="fa_status" id=" customCheckLogin6" class="custom-control-input" value="1" checked>
                                        @else
                                        <input type="checkbox" name="fa_status" id=" customCheckLogin6" class="custom-control-input" value="1">
                                        @endif
                                        <label class="custom-control-label" for=" customCheckLogin6">
                                            <span class="text-muted">{{__('2fa security')}}</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        @if($client->dispute==1)
                                        <input type="checkbox" name="dispute" id=" customCheckLogin7" class="custom-control-input" value="1" checked>
                                        @else
                                        <input type="checkbox" name="dispute" id=" customCheckLogin7" class="custom-control-input" value="1">
                                        @endif
                                        <label class="custom-control-label" for=" customCheckLogin7">
                                            <span class="text-muted">{{__('Dispute Raised')}}</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        @if($client->payment==1)
                                        <input type="checkbox" name="payment" id=" customCheckLogins7" class="custom-control-input" value="1" checked>
                                        @else
                                        <input type="checkbox" name="payment" id=" customCheckLogins7" class="custom-control-input" value="1">
                                        @endif
                                        <label class="custom-control-label" for=" customCheckLogins7">
                                            <span class="text-muted">{{__('Payments')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-sm">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <h3 class="mb-0 font-weight-bolder text-uppercase">{{__('Social links')}}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('Facebook')}}: {{$client->facebook}}</p>
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('Twitter')}}: {{$client->twitter}}</p>
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('Instagram')}}: {{$client->instagram}}</p>
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('LinkedIn')}}: {{$client->linkedin}}</p>
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('Youtube')}}: {{$client->youtube}}</p>
                                <p class="text-sm mb-0 font-weight-bolder text-uppercase">{{__('Wahtsapp')}}: {{$client->whatsapp}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('asset/profile/'. $client->image) }}" width="120" height="120" alt="">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <h3 class="mb-0 font-weight-bolder text-uppercase">{{__('Security')}}</h3>
                            </div>
                        </div>
                        <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                            <ul class="list list-unstyled mb-0">
                                <li><span class="text-sm">{{__('Joined:')}} {{date("Y/m/d h:i:A", strtotime($client->created_at))}}</span></li>
                                <li><span class="text-sm">{{__('Last Login:')}} {{date("Y/m/d h:i:A", strtotime($client->last_login))}}</span></li>
                                <li><span class="text-sm">{{__('Last Updated:')}} {{date("Y/m/d h:i:A", strtotime($client->updated_at))}}</span></li>
                                <li><span class="text-sm">{{__('IP Address:')}} {{$client->ip_address}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Compliance')}}</h3>
                    </div>
                    <div class="card-body">
                        <p>Name: {{$client->first_name.' '.$client->last_name}}</p>
                        <p>Gender: {{$client->gender}}</p>
                        <p>Date of Birth: {{$client->b_month}}-{{$client->b_day}}-{{$client->b_year}}</p>
                        <p>Business name: {{$client->business_name}}</p>
                        <p>Good and Services: {{$client->mcc}}</p>
                        <p>Product Description: {{$client->product_description}}</p>
                        <p>Business Website: {{$client->website_link}}</p>
                        <p>State: {{$client->state}}</p>
                        <p>Address: {{$client->line_1}}
                        <p>
                            @if($client->line_2!=null)
                        <p>Address 2: {{$client->line_2}}
                        <p>@endif
                        <p>City: {{$client->city}}
                        <p>
                        <p>Postal Code: {{$client->postal_code}}
                        <p>
                        <p>{{__('ID Document')}}: {{$client->id_type}}</p>
                        @if($client->id_file!=null)
                        <a href="{{url('/')}}/asset/profile/{{$client->id_file}}">{{__('View ID Document')}}</a><br>
                        @endif
                        @if($client->address_file!=null)
                        <a href="{{url('/')}}/asset/profile/{{$client->address_file}}">{{__('Proof of Address')}}</a><br><br>
                        @endif
                        @if($client->due==1)
                        <a class="btn btn-sm btn-success" href="{{url('/')}}/admin/approve-kyc/{{$client->id}}"><i class="fad fa-check"></i> {{__('Approve Compliance')}}</a>
                        <a class='btn btn-sm btn-danger' data-toggle="modal" data-target="#decline" href=""><i class="fad fa-ban"></i> {{__('Reject Compliance')}}</a><br>
                        <div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="{{route('admin.reject.kyc')}}" method="post">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <input name="id" value="{{$client->id}}" type="hidden">
                                                    <textarea type="text" name="reason" class="form-control" rows="5" placeholder="{{__('Provide reason for decline')}}" required></textarea>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success btn-block">{{__('Decline')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <br>
                        @if($client->due==0)
                        <span class="badge badge-pill badge-danger">Compliance: Unverified</span>
                        @elseif($client->due==2)
                        <span class="badge badge-pill badge-primary">Compliance: Verified</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h3 class="mb-0 font-weight-bolder">{{__('Transactions')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>{{__('To')}}</th>
                                    <th>{{__('From')}}</th>
                                    <th>Status</th>
                                    <th class="text-center">{{__('Reference ID')}}</th>
                                    <th class="text-center">{{__('Type')}}</th>
                                    <th class="text-center">{{__('Channel')}}</th>
                                    <th class="text-center">{{__('Amount')}}</th>
                                    <th class="text-center">{{__('Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trans as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td>{{$val->first_name.' '.$val->last_name}} [{{$val->email}}]</td>
                                    <td>{{$val->receiver->first_name.' '.$val->receiver->last_name}}</td>
                                    <td class="text-center">@if($val->status==0) Pending @elseif($val->status==1) Success @elseif($val->status==2) Failed @endif</td>

                                    <td class="text-center">{{$val->ref_id}}</td>
                                    <td class="text-center">
                                        @if($val->type==1)
                                        Single Pot
                                        @elseif($val->type==2)
                                        Gig Pot
                                        @elseif($val->type==3)
                                        Invoice
                                        @elseif($val->type==4)
                                        Merchant
                                        @elseif($val->type==5)
                                        Account Funding
                                        @elseif($val->type==6)
                                        Recurring
                                        @elseif($val->type==7)
                                        Product Order
                                        @elseif($val->type==8)
                                        Store Order
                                        @elseif($val->type==9)
                                        Subscription Payment
                                        @endif
                                    </td>

                                    <td class="text-center">{{ucfirst($val->payment_type)}}</td>
                                    <td class="text-center">
                                        {{view_currency2($val->currency).number_format($val->amount, 2, '.', '')}}
                                    </td>
                                    <td class="text-center">{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h3 class="mb-0">{{__('Invoice logs')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons1">
                            <thead>
                                <tr>
                                    <th>{{__('S/N')}}</th>
                                    <th class="text-center"></th>
                                    <th>{{__('Ref')}}</th>
                                    <th>{{__('Sender')}}</th>
                                    <th>{{__('Due')}}</th>
                                    <th>{{__('Send Date')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Sent')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class="dropdown">
                                                <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-chevron-circle-down"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" target="_blank" href="{{route('view.invoice', ['id' => $val->ref_id])}}">{{__('Preview')}}</a>
                                                    <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->ref_id}}</td>
                                    <td>{{$val->user['first_name'].' '.$val->user['last_name']}}</td>
                                    <td>{{$val->due_date}}</td>
                                    <td>@if($val->sent_date!=null){{$val->sent_date}} @else Not sent @endif</td>
                                    <td>{{view_currency2($val->currency).number_format(array_sum(json_decode($val->total)), 2, '.', '')}}</td>
                                    <td>
                                        @if($val->status==0)
                                        <span class="badge badge-danger">{{__('Pending')}}</span>
                                        @elseif($val->status==1)
                                        <span class="badge badge-success">{{__('Paid')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->sent==0)
                                        <span class="badge badge-danger">{{__('No')}}</span>
                                        @elseif($val->sent==1)
                                        <span class="badge badge-success">{{__('Yes')}}</span>
                                        @endif
                                    </td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h3 class="mb-0">{{__('Multiple Pot')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons3">
                            <thead>
                                <tr>
                                    <th>{{__('S / N')}}</th>
                                    <th></th>
                                    <th>{{__('Merchant')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Donors')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Reference ID')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Suspended')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dplinks as $k=>$val)
                                @php
                                $donors=App\Models\Donations::wheredonation_id($val->id)->wherestatus(1)->latest()->get();
                                $donated=App\Models\Donations::wheredonation_id($val->id)->wherestatus(1)->sum('amount');
                                @endphp
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if($val->status==1)
                                                <a class='dropdown-item' href="{{route('links.unpublish', ['id' => $val->id])}}">{{ __('Unsuspend')}}</a>
                                                @else
                                                <a class='dropdown-item' href="{{route('links.publish', ['id' => $val->id])}}">{{ __('Suspend')}}</a>
                                                @endif
                                                <a class="dropdown-item" href="{{route('admin.linkstrans', ['id' => $val->id])}}">{{__('Transactions')}}</a>
                                                <a class="dropdown-item" target="_blank" href="{{route('pot.link', ['id' => $val->ref_id])}}">{{__('Preview')}}</a>
                                                <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                                <a data-toggle="modal" data-target="#description{{$val->id}}" href="" class="dropdown-item">{{ __('Description')}}</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#donors{{$val->id}}" href="#">{{__('Donors')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@if($val->user['id']==null) [Deleted] @else <a href="{{url('admin/manage-user')}}/{{$val->user['id']}}">{{$val->user['first_name'].' '.$val->user['last_name']}}</a> @endif</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{count($donors)}}</td>
                                    <td>{{view_currency2($val->currency).number_format($donated, 2, '.', '')}}/{{view_currency2($val->currency).number_format($val->amount, 2, '.', '')}}</td>
                                    <td>{{$val->ref_id}}</td>
                                    <td>
                                        @if($val->active==1)
                                        <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->status==1)
                                        <span class="badge badge-pill badge-success">{{__('Yes')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('No')}}</span>
                                        @endif
                                    </td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @foreach($dplinks as $k=>$val)
                @php
                $donors=App\Models\Donations::wheredonation_id($val->id)->wherestatus(1)->latest()->get();
                $donated=App\Models\Donations::wheredonation_id($val->id)->wherestatus(1)->sum('amount');
                @endphp
                <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                        <a href="{{route('delete.link', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="description{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <img class="card-img-top" src="{{url('/')}}/asset/profile/{{$val->image}}" alt="Image placeholder">
                                    <div class="card-body">
                                        <p class="mb-0 text-sm">{!!$val->description!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="donors{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <ul class="list-group list-group-flush list my--3">
                                            @if(count($donors)>0)
                                            @foreach($donors as $k=>$xval)
                                            <li class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape text-white rounded-circle bg-success">
                                                            <i class="fad fa-gift"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col ml--2">
                                                        <h4 class="mb-0">
                                                            @if($xval->anonymous==0)
                                                            @if($xval->user_id==null)
                                                            @php
                                                            $fff=App\Models\Transactions::whereref_id($xval->ref_id)->first();
                                                            @endphp
                                                            {{$fff['first_name'].' '.$fff['last_name']}}
                                                            @endif
                                                            {{$xval->user['first_name'].' '.$xval->user['last_name']}}
                                                            @else
                                                            Anonymous
                                                            @endif
                                                        </h4>
                                                        <small>{{view_currency2($val->currency).$xval->amount}} @ {{date("h:i:A j, M Y", strtotime($xval->created_at))}}</small>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            @else
                                            <li class="list-group-item px-0">
                                                <p class="text-sm">No Donors</p>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h3 class="mb-0">{{__('Single Pot')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons4">
                            <thead>
                                <tr>
                                    <th>{{__('S / N')}}</th>
                                    <th></th>
                                    <th>{{__('Merchant')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Reference ID')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Suspended')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sclinks as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if($val->status==1)
                                                <a class='dropdown-item' href="{{route('links.unpublish', ['id' => $val->id])}}">{{ __('Unsuspend')}}</a>
                                                @else
                                                <a class='dropdown-item' href="{{route('links.publish', ['id' => $val->id])}}">{{ __('Suspend')}}</a>
                                                @endif
                                                <a class="dropdown-item" href="{{route('admin.linkstrans', ['id' => $val->id])}}">{{__('Transactions')}}</a>
                                                <a class="dropdown-item" target="_blank" href="{{route('pot.link', ['id' => $val->ref_id])}}">{{__('Preview')}}</a>
                                                <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                                <a data-toggle="modal" data-target="#description{{$val->id}}" href="" class="dropdown-item">{{ __('Description')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@if($val->user['id']==null) [Deleted] @else <a href="{{url('admin/manage-user')}}/{{$val->user['id']}}">{{$val->user['first_name'].' '.$val->user['last_name']}}</a> @endif</td>
                                    <td>{{$val->name}}</td>
                                    <td>@if($val->amount==null) Not fixed @else {{view_currency2($val->currency).number_format($val->amount, 2, '.', '')}} @endif</td>
                                    <td>{{$val->ref_id}}</td>
                                    <td>
                                        @if($val->active==1)
                                        <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->status==1)
                                        <span class="badge badge-pill badge-success">{{__('Yes')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('No')}}</span>
                                        @endif
                                    </td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @foreach($sclinks as $k=>$val)
                <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                        <a href="{{route('delete.link', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="description{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <p class="mb-0 text-sm">{{$val->description}}</p>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Products')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons5">
                            <thead>
                                <tr>
                                    <th>{{__('S/N')}}</th>
                                    <th class="text-center"></th>
                                    <th>{{__('Ref')}}</th>
                                    <th>{{__('Vendor')}}</th>
                                    <th>{{__('Orders')}}</th>
                                    <th>{{__('Product Name')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Quantity')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Suspended')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product as $k=>$val)
                                @php
                                $amount=App\Models\Order::whereproduct_id($val->id)->sum('total');
                                $orders=App\Models\Order::whereproduct_id($val->id)->count();
                                $store=App\Models\Storefront::whereuser_id($val->user->id)->first();
                                @endphp
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td class="text-center">
                                        <div class="">
                                            <div class="dropdown">
                                                <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-chevron-circle-down"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @if($val->active==0)
                                                    <a class='dropdown-item' href="{{route('product.unpublish', ['id' => $val->id])}}">{{ __('Unsuspend')}}</a>
                                                    @else
                                                    <a class='dropdown-item' href="{{route('product.publish', ['id' => $val->id])}}">{{ __('Suspend')}}</a>
                                                    @endif
                                                    <a class="dropdown-item" target="_blank" href="{{route('sproduct.link', ['id'=>$store->store_url,'product'=>$val->ref_id])}}">{{__('Preview')}}</a>
                                                    <a class="dropdown-item" href="{{route('admin.orders', ['id' => $val->id])}}">{{__('Orders')}}</a>
                                                    <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#{{$val->ref_id}}</td>
                                    <td>{{$val->user->first_name.' '.$val->user->last_name}}</td>
                                    <td>{{view_currency2($val->currency).number_format($amount, 2)}} [{{$orders}}]</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{view_currency2($val->currency).number_format($val->amount, 2)}}</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>
                                        @if($val->status==0)
                                        <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                                        @elseif($val->status==1)
                                        <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->active==0)
                                        <span class="badge badge-pill badge-success">{{__('Yes')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('No')}}</span>
                                        @endif
                                    </td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @foreach($product as $k=>$val)
                <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                        <a href="{{route('product.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Merchants')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons6">
                            <thead>
                                <tr>
                                    <th>{{__('S/N')}}</th>
                                    <th class="text-center">{{__('Action')}}</th>   
                                    <th>{{__('Client')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Merchant key')}}</th>
                                    <th>{{__('Reference')}}</th>
                                    <th>{{__('Created')}}</th>
                                    <th>{{__('Updated')}}</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($merchant as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>  
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{route('transfer.log', ['id' => $val->merchant_key])}}">{{__('Transactions')}}</a>
                                                <a data-toggle="modal" data-target="#description{{$val->id}}" href="" class="dropdown-item">{{ __('Description')}}</a>
                                                <a data-toggle="modal" data-target="#delete{{$val->id}}" href="" class="dropdown-item">{{ __('Delete')}}</a>
                                            </div>
                                        </div>
                                    </td> 
                                    <td><a href="{{url('admin/manage-user')}}/{{$val->user['id']}}">{{$val->user['first_name'].' '.$val->user['last_name']}}</a></td>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->merchant_key}}</td> 
                                    <td>{{$val->ref_id}}</td> 
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>                 
                                </tr>
                                @endforeach               
                            </tbody>                    
                        </table>
                    </div>
                </div>
                @foreach($merchant as $k=>$val)
                <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-header">
                                        <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                    </div>
                                    <div class="card-body px-lg-5 py-lg-5 text-right">
                                        <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
                                        <a  href="{{route('merchant.delete', ['id' => $val->id])}}" class="btn btn-danger btn-sm">{{ __('Proceed')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="description{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <div class="card-body">
                                        <p class="mb-0 text-sm">{{$val->description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                
                <div class="modal fade" id="image{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="card bg-white border-0 mb-0">
                                    <img class="card-img-top" src="{{url('/')}}/asset/profile/{{$val->image}}" alt="Image placeholder">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Audit Logs')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons2">
                            <thead>
                                <tr>
                                    <th>{{__('S / N')}}</th>
                                    <th>{{__('Reference ID')}}</th>
                                    <th>{{__('Log')}}</th>
                                    <th>{{__('Created')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($audit as $k=>$val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td>{{ $val->trx }}</td>
                                    <td>{{ $val->log }}</td>
                                    <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Compliance Log')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons2">
                            <thead>
                                <tr>
                                    <th>{{__('S / N')}}</th>
                                    <th>{{__('')}}</th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compliance as $k => $val)
                                <tr>
                                    <td>{{++$k}}.</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a href="{{route('user.compliance.view', ['slug' => $val->url])}}" class="dropdown-item">{{__('View More')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $val->url }}</td>
                                    <td>
                                        @if($val->responded == 0)
                                            <span class="badge badge-pill  badge-danger">{{__('No Response')}}</span>
                                        @elseif($val->responded ==1)
                                            <span class="badge badge-pill badge-primary">{{__('Responded')}}</span> 
                                        @endif
                                    </td>
                                    <td>{{ date("Y/m/d h:i:A", strtotime($val->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop