
function validateForm()
{

    let passwordValue = document.getElementById("password").value;
    let confirmedPasswordValue = document.getElementById("confirmedPassword").value;
    let errorField = document.getElementById("errorMessage");

    if (passwordValue.length < 8)
    {
        errorField.innerText = "password should contain be at least 8 characters";
        return false;
    }

    if (passwordValue.length > 30)
    {
        errorField.innerText = "password should be less than 30 characters long";
        return false;
    }

    if (confirmedPasswordValue !== passwordValue)
    {
        errorField.innerText ="password doesn't match the one above";
        return false;
    }
    return true;
}