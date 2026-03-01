@extends('Admins.layout.auth')

@section('title', 'Login - Mofi Admin')

@section('body-class', 'login-page')

@section('content')
<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-12 p-0">    
      <div class="login-card login-dark">
        <div>
          <div><a class="logo" href="">
            <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="loginpage">
            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="loginpage">
          </a></div>
          <div class="login-main"> 
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ __(session('success')) }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ __(session('error')) }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif            
        <form class="theme-form" method="POST" action="{{ route("admin.login.post") }}">
              @csrf
              <h4>{{__("Sign in to account")}}</h4>
              <p>{{__("Enter your email & password to login")}}</p>
              <div class="form-group">
                <label class="col-form-label">{{__("Email Address")}}</label>
                <input class="form-control" type="email" name="email" required placeholder="Test@gmail.com" value="{{ old('email') }}">
                @error('email')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label class="col-form-label">{{__("Password")}}</label>
                <div class="form-input position-relative">
                  <input class="form-control" type="password" name="password" required placeholder="*********">
                  <div class="show-hide"><span class="show"></span></div>
                </div>
                @error('password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group mb-0">
                
                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" type="submit">{{__("Sign in")}}</button>
                </div>
              </div>
             
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Any login-specific scripts can go here
  $(document).ready(function() {
    // Toggle password visibility
    $('.show-hide span').click(function() {
      const input = $(this).closest('.form-input').find('input');
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        $(this).addClass('hide').removeClass('show');
      } else {
        input.attr('type', 'password');
        $(this).addClass('show').removeClass('hide');
      }
    });
  });
</script>
@endpush