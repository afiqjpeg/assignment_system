function validateRegister() {

    const name = document.getElementById("full_name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword =
        document.getElementById("confirm_password").value;

    if (
        name === "" ||
        email === "" ||
        password === "" || 
        confirmPassword === ""
    ) {
        alert("Please fill in all fields.");
        return false;
    }

    if (password.length < 8) {
        alert("Password must be at least 8 characters.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}


function validateLogin() {

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    if (email === "" || password === "") {
        alert("Please enter email and password.");
        return false;
    }

    return true;
}


function validateProject() {

    const title = document.getElementById("title").value.trim();
    const description =
        document.getElementById("description").value.trim();
    const techStack =
        document.getElementById("tech_stack").value.trim();
    const category =
        document.getElementById("category_id").value;
    const file =
        document.getElementById("project_file").value;

    if (
        title === "" ||
        description === "" || 
        techStack === "" ||
        category === "" ||
        file === ""
    ) {
        alert("Please complete all fields.");
        return false;
    }

    return true;
}