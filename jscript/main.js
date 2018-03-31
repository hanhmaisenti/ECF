function validateForm() {
    
    var email = document.forms["jsvalidator"]["email"].value;
    var fname = document.forms["jsvalidator"]["firstname"].value;
    var lname = document.forms["jsvalidator"]["lastname"].value;
    var error="";
    if (email == "") {
        error = error + "Email must be filled out\n"
    }    
    if (fname == "") {
        error = error + "First Name must be filled out\n"
    }
    if (lname == "") {
        error = error + "Last Name must be filled out\n"
    }
    if (error != "") {
        alert(error);
        return false;
    } else{
        return true;
    }
}