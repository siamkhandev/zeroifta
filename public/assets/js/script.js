// Header User Drop DOwn

function toggleDropdown() {
    var dropdown = document.getElementById("myDropdown");
    // Check if dropdown is visible
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

// // Close the dropdown if the user clicks outside of it
// window.onclick = function (event) {
//     if (!event.target.matches(".dropbtn")) {
//         var dropdown = document.getElementById("myDropdown");
//         if (dropdown.style.display === "block") {
//             dropdown.style.display = "none";
//         }
//     }
// };
document.addEventListener("DOMContentLoaded", function () {
    const themeCheckbox = document.getElementById("themeCheckbox");

    themeCheckbox.addEventListener("change", function () {
        const isDarkMode = this.checked;
        const theme = isDarkMode ? "dark" : "light";

        // Apply the theme immediately
        document.documentElement.classList.toggle("dark", isDarkMode);

        // Send AJAX request to save the theme
        fetch("/update-theme", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ theme }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data.message); // Optional success message
            })
            .catch((error) => {
                console.error("Error updating theme:", error);
            });
    });
});