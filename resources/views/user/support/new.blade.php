@extends('userlayout')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Ticket')}}</h1>
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Create ticket')}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <div class="container">
        <div class="card">
            <form action="{{route('submit-ticket')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body px-9 pt-6 pb-4">
                    <div class="row mb-6">
                        <label class="col-form-label required col-lg-3">{{__('Subject')}}</label>
                        <div class="col-lg-9">
                            <input type="text" name="subject" class="form-control form-control-solid" required="">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-form-label required col-lg-3">{{__('Reference')}}</label>
                        <div class="col-lg-9">
                            <div class="input-group input-group-merge">
                                <input type="text" required name="ref_no" class="form-control form-control-solid" placeholder="Transaction reference" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-form-label required col-lg-3">{{__('Priority')}}</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-solid" name="priority" required>
                                <option value="Low">{{__('Low')}}</option>
                                <option value="Medium">{{__('Medium')}}</option>
                                <option value="High">{{__('High')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-form-label required col-lg-3">{{__('Type')}}</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-solid" name="type" required>
                                <option value="store">{{__('Store')}}</option>
                                <option value="donation">{{__('Gig Pot')}}</option>
                                <option value="invoice">{{__('Invoice')}}</option>
                                <option value="merchant">{{__('API')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-form-label col-lg-3 required">{{__('Details')}}</label>
                        <div class="col-lg-9">
                            <textarea name="details" required class="form-control form-control-solid" rows="6" required placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-form-label required col-lg-3">{{__('Evidence')}}</label>
                        <div class="col-lg-9">
                            <div class="custom-file">
                                <input type="file" class="form-control form-control-solid" id="customFileLang" name="image[]" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary"> {{__('Submit Dispute')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop