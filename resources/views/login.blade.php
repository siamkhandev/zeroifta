<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
            crossorigin="anonymous"
        />
        <!-- Custom Css -->
        <link rel="stylesheet" href="assets/css/style.css" />

        <title>ZeroIfta</title>
    </head>
    <body>
        <div class="main">
            <div class="auth-pages">
                <div class="auth-inner">
                    <!-- Auth Left -->
                    <div class="auth-left">
                        <div class="al-inn">
                            <img class="pb-3" src="assets/img/White-logo.png" alt="ZeroIfta Logo" />
                            <h1 class="">Welcome To ZEROIFTA</h1>
                            <p>Fuel smarter, drive farther—empowering every journey with ZeroIFTA. Turn every mile into a milestone of savings and success.</p>
                        </div>
                    </div>
                    <!-- Authentication Right Side Form Area -->
                    <div class="auth-right">
                        <div class="container">
                       
                            <div class="authRight_inn">
                                <div class="pb-4">
                                    <h3 class="blue pb-1">Sign In</h3>
                                    <p class="gray1">Enter your email and password to sign in</p>
                                </div>
                                @if(Session::has('success'))
                                  <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
                                @endif
                                @if(Session::has('error'))
                                  <div class="alert alert-danger" style="color:white">{{Session::get('error')}}</div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                  @csrf
                                  <div class="log_input mb-3">
                                      <label for="exampleFormControlInput1" class="pb-1">Email</label>
                                      <input type="email" class="form-control login-input @error('email') is-invalid @enderror" id="exampleFormControlInput1" placeholder="name@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                  </div>
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                  <div class="log_input mb-3">
                                      <label for="exampleFormControlInput1" class="pb-1">Password</label>
                                      <input type="password" class="form-control login-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="exampleFormControlInput1" placeholder="Type Password" />
                                  </div>
                                  <div class="re-fog">
                                      <div class="form-group">
                                          <label for="remember-me" class="text-info">
                                              <span>
                                                  <input id="remember-me"  type="checkbox"  name="remember"  {{ old('remember') ? 'checked' : '' }}/>
                                              </span>
                                              <span class="rf-text">Remember Me</span>
                                          </label>
                                      </div>
                                      <div class="forget-pass">
                                          <a class="rf-text" href="#">Forgot Password?</a>
                                      </div>
                                  </div>
                                <div class="btn-div log-btn text-center">
                                    <button type="submit" class="mainBtn">Login</button>
                                </div>
                                </form>
                                <div class="or_div">
                                    <hr />
                                    <span class="or-span">
                                        <p>Or</p>
                                    </span>
                                </div>
                                <div class="auth_end-div">
                                    <p>
                                        <span class="gray1">Don't you have an account?</span>
                                        <span>
                                            <a class="blue" href="{{route('register')}}">Sign up</a>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
        ></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    --></body>
</html>


           
            
                