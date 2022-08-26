@extends('master')

@section('content')
    <div class="container-fluid mt--6">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">{{__('Terminate Account')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.terminate',$id) }}" method="post">
                        @csrf                                           
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">{{__('Private note')}}:</label>
                            <div class="col-lg-10">
                                <textarea type="text" name="privateNote" rows="5" placeholder="Private Note" class="form-control" required></textarea>
                            </div>
                        </div>           
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{__('Terminate Account')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
