@extends('layout')
@section('title','Login')
@section('content')
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="d-flex justify-content-start align-items-start" style="position: absolute; top: 40px; left: 40px;">
  <a class="btn btn-close btn-md" href="{{ route('login') }}"></a>
</div>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="{{ asset('images/logo.jpg') }}"
                    style="width: 100px;" alt="logo">
                 
                </div>

                <form action="/login" method="post">
                  @csrf
                  <p>Please login to your account</p>
                  @if($errors->any())
                  @foreach ($errors->all() as $error)
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                      <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>
                      {{$error}}
                    </div>
                  </div>
                  @endforeach
                  @endif
                  @if(session()->has('error'))
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Danger:">
                      <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>
                      {{session('error')}}
                    </div>
                  </div>
                  @endif
                  @if(session()->has('success'))
                  <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="18px" height="18px" role="img" aria-label="Success:">
                      <use xlink:href="#check-circle-fill" />
                    </svg>
                    <div>
                      {{session('success')}}
                    </div>
                  </div>
                  @endif

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="email" name="email" id="email_login" class="form-control"
                      placeholder="Email or Phone Number" required />
                    <label class="form-label" for="email_login">Email or Phone Number</label>
                  </div>

                  <div data-mdb-input-init class="form-floating form-outline mb-4">
                    <input type="password" name="password" id="password_login" class="form-control" placeholder="Password" required />
                    <label class="form-label" for="password_login">Password</label>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="width:100%">Log
                      in</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="/register">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button></a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a hospital</h4>
                <p class="small mb-0">Your health. Our priority. Beacon Children Center. Where healing begins.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection