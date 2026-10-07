function validateRegister() {

    let fullName = document.getElementById("full_name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (fullName == "") {

        alert("Please enter your full name.");
        return false;

    }

    if (email == "") {

        alert("Please enter your email.");
        return false;

    }

    if (!email.includes("@")) {

        alert("Please enter a valid email.");
        return false;

    }

    if (password == "") {

        alert("Please enter your password.");
        return false;

    }

    if (password.length < 6) {

        alert("Password must be at least 6 characters.");
        return false;

    }

    if (password != confirmPassword) {

        alert("Password does not match.");
        return false;

    }

    return true;
}


function validateLogin() {

    let email = document.getElementById("login_email").value;
    let password = document.getElementById("login_password").value;

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


function validateAssignment() {

    let title = document.getElementById("assignment_title").value;
    let description = document.getElementById("assignment_description").value;

    if (title == "") {

        alert("Please enter assignment title.");
        return false;

    }

    if (description == "") {

        alert("Please enter assignment description.");
        return false;

    }

    return true;
}


function validateSubmission() {

    let assignment = document.getElementById("assignment_id").value;
    let file = document.getElementById("assignment_file").value;

    if (assignment == "") {

        alert("Please select an assignment.");
        return false;

    }

    if (file == "") {

        alert("Please select a file.");
        return false;

    }

    return true;
}


function searchAssignment() {

    let search = document.getElementById("search").value;

    fetch("search_assignment.php?search=" + search)

        .then(response => response.text())

        .then(data => {

            document.getElementById("assignmentResult").innerHTML = data;

        });

}