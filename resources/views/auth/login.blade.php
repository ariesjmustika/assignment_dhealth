@extends('template.auth_t')

@section('content')

<div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="/index3.html" class="brand-link">
            <img src="https://www.arkamaya.co.id/assets/images/arka/logo-arkamaya-flat.png" alt="PT. Arkmaya Logo"  style="opacity: .9" width="40%">
          </a>
        <p href="" class="h1"><b>Login</b> Page</p>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Enter Email and Password</p>

        <form action="{{ url ('api/auth/login') }}" method="post" id="form-login">
          <div class="form-group input-group">
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
          </div>
          <div class="form-group input-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
          </div>
          <div class="row">
            {{-- <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div> --}}
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-warning btn-block text-white">Log In</button>
            </div>
          </div>
        </form>
        <p class="mb-0">
          <a href="{{ url ('/register') }}" class="text-center text-warning">Register a new account</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

@endsection
