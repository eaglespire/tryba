@extends('loginlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">
  <h1 class="mb-0 fw-bold">Sign In</h1>
  <p class="mb-6 text-muted">Welcome back, login to manage account</p>
  <form class="mb-6" id="reg-form" role="form" action="{{route('admin.login')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="form-label" for="username">
        Username
      </label>
      <input type="text" class="form-control" id="username" placeholder="username" name="username" required>
    </div>
    <div class="form-group mb-5">
      <label class="form-label" for="password">
        Password
      </label>
      <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
    </div>
    <div class="row mt-3 mb-3">
      <div class="col-6">
        <div class="custom-control custom-control-alternative custom-checkbox">
          <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember_me">
          <label class="custom-control-label" for=" customCheckLogin">
            <span class="text-dark fs-sm">{{__('Remember Me')}}</span>
          </label>
        </div>
      </div>                 
    </div>
    <button class="btn w-100 btn-primary" type="submit">Sign in</button>
  </form>
</div>
@stop