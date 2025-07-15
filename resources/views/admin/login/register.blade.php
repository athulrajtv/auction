@extends('admin.login.layouts.master')
@section('content')

<!--start wrapper-->
<div class="wrapper">
  <div class="">
    <div class="row g-0 m-0">
      <div class="col-xl-6 col-lg-12">
        <div class="login-cover-wrapper">
          <div class="card shadow-none">
            <div class="card-body">

              <!-- Display Success and Error Messages -->
              @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
              @endif

              @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
              @endif

              <div class="text-center">
                <h4>Join</h4>
                <p>Enter your email and password to register</p>
              </div>

              <form class="form-body row g-3" method="post" action="{{ route('login.register') }}">
                @csrf

                <div class="col-12">
                  
                  <input type="hidden" name="user_type" value="admin" class="form-control" id="inputName">
                  
                </div>
                <div class="col-12">
                  <label for="inputName" class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" id="inputName">
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="inputEmail" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="inputEmail">
                  @error('email')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="inputEmail" class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control" id="inputEmail">
                  @error('phone')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="inputPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="inputPassword">
                  @error('password')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12 col-lg-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                    <label class="form-check-label" for="flexCheckChecked">
                      I agree the Terms and Conditions
                    </label>
                  </div>
                </div>
                <div class="col-12 col-lg-12">
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                  </div>
                </div>
                <div class="col-12 col-lg-12">
                  <div class="position-relative border-bottom my-3">
                    <div class="position-absolute seperator translate-middle-y">or continue with</div>
                  </div>
                </div>
                
                <div class="col-12 col-lg-12 text-center">
                  <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-12">
        <div class="position-fixed top-0 h-100 d-xl-block d-none register-cover-img">
        </div>
      </div>
    </div>
    <!--end row-->
  </div>
</div>
<!--end wrapper-->

@endsection