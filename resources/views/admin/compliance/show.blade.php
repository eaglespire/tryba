@extends('master')

@section('content')
    <div class="container-fluid mt--6">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">{{__('View Compliance')}}</h3>
                </div>
                <div class="card-body">                                           
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('Response')}}:</label>
                        <div class="col-lg-10">
                            <p class="mt-3">{{ ($compliance->response) ? $compliance->response : "No Response" }}</p>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{__('File uploaded')}}:</label>
                        <div class="col-lg-10">
                            @if ($compliance->file_url != NULL)
                                <a href="{{ $compliance->file_url }}" class="btn btn-primary">{{__('View File')}}</a>
                            @else
                                <p class="mt-3" >No file found</p>
                            @endif                            
                        </div>
                    </div>        
                    <form action="{{ route('resend.compliance',$compliance->url) }}" method="post">
                        @csrf
                        <div class="">
                            <button type="submit" class="btn btn-primary">{{__('Resend Compliance')}}</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
