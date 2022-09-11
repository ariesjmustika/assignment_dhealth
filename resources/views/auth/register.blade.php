@extends('template.auth_t')

@section('content')
<div class="register-box">
  <div class="card card-outline card-primary">

    <div class="card-header text-center">
        <a  class="brand-link">
            <img src="https://www.arkamaya.co.id/assets/images/arka/logo-arkamaya-flat.png" alt="PT. Arkmaya Logo"  style="opacity: .9" width="40%">
          </a>
        <p href="" class="h1"><b>Register</b> Page</p>
    </div>
    <div class="card-body">
      {{-- <p class="login-box-msg">Entry datas bellow</p> --}}

      <form action="{{ url ('api/auth/register') }}" method="post" id="form-register">
        @csrf
        <div class="form-group input-group">
            <input type="text" name="name" class="form-control"  placeholder="Enter Full Name" id="name">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
          </div>
          <div class="form-group input-group">
            <input type="email" name="email" class="form-control"  placeholder="Enter email" id="email">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
          </div>
          <div class="form-group input-group">
            <input type="password" name="password" class="form-control"  placeholder="Enter Password" id="password">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
          </div>
          <div class="form-group input-group">
            <input type="password" name="password2" class="form-control"  placeholder="Retrype Password" id="password2">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
          </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-warning text-white btn-block">Register</button>
          </div>
        </div>
      </form>

      {{-- <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
      </div> --}}

      <a href="{{ url ('/login') }}" class="text-center text-warning">I already have an account</a>
    </div>
  </div>
</div>
@endsection
