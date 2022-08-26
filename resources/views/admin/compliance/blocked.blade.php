@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Blocked Accounts')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th></th> 
                                    <th>{{ __('Name')}}</th> 
                                    <th>{{ __('Email')}}</th>
                                    <th>{{__('Private Note')}}</th>  
                                    <th>{{__('Account Number')}}</th>  
                                    <th>{{__('Sort Code')}}</th>  
                                    <th>{{__('Date Blocked')}}</th>     
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($blocked as $k=>$val)
                                <tr>
                                    <td>{{ ++$k }}.</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a href="{{route('user.manage', ['id' => $val->user_id])}}" class="dropdown-item">{{__('Manage User')}}</a>                                      
                                                @if(env('APP_ENV') == 'local')
                                                    <a href="{{route('admin.unblocked.user',['slug' =>$val->slug ])}}" class="dropdown-item">{{__('Reinstate User')}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $val->user->first_name }} {{ $val->user->last_name }}</td>
                                    <td>{{ $val->user->email }}</td>
                                    <td>{{ $val->private_note }}</td>
                                    <td>
                                        @if($val->account_number == NULL)
                                           <p class="text-center">-</p>
                                        @else
                                           <p>{{ $val->account_number }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->sort_code == NULL)
                                           <p class="text-center">-</p>
                                        @else
                                           <p>{{ $val->sort_code }}</p>
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