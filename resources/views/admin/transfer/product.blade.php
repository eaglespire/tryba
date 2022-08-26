@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{__('Products')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-buttons">
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
                    <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p>Showing 1 to {{$product->count()}} of {{ $product->total() }} entries</p>
                    </div>
                    <div class="col-md-6 text-right">
                        {{ $product->onEachSide(2)->links() }}
                    </div>
                </div>
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
            </div>
        </div>
    </div>
    @stop