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
