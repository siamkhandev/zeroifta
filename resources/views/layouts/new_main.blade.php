<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->theme }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <!-- <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous" /> -->
  <!-- Data Table Css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href=" https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

  <!-- Custom Css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
  <link rel="icon" href="{{asset('assets/img/fav-icon.png')}}">
  <title>ZeroIfta</title>
</head>

<body class="{{auth()->user()->theme==='dark' ? 'dark-mode':''}}">

  <div class="main">
    <div class="dash-main">
      @if(Auth::user()->role=='admin')
      @include('includes.sidebar_admin_new')
      @elseif(Auth::user()->role=='company' || Auth::user()->role=='trucker')
      @include('includes.sidebar_company_new')
      @else
      @endif
      <div class="body-right">
        <div class="container-fluid">
          <div class="dashboard-rigt">
            @include('includes.header_new')
            @yield('content')
          </div>
        </div>
      </div>

      <!---------------------------------------- Dashboard Right Area End ----------------------------------------->
    </div>
  </div>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!-- <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script> -->
  <script src="{{asset('assets/chartjs.min.js')}}"></script>
  <script src="{{asset('assets/js/script.js')}}"></script>

  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Companies",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Unified function to toggle theme
      function toggleTheme(isDark) {
        // Determine dark mode state: if isDark is passed, use it; otherwise, toggle based on current state
        const darkMode = typeof isDark === "boolean" ? isDark : !document.body.classList.contains("dark-mode");

        // Toggle the dark-mode class on the body
        document.body.classList.toggle("dark-mode", darkMode);

        // Update the icons in the header
        if (darkMode==true) {
          document.getElementById("dark-themeIcon").style.display = "none";
          document.getElementById("light-themeIcon").style.display = "inline-block";
        } else {

          document.getElementById("dark-themeIcon").style.display = "inline-block";
          document.getElementById("light-themeIcon").style.display = "none";
        }

        // Update the sidebar toggle switch
        const themeCheckbox = document.getElementById("themeCheckbox");
        if (themeCheckbox) {
          themeCheckbox.checked = darkMode;
        }
      }

      // Synchronize state on page load
      function initializeTheme() {
        const themeCheckbox = document.getElementById("themeCheckbox");
        // Ensure the page starts in light mode by default
        var isDarkMode = "{{ auth::user()->theme === 'dark' ? 'true' : 'false' }}";
        toggleTheme(isDarkMode === "true");
        if(isDarkMode === "true"){
          document.body.classList.add("dark-mode");
          document.getElementById("dark-themeIcon").style.display = "none";
          document.getElementById("light-themeIcon").style.display = "inline-block";

          themeCheckbox.checked = true;
        }else{

            document.body.classList.remove("dark-mode"); // Remove dark-mode class
            document.getElementById("light-themeIcon").style.display = "none";
            document.getElementById("dark-themeIcon").style.display = "inline-block"; // Show dark theme icon
            themeCheckbox.checked = false;
        }





      }

      // Event listener for the sidebar toggle
      const themeCheckbox = document.getElementById("themeCheckbox");
      if (themeCheckbox) {
        themeCheckbox.addEventListener("change", function() {
          toggleTheme(this.checked);
        });
      }

      // Event listeners for header icons
      const darkThemeIcon = document.getElementById("dark-themeIcon");
      if (darkThemeIcon) {
        darkThemeIcon.addEventListener("click", function() {
          toggleTheme(true);
        });
      }

      const lightThemeIcon = document.getElementById("light-themeIcon");
      if (lightThemeIcon) {
        lightThemeIcon.addEventListener("click", function() {
          toggleTheme(false);
        });
      }

      // Initialize theme on page load
      initializeTheme();
    });
    document.addEventListener('DOMContentLoaded', function () {
    const darkModeIcon = document.querySelector('.dark-themeIcon');
    const lightModeIcon = document.querySelector('.light-themeIcon');

    // Fetch the user's preferred theme from the backend
    fetch('/get-theme')
        .then(response => response.json())
        .then(data => {
            document.body.classList.toggle('dark', data.theme === 'dark');
            toggleIcons(data.theme);
        });

    darkModeIcon.addEventListener('click', () => setTheme('dark'));
    lightModeIcon.addEventListener('click', () => setTheme('light'));

    function setTheme(theme) {
        document.body.classList.toggle('dark', theme === 'dark');
        toggleIcons(theme);

        // Update theme in the database
        fetch('/update-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ theme })
        });
    }

    function toggleIcons(theme) {
        darkModeIcon.style.display = theme === 'dark' ? 'none' : 'inline';
        lightModeIcon.style.display = theme === 'dark' ? 'inline' : 'none';
    }
});
  </script>


  <!-- Data Table Script -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js"></script>

  @yield('scripts')
  <script>
    new DataTable('#example');
  </script>






  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>
