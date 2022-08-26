@extends('master')

@section('content')
    <div class="container-fluid mt--6">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">{{__('Suspend User')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.postSuspend',$id) }}" method="post">
                    @csrf                                           
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">{{__('Reason')}}:</label>
                            <div class="col-lg-10">
                                <textarea type="text" name="reason" rows="5" placeholder="Enter Reason" class="form-control" required></textarea>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">{{__('Private note')}}:</label>
                            <div class="col-lg-10">
                                <textarea type="text" name="privateNote" rows="5" placeholder="Private Note" class="form-control" required></textarea>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">{{__('Suspend User')}}:</label>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input type="checkbox" name="suspend" id="customCheckLogin7" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="customCheckLogin7">
                                    <span class="text-muted">{{__('Suspend user')}}</span>
                                </label>
                            </div>
                        </div>          
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
