function validateLogin() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (email == "") {
        alert("Please enter your email.");
        return false;
    }

    if (password == "") {
        alert("Please enter your password.");
        return false;
    }

    return true;
}

function searchProject() {
    let search = document.getElementById("search").value;

    fetch("search_assignment.php?search=" + search)
    .then(response => response.text())
    .then(data => {
        document.getElementById("projectResult").innerHTML = data;
    });
}