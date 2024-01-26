const password = document.getElementById("password");
const password_retype = document.getElementById("password-retype");
const password_warning = document.getElementById("password-warning");
const password_retype_warning = document.getElementById("password-retype-warning");
const submit = document.getElementById("submit");

var password_string;
var password_retype_string;
password_retype_string = "";
password_retype.disabled = true;
submit.disabled = true;

password.addEventListener('input', e => {
    password_string = e.target.value.toLowerCase();
    if (password_string.length < 8) {
        password_warning.innerText = "Password must be 8 characters long!";
        password_warning.style.color = "red";
        submit.disabled = true;
        password_retype.value = "";
        password_retype_warning.innerText = "";
        password_retype.disabled = true;
    } else if (password_retype_string.length >= 8 && password_retype_string != password_string ) {
        submit.disabled = true;
        password_retype.value = "";
        password_retype_warning.innerText = "";
    }
     else {
        password_warning.innerText = "Good!";
        password_warning.style.color = "green";
        password_retype.disabled = false;
    }
});

password_retype.addEventListener('input', e => {
    password_retype_string = e.target.value.toLowerCase();
    if (password_string != password_retype_string) {
        password_retype_warning.innerText = "Passwords don't match!";
        password_retype_warning.style.color = "red";
        submit.disabled = true;

    } else {
        password_retype_warning.innerText = "Match!";
        password_retype_warning.style.color = "green";
        if (password_string.length >= 8) {
            submit.disabled = false;
        }

    }
});