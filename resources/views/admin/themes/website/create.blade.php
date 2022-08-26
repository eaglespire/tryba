@extends('master')

@section('content')
<div class="container-fluid">
  <div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 mb-0">
                <div class="card-header">
                    <h3 class="mb-0">{{__('Add a New theme')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('create.webiste.theme')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" name="name" class="form-control" placeholder="Theme name" required>
                            </div>
                        </div>                              
                        <div class="form-group row">
                            <div class="col-lg-12">
                            <input type="text" name="category" class="form-control" placeholder="Category" required>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-lg-12" >
                                <label for="">Preview Image</label>
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="previewImage" class="form-control" placeholder="Upload Preview Image" required>
                            </div>
                        </div>                                                    
                        <div class="form-group row">
                            <div class="col-lg-12" >
                                <label for="">Theme</label>
                            </div>
                            <div class="col-lg-12">
                                <input type="file" name="theme" class="form-control" placeholder="Upload theme">
                            </div>
                        </div>  
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" name="premuim" id="customCheckLogin3"  class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin3">
                                    <span class="text-muted">{{__('Premuim theme')}}</span>     
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
        </div>
    </div>  
@stop