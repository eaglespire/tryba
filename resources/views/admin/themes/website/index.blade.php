@extends('master')
@section('css')
    <style>
        .object-fit-cover{
            object-fit: cover
        }
    </style>
@endsection
@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <a href="{{route('admin.website.theme.create')}}" class="btn btn-sm btn-neutral"><i class="fa fa-plus"></i> {{__('Add Theme')}}</a>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Website Themes')}}</h3>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-custom">
                            <thead>
                                <tr>
                                    <th>{{ __('S/N')}}</th>
                                    <th></th> 
                                    <th>{{ __('Image')}}</th> 
                                    <th>{{ __('Name')}}</th> 
                                    <th>{{ __('Category')}}</th>
                                    <th>{{__('Type')}}</th>  
                                    <th>{{__('Created')}}</th>     
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($themes as $k=>$val)
                                <tr>
                                    <td>{{ ++$k }}.</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fad fa-chevron-circle-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a data-toggle="modal" data-target="#update{{$val->id}}" class="dropdown-item">{{__('Update')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <img src="{{ $val->previewImage }}" height="50px" width="50px" class="object-fit-cover rounded" alt="">
                                        </div>
                                        
                                    </td>
                                    <td>{{ $val->themeName }}</td>
                                    <td>{{ $val->category }}</td>
                                    <td>
                                        @if($val->isPremuim==0)
                                            <span class="badge badge-pill  badge-secondary">{{__('Free')}}</span>
                                        @elseif($val->isPremuim ==1)
                                            <span class="badge badge-pill badge-primary">{{__('Premuim')}}</span> 
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
    @foreach($themes as $k=>$val)
        <div class="modal fade" id="update{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">   
                        <h3 class="mb-0 h3 font-weight-bolder">{{__('Update Theme')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.website.theme',$val->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control select" name="name" value="{{ $val->themeName }}" placeholder="Name" required />
                                </div>
                            </div>  
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="">Category</label>
                                    <input type="text" class="form-control select" name="category" value="{{ $val->category }}" placeholder="Duration"  required />
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <input type="checkbox" name="premuim" id="customCheckLogin3"  class="custom-control-input" value="1" @if($val->isPremuim == 1) checked @endif >
                                        <label class="custom-control-label" for="customCheckLogin3">
                                        <span class="text-muted">{{__('Premuim theme')}}</span>     
                                        </label>
                                    </div>                  
                                </div>  
                            </div>
                            <div class="text-left">
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