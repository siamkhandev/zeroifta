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
  <style>
    /* Add shadow and padding to the card */
    .card-profile-bottom {
        border-radius: 15px;
        border: none;
        padding: 20px;
        background-color: #f8f9fa;
    }

    /* Add subtle box shadow to Stripe input field */
    #card-element {
        background: #ffffff;
        font-size: 16px;
        color: #495057;
    }

    /* Highlight border on hover or focus */
    #card-element:hover, #card-element:focus {
        border-color: #007bff;
    }

    /* Style the button */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    /* Adjust spacing */
    .form-label {
        font-weight: bold;
    }
</style>
</head>

<body>
  <div class="subs-PlansMain">
    <div class="container">
      <!-- Header Area -->
      <div class="header-main">
        <div>
          <div class="head-left">
            <svg xmlns="http://www.w3.org/2000/svg" width="162" height="45" viewBox="0 0 162 45" fill="none">
              <path d="M16.8035 10.0822V19.7442L26.4656 4.20093H2.52051V10.0822H16.8035Z" fill="#092E75" />
              <path d="M9.6623 29.8263L9.6623 20.1642L0.000253677 35.7075L23.9453 35.7075L23.9453 29.8263L9.6623 29.8263Z" fill="#092E75" />
              <path d="M37.4145 36.3938C35.3929 36.3938 33.6469 35.9737 32.1766 35.1336C30.715 34.2846 29.5904 33.0856 28.8027 31.5366C28.0151 29.9787 27.6212 28.1452 27.6212 26.036C27.6212 23.9618 28.0151 22.1414 28.8027 20.5749C29.5991 18.9995 30.7106 17.7743 32.1372 16.8991C33.5637 16.0152 35.2397 15.5732 37.1651 15.5732C38.4079 15.5732 39.5806 15.7745 40.6834 16.1771C41.7949 16.5709 42.7751 17.1835 43.624 18.015C44.4817 18.8464 45.1556 19.9054 45.6457 21.1919C46.1358 22.4696 46.3808 23.9925 46.3808 25.7603V27.2175H29.853V24.0143H41.8255C41.8167 23.1042 41.6198 22.2946 41.2347 21.5857C40.8497 20.8681 40.3114 20.3036 39.62 19.8922C38.9374 19.4809 38.141 19.2752 37.2308 19.2752C36.2593 19.2752 35.406 19.5115 34.6708 19.9841C33.9357 20.448 33.3624 21.0606 32.9511 21.822C32.5485 22.5747 32.3429 23.4017 32.3341 24.3032V27.0994C32.3341 28.2721 32.5485 29.2786 32.9774 30.1188C33.4062 30.9502 34.0057 31.5891 34.7759 32.0354C35.546 32.473 36.4475 32.6918 37.4802 32.6918C38.1716 32.6918 38.7973 32.5955 39.3575 32.403C39.9176 32.2017 40.4033 31.9085 40.8146 31.5234C41.226 31.1383 41.5367 30.6614 41.7467 30.0925L46.1839 30.5914C45.9038 31.7641 45.37 32.7881 44.5823 33.6633C43.8034 34.5297 42.8057 35.2036 41.5892 35.6849C40.3727 36.1575 38.9811 36.3938 37.4145 36.3938ZM50.4012 36V15.8357H55.009V19.1965H55.2191C55.5867 18.0325 56.2168 17.1354 57.1095 16.5053C58.0109 15.8664 59.0393 15.5469 60.1945 15.5469C60.4571 15.5469 60.7503 15.5601 61.0741 15.5863C61.4066 15.6038 61.6823 15.6344 61.9011 15.6782V20.0498C61.6998 19.9797 61.3804 19.9185 60.9428 19.866C60.514 19.8047 60.0982 19.7741 59.6957 19.7741C58.8292 19.7741 58.0503 19.9622 57.3589 20.3386C56.6763 20.7061 56.138 21.2181 55.7442 21.8745C55.3504 22.5309 55.1535 23.2879 55.1535 24.1456V36H50.4012ZM73.0236 36.3938C71.0545 36.3938 69.3479 35.9606 67.9038 35.0942C66.4597 34.2278 65.3395 33.0156 64.5431 31.4578C63.7554 29.9 63.3616 28.0796 63.3616 25.9966C63.3616 23.9137 63.7554 22.0889 64.5431 20.5224C65.3395 18.9558 66.4597 17.7393 67.9038 16.8728C69.3479 16.0064 71.0545 15.5732 73.0236 15.5732C74.9928 15.5732 76.6994 16.0064 78.1435 16.8728C79.5875 17.7393 80.7034 18.9558 81.491 20.5224C82.2875 22.0889 82.6857 23.9137 82.6857 25.9966C82.6857 28.0796 82.2875 29.9 81.491 31.4578C80.7034 33.0156 79.5875 34.2278 78.1435 35.0942C76.6994 35.9606 74.9928 36.3938 73.0236 36.3938ZM73.0499 32.5868C74.1176 32.5868 75.0103 32.2936 75.728 31.7072C76.4456 31.1121 76.9795 30.3157 77.3295 29.318C77.6884 28.3203 77.8678 27.2088 77.8678 25.9835C77.8678 24.7495 77.6884 23.6336 77.3295 22.6359C76.9795 21.6295 76.4456 20.8287 75.728 20.2335C75.0103 19.6384 74.1176 19.3409 73.0499 19.3409C71.9559 19.3409 71.0457 19.6384 70.3193 20.2335C69.6017 20.8287 69.0634 21.6295 68.7046 22.6359C68.3545 23.6336 68.1795 24.7495 68.1795 25.9835C68.1795 27.2088 68.3545 28.3203 68.7046 29.318C69.0634 30.3157 69.6017 31.1121 70.3193 31.7072C71.0457 32.2936 71.9559 32.5868 73.0499 32.5868Z" fill="#092E75" />
              <path d="M142.244 36.1276H137.045L146.51 9.24194H152.523L162.001 36.1276H156.802L149.621 14.7556H149.411L142.244 36.1276ZM142.414 25.586H156.592V29.4981H142.414V25.586Z" fill="#092E75" />
              <path d="M116.454 13.3247V9.24194H137.905V13.3247H129.595V36.1276H124.764V13.3247H116.454Z" fill="#092E75" />
              <path d="M95.9746 36.1276V9.24194H114.879V13.3247H100.845V20.6237H117.898V24.7065H100.845V36.1276H95.9746Z" fill="#092E75" />
              <path d="M90.7005 9.24194V36.1276H85.8301V9.24194H90.7005Z" fill="#092E75" />
            </svg>
          </div>
        </div>
        <div class="right-opts">
          <div class="head-right">
            <div class="search-div">
              <div class="serch-tab">
                <input type="text" placeholder="Type Here" name="" id="">
                <span class="s-icon hs-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                    <circle cx="5" cy="5" r="4.3" stroke="" stroke-width="1.4"></circle>
                    <line x1="10.0101" y1="11" x2="8" y2="8.98995" stroke="" stroke-width="1.4" stroke-linecap="round"></line>
                  </svg>
                </span>
              </div>
            </div>
            <div class="opt-div">
              <div class="mob-menu">
                <div class="mobLogo-div">
                  <img src="assets/img/logo-blue.png" alt="ZeroIfta Logo">
                </div>
              </div>
              <div class="menu-opt">
                <div id="dark-themeIcon" class="dark-themeIcon hf-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                    <path d="M9 18C11.776 18 14.3114 16.737 15.9911 14.6675C16.2396 14.3613 15.9686 13.9141 15.5846 13.9872C11.2181 14.8188 7.20819 11.4709 7.20819 7.06303C7.20819 4.52398 8.5674 2.18914 10.7765 0.931992C11.117 0.738211 11.0314 0.221941 10.6444 0.150469C10.102 0.0504468 9.55158 8.21369e-05 9 0C4.03211 0 0 4.02578 0 9C0 13.9679 4.02578 18 9 18Z" fill=""></path>
                  </svg>
                </div>
                <div id="light-themeIcon" class="light-themeIcon hf-svg" style="display: none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11 4V1H13V4H11ZM11 23V20H13V23H11ZM20 13V11H23V13H20ZM1 13V11H4V13H1ZM18.7 6.7L17.3 5.3L19.05 3.5L20.5 4.95L18.7 6.7ZM4.95 20.5L3.5 19.05L5.3 17.3L6.7 18.7L4.95 20.5ZM19.05 20.5L17.3 18.7L18.7 17.3L20.5 19.05L19.05 20.5ZM5.3 6.7L3.5 4.95L4.95 3.5L6.7 5.3L5.3 6.7ZM12 18C10.3333 18 8.91667 17.4167 7.75 16.25C6.58333 15.0833 6 13.6667 6 12C6 10.3333 6.58333 8.91667 7.75 7.75C8.91667 6.58333 10.3333 6 12 6C13.6667 6 15.0833 6.58333 16.25 7.75C17.4167 8.91667 18 10.3333 18 12C18 13.6667 17.4167 15.0833 16.25 16.25C15.0833 17.4167 13.6667 18 12 18ZM12 16C13.1167 16 14.0625 15.6125 14.8375 14.8375C15.6125 14.0625 16 13.1167 16 12C16 10.8833 15.6125 9.9375 14.8375 9.1625C14.0625 8.3875 13.1167 8 12 8C10.8833 8 9.9375 8.3875 9.1625 9.1625C8.3875 9.9375 8 10.8833 8 12C8 13.1167 8.3875 14.0625 9.1625 14.8375C9.9375 15.6125 10.8833 16 12 16Z" fill=""></path>
                  </svg>
                </div>
                <div class="hf-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none">
                    <path d="M15.2901 15.29L14.0001 14V9C14.0001 5.93 12.3601 3.36 9.50005 2.68V2C9.50005 1.17 8.83005 0.5 8.00005 0.5C7.17005 0.5 6.50005 1.17 6.50005 2V2.68C3.63005 3.36 2.00005 5.92 2.00005 9V14L0.710051 15.29C0.0800515 15.92 0.520051 17 1.41005 17H14.5801C15.4801 17 15.9201 15.92 15.2901 15.29ZM12.0001 15H4.00005V9C4.00005 6.52 5.51005 4.5 8.00005 4.5C10.4901 4.5 12.0001 6.52 12.0001 9V15ZM8.00005 20C9.10005 20 10.0001 19.1 10.0001 18H6.00005C6.00005 19.1 6.89005 20 8.00005 20Z" fill=""></path>
                  </svg>
                </div>
                <div class="up-img">
                  <img src="assets/img/user-img.png" alt="ZeroIfta Image">
                </div>
                <div class="mob-menu">
                  <div id="hamburgerIcon" class="hamburger-icon">
                    ☰
                    <!-- Simple hamburger icon, you can replace this with an SVG or icon font -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Subscription Row -->
      <div class="user-subsPlnas">
        <div class="usp_inn">
          <div class="manage-comp mb-4">
            <div class="Filters-main mb-3 mb-md-4">
              <div class="sec1-style">
                <div class="subs_plan">
                  <div class="inHead-span">
                   
                  </div>
                  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-lg card-profile-bottom">
            <div class="card-body">
                <h4 class="text-center mb-4">Buy Subscription</h4>
                <form id="subscribe-form" action="{{ route('pay.demo') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="card-element" class="form-label">Credit or Debit Card</label>
                        <div id="card-element" class="p-3 border rounded shadow-sm">
                            <!-- Stripe Element will be inserted here -->
                        </div>
                        <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="mainBtn">
                            <i class="fas fa-credit-card"></i> Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
  var stripe = Stripe('pk_test_AvPEuYEvHgZr9uN2f8KxzfGn00wLRXCSAb');
  var elements = stripe.elements();
  var card = elements.create('card');
  card.mount('#card-element');

  card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  var form = document.getElementById('subscribe-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createPaymentMethod({
      type: 'card',
      card: card,
      billing_details: {
        name: '{{ Auth::user()->name }}',
      },
    }).then(function(result) {
      if (result.error) {
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } else {
        stripeTokenHandler(result.paymentMethod.id);
      }
    });
  });

  function stripeTokenHandler(paymentMethodId) {
    var form = document.getElementById('subscribe-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'payment_method');
    hiddenInput.setAttribute('value', paymentMethodId);
    form.appendChild(hiddenInput);

    form.submit();
  }
</script>
</html>