<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
  <title>
    Zeroifta | Company Register
  </title>
  <style>
    .field-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">

      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Register</h4>
                  <p class="mb-0">Company Details</p>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                      <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="dot" placeholder="DOT" type="text" class="form-control @error('dot') is-invalid @enderror" name="dot" value="{{ old('dot') }}" required autofocus>
                    </div>
                    @error('dot')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="mc" placeholder="MC Number" type="text" class="form-control @error('mc') is-invalid @enderror" name="mc" value="{{ old('mc') }}" required autofocus>
                    </div>
                    @error('mc')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="phone" placeholder="Phone" type="taxt" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autofocus>
                    </div>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <select name="state" class="form-control" name="state">
                        <option value="null">Select state</option>
                        <option value="Alabama"> Alabama</option>
                        <option value="Arizona">Arizona</option>
                        <option value="Arkansas">Arkansas</option>
                        <option value="California">California</option>
                        <option value="Colorado">Colorado</option>
                        <option value="Connecticut">Connecticut</option>
                        <option value="Delaware">Delaware</option>
                        <option value="Florida">Florida</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Idaho">Idaho</option>
                        <option value="Illinois">Illinois</option>
                        <option value="Indiana">Indiana</option>
                        <option value="Iowa">Iowa</option>
                        <option value="Kansas">Kansas</option>
                        <option value="Kentucky">Kentucky</option>
                        <option value="Louisiana">Louisiana</option>
                        <option value="Maine">Maine</option>
                        <option value="Maryland">Maryland</option>
                        <option value="Massachusetts">Massachusetts</option>
                        <option value="Michigan">Michigan</option>
                        <option value="Minnesota">Minnesota</option>
                        <option value="Mississippi">Mississippi</option>
                        <option value="Missouri">
                          Missouri</option>
                        <option value="Montana">
                          Montana</option>
                        <option value="Nebraska">
                          Nebraska</option>
                        <option value="Nevada">
                          Nevada</option>
                        <option value="New Hampshire">
                          New Hampshire</option>
                        <option value="New Jersey">
                          New Jersey</option>
                        <option value="New Mexico">
                          New Mexico</option>
                        <option value="New York">
                          New York</option>
                        <option value="North Carolina">
                          North Carolina</option>
                        <option value="North Dakota">
                          North Dakota</option>
                        <option value="Ohio">
                          Ohio</option>
                        <option value="Oklahoma">
                          Oklahoma</option>
                        <option value="Oregon">
                          Oregon</option>
                        <option value="Pennsylvania">
                          Pennsylvania</option>
                        <option value="Rhode Island">
                          Rhode Island</option>
                        <option value="South Carolina">
                          South Carolina</option>
                        <option value="South Dakota">
                          South Dakota</option>
                        <option value="Tennessee">
                          Tennessee</option>
                        <option value="Texas">
                          Texas</option>
                        <option value="Utah">
                          Utah</option>
                        <option value="Vermont">
                          Vermont</option>
                        <option value="Virginia">
                          Virginia</option>
                        <option value="Washington">
                          Washington</option>
                        <option value="West Virginia">
                          West Virginia</option>
                        <option value="Wisconsin">
                          Wisconsin</option>
                        <option value="Wyoming">
                          Wyoming</option>
                      </select>
                    </div>
                    @error('state')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="city" placeholder="City" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>
                    </div>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="zip" placeholder="ZIP Code" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" required autofocus>
                    </div>
                    @error('zip')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <p>Contact Person Details</p>
                    <div class="mb-3">
                      <input id="contact_name" placeholder="Contact Person Name" type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" value="{{ old('contact_name') }}" required autofocus>
                    </div>
                    @error('contact_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="contact_email" placeholder="Contact Person Email" type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}" required autofocus>
                    </div>
                    @error('contact_email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3">
                      <input id="contact_phone" placeholder="Contact Person Phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" required autofocus>
                    </div>
                    @error('contact_phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <p>Authentication</p>

                    <div class="mb-3 position-relative">
                      <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                      <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="mb-3 position-relative">
                      <input id="password_confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
                      <span toggle="#password_confirm" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Register</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Do you have an account?
                    <a href="{{route('login')}}" class="text-primary text-gradient font-weight-bold">Login</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('{{asset('images/truck2.webp')}}');">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">Fuel smarter, drive farther—empowering every journey with ZeroIFTA. Turn every mile into a milestone of savings and success.</h4>
                <p class="text-white position-relative"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    document.querySelectorAll('.toggle-password').forEach(function(element) {
      element.addEventListener('click', function() {
        let input = document.querySelector(this.getAttribute('toggle'));
        if (input.getAttribute('type') === 'password') {
          input.setAttribute('type', 'text');
          this.classList.remove('fa-eye');
          this.classList.add('fa-eye-slash');
        } else {
          input.setAttribute('type', 'password');
          this.classList.remove('fa-eye-slash');
          this.classList.add('fa-eye');
        }
      });
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
</body>

</html>