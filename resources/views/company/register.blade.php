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
    crossorigin="anonymous" />
  <!-- Custom Css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
  <!-- Standard Favicon -->
  <link rel="icon" href="{{asset('assets/img/fav-icon.png')}}">

  <title>ZeroIfta</title>
</head>

<body>
  <div class="main">
    <div class="auth-pages">
      <div class="auth-inner">
        <!-- Auth Left -->
        <div class="auth-left">
          <div class="al-inn">
            <div class="main-logo pb-3">
              <!-- <img class="pb-3" src="assets/img/White-logo.png" alt="ZeroIfta Logo" /> -->
              <svg xmlns="http://www.w3.org/2000/svg" width="162" height="45" viewBox="0 0 162 45" fill="none">
                <path d="M16.8035 10.0819V19.744L26.4656 4.20068H2.52051V10.0819H16.8035Z" fill="white" />
                <path d="M9.66205 29.8263L9.66205 20.1642L9.53674e-06 35.7075L23.9451 35.7075L23.9451 29.8263L9.66205 29.8263Z" fill="white" />
                <path d="M37.4142 36.3938C35.3925 36.3938 33.6465 35.9737 32.1762 35.1336C30.7146 34.2846 29.59 33.0856 28.8024 31.5366C28.0147 29.9787 27.6209 28.1452 27.6209 26.036C27.6209 23.9618 28.0147 22.1414 28.8024 20.5749C29.5988 18.9995 30.7103 17.7743 32.1368 16.8991C33.5634 16.0152 35.2393 15.5732 37.1648 15.5732C38.4075 15.5732 39.5803 15.7745 40.683 16.1771C41.7945 16.5709 42.7747 17.1835 43.6236 18.015C44.4813 18.8464 45.1552 19.9054 45.6453 21.1919C46.1354 22.4696 46.3805 23.9925 46.3805 25.7603V27.2175H29.8526V24.0143H41.8251C41.8164 23.1042 41.6194 22.2946 41.2344 21.5857C40.8493 20.8681 40.311 20.3036 39.6196 19.8922C38.937 19.4809 38.1406 19.2752 37.2304 19.2752C36.2589 19.2752 35.4056 19.5115 34.6705 19.9841C33.9353 20.448 33.3621 21.0606 32.9507 21.822C32.5482 22.5747 32.3425 23.4017 32.3337 24.3032V27.0994C32.3337 28.2721 32.5482 29.2786 32.977 30.1188C33.4058 30.9502 34.0053 31.5891 34.7755 32.0354C35.5457 32.473 36.4471 32.6918 37.4798 32.6918C38.1712 32.6918 38.797 32.5955 39.3571 32.403C39.9172 32.2017 40.4029 31.9085 40.8143 31.5234C41.2256 31.1383 41.5363 30.6614 41.7463 30.0925L46.1835 30.5914C45.9035 31.7641 45.3696 32.7881 44.5819 33.6633C43.803 34.5297 42.8053 35.2036 41.5888 35.6849C40.3723 36.1575 38.9808 36.3938 37.4142 36.3938ZM50.4008 36V15.8357H55.0087V19.1965H55.2187C55.5863 18.0325 56.2164 17.1354 57.1091 16.5053C58.0106 15.8664 59.0389 15.5469 60.1942 15.5469C60.4567 15.5469 60.7499 15.5601 61.0737 15.5863C61.4063 15.6038 61.682 15.6344 61.9008 15.6782V20.0498C61.6995 19.9797 61.38 19.9185 60.9424 19.866C60.5136 19.8047 60.0979 19.7741 59.6953 19.7741C58.8289 19.7741 58.0499 19.9622 57.3586 20.3386C56.6759 20.7061 56.1377 21.2181 55.7438 21.8745C55.35 22.5309 55.1531 23.2879 55.1531 24.1456V36H50.4008ZM73.0233 36.3938C71.0541 36.3938 69.3475 35.9606 67.9034 35.0942C66.4594 34.2278 65.3391 33.0156 64.5427 31.4578C63.7551 29.9 63.3612 28.0796 63.3612 25.9966C63.3612 23.9137 63.7551 22.0889 64.5427 20.5224C65.3391 18.9558 66.4594 17.7393 67.9034 16.8728C69.3475 16.0064 71.0541 15.5732 73.0233 15.5732C74.9924 15.5732 76.699 16.0064 78.1431 16.8728C79.5872 17.7393 80.703 18.9558 81.4907 20.5224C82.2871 22.0889 82.6853 23.9137 82.6853 25.9966C82.6853 28.0796 82.2871 29.9 81.4907 31.4578C80.703 33.0156 79.5872 34.2278 78.1431 35.0942C76.699 35.9606 74.9924 36.3938 73.0233 36.3938ZM73.0495 32.5868C74.1172 32.5868 75.0099 32.2936 75.7276 31.7072C76.4452 31.1121 76.9791 30.3157 77.3292 29.318C77.688 28.3203 77.8674 27.2088 77.8674 25.9835C77.8674 24.7495 77.688 23.6336 77.3292 22.6359C76.9791 21.6295 76.4452 20.8287 75.7276 20.2335C75.0099 19.6384 74.1172 19.3409 73.0495 19.3409C71.9555 19.3409 71.0453 19.6384 70.3189 20.2335C69.6013 20.8287 69.0631 21.6295 68.7042 22.6359C68.3542 23.6336 68.1791 24.7495 68.1791 25.9835C68.1791 27.2088 68.3542 28.3203 68.7042 29.318C69.0631 30.3157 69.6013 31.1121 70.3189 31.7072C71.0453 32.2936 71.9555 32.5868 73.0495 32.5868Z" fill="white" />
                <path d="M142.243 36.1279H137.044L146.509 9.24219H152.522L162 36.1279H156.801L149.62 14.7559H149.41L142.243 36.1279ZM142.413 25.5863H156.591V29.4983H142.413V25.5863Z" fill="white" />
                <path d="M116.453 13.3249V9.24219H137.904V13.3249H129.594V36.1279H124.763V13.3249H116.453Z" fill="white" />
                <path d="M95.9739 36.1279V9.24219H114.878V13.3249H100.844V20.624H117.897V24.7067H100.844V36.1279H95.9739Z" fill="white" />
                <path d="M90.6997 9.24219V36.1279H85.8293V9.24219H90.6997Z" fill="white" />
              </svg>
            </div>
            <h1 class="">Welcome To ZEROIFTA</h1>
            <p>Fuel smarter, drive farther—empowering every journey with ZeroIFTA. Turn every mile into a milestone of savings and success.</p>
          </div>
        </div>
        <!-- Authentication Right Side Form Area -->
        <div class="auth-right reg-right">
          <div class="container">

            <div class="authRight_inn">
              <div class="pb-4">
                <h3 class="blue pb-1">Signup</h3>
                <p class="gray1">Enter your details to get Register</p>
              </div>

              <form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="log_input mb-3">
    <label for="name" class="pb-1">Name</label>
    <input
      type="text"
      class="form-control login-input @error('name') is-invalid @enderror"
      id="name"
      placeholder="Type Your Name"
      name="name"
      value="{{ old('name') }}"
      required
      autofocus
    />
    @error('name')
    <span class="invalid-feedback" role="alert" style="display: block;">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="log_input mb-3">
    <label for="email" class="pb-1">Email</label>
    <input
      type="email"
      class="form-control login-input @error('email') is-invalid @enderror"
      id="email"
      placeholder="name@example.com"
      name="email"
      value="{{ old('email') }}"
      required
      autocomplete="email"
    />
    @error('email')
    <span class="invalid-feedback" role="alert" style="display: block;">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  <div class="log_input mb-3">
                  <label for="exampleFormControlInput1" class="pb-1">Phone</label>
                  <input
                    type="number"
                    class="form-control login-input @error('phone') is-invalid @enderror"
                    id="exampleFormControlInput1"
                    placeholder="Add Phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    autofocus />
                </div>

                @error('phone')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
  <div class="log_input mb-3 position-relative">
    <label for="password" class="pb-1">Password</label>
    <input
      type="password"
      class="form-control login-input @error('password') is-invalid @enderror"
      name="password"
      id="password"
      required
      placeholder="Type Password"
    />
    <div class="show-pass position-absolute" style="right: 10px; top: 50%; " onclick="togglePasswordVisibility('password', 'show-icon1', 'hide-icon1')">
      <span id="show-icon1" style="display: inline;">
        <!-- Eye icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#a5a9ad">
          <path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/>
        </svg>
      </span>
      <span id="hide-icon1" style="display: none;">
        <!-- Eye-off icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#a5a9ad">
          <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
        </svg>
      </span>
    </div>
    @error('password')
    <span class="invalid-feedback" role="alert" style="display: block;">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="log_input mb-3 position-relative">
    <label for="password_confirmation" class="pb-1">Confirm Password</label>
    <input
      type="password"
      class="form-control login-input @error('password_confirmation') is-invalid @enderror"
      name="password_confirmation"
      id="password_confirmation"
      required
      placeholder="Type Confirm Password"
    />
    <div class="show-pass position-absolute" style="right: 10px; top: 50%; " onclick="togglePasswordVisibility('password_confirmation', 'show-icon2', 'hide-icon2')">
      <span id="show-icon2" style="display: inline;">
        <!-- Eye icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#a5a9ad">
          <path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/>
        </svg>
      </span>
      <span id="hide-icon2" style="display: none;">
        <!-- Eye-off icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#a5a9ad">
          <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
        </svg>
      </span>
    </div>

  </div>
  <div class="btn-div log-btn text-center">
                  <button type="submit" class="mainBtn">Signup</button>
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
                  <span class="gray1">Already have an account?</span>
                  <span>
                    <a class="blue" href="{{route('login')}}">Sign In</a>
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
    crossorigin="anonymous"></script>
    <script>
function togglePasswordVisibility(inputId, showIconId, hideIconId) {
  const inputField = document.getElementById(inputId);
  const showIcon = document.getElementById(showIconId);
  const hideIcon = document.getElementById(hideIconId);

  if (inputField.type === "password") {
    inputField.type = "text";
    showIcon.style.display = "none";
    hideIcon.style.display = "inline";
  } else {
    inputField.type = "password";
    showIcon.style.display = "inline";
    hideIcon.style.display = "none";
  }
}
</script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>
