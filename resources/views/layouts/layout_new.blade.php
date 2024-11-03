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
        <link rel="stylesheet" href="{{asset('assets_new/css/style.css')}}" />

        <title>ZeroIfta</title>
    </head>
    <body>
        <div class="main">
            <div class="dash-main">
                @include('includes.sidebar_admin_new')
                <div class="dashboard-rigt">
                    <div class="container-fluid">
                        @include('includes.header_new')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
        ></script>
        <script>
            // Unified function to toggle theme
            function toggleTheme(isDark) {
                // Toggle dark-mode class based on current or passed state
                const darkMode = typeof isDark === "boolean" ? isDark : !document.body.classList.contains("dark-mode");

                document.body.classList.toggle("dark-mode", darkMode);

                // Update visibility of header icons
                document.getElementById("dark-themeIcon").style.display = darkMode ? "none" : "inline-block";
                document.getElementById("light-themeIcon").style.display = darkMode ? "inline-block" : "none";

                // Update sidebar switch state
                document.getElementById("themeCheckbox").checked = darkMode;
            }

            // Event listener for sidebar switch
            document.getElementById("themeCheckbox").addEventListener("change", function () {
                toggleTheme(this.checked);
            });

            // Event listeners for header icons
            document.getElementById("dark-themeIcon").addEventListener("click", function () {
                toggleTheme(true);
            });

            document.getElementById("light-themeIcon").addEventListener("click", function () {
                toggleTheme(false);
            });
        </script>
</html>