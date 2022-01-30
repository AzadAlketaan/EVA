@extends('layouts.master')

@section('content')

<div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
  
    
    <div class="site-blocks-cover inner-page-cover overlay"  data-aos="fade"  data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
          <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                        <br>
                        <br>
                        <br>
                <h3>Sign in</h3>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>  

    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 mb-5"  data-aos="fade">

            
          <form class="form-horizontal p-5 bg-white" style="margin-top: 20px;" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
          
              <div class="row form-group">
                
                <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label class="text-black control-label" for="email">Email</label> 
                  <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                </div>
              </div>


              <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                
                <div class="col-md-12">
                  <label class="text-black" for="password">Password</label> 
                  <input type="password" id="password"name="password" class="form-control"required>
                        @if ($errors->has('password'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('password') }}</strong>
                              </span>
                        @endif
                </div>
              </div>

              <div class="row form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

              <div class="row form-group">
                <div class="col-12">
                  <p>No account yet? <a href="register">Register</a></p>
                </div>
              </div>

            
              <div class="row form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

            </form>
          </div>
          
        </div>
      </div>
    </div>


@endsection
