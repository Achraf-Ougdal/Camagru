
function validateForm()
{

	let firstNameValue = document.getElementById("firstName").value;
	let lastNameValue = document.getElementById("lastName").value;
	let emailValue = document.getElementById("email").value;
	let passwordValue = document.getElementById("password").value;
	let confirmedPasswordValue = document.getElementById("confirmedPassword").value;
	let errorField = document.getElementById("errorMessage");

	let reg = /^[a-zA-Z]+$/;

	if (firstNameValue.trim()=="" || lastNameValue.trim()=="")
	{
		errorField.innerText = "First and last name should not be empty";
		return false;
	}

	if (firstNameValue.length > 30)
	{
		errorField.innerText = "First name should be less than 30 characters long";
		return false;
	}

	if (lastNameValue.length > 30)
	{
		errorField.innerText = "Last name should be less than 30 characters long";
		return false;
	}

	if (!reg.test(firstNameValue) || !reg.test(lastNameValue))
	{
		errorField.innerText = "First and last name should contain only characters";
		return false;
	}

	let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	if(!regex.test(String(emailValue).toLowerCase()))
	{
	    errorField.innerText = "Please enter a valid email adress";
	    return false;
	}

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
