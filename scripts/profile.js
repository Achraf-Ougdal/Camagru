

function validateChangesForm(){
	
	let firstNameValue = document.getElementById("changeFirstName").value;
	let lastNameValue = document.getElementById("changeLastName").value;
	let emailValue = document.getElementById("changeEmail").value;
	let passwordValue = document.getElementById("changePassword").value;
	let errorField = document.getElementById("error");

	let reg = /^[a-zA-Z]+$/;
	let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

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
	
	if (firstNameValue.trim()!="")
	{
		if (!reg.test(firstNameValue))
		{
			errorField.innerText = "First name should contain only characters";
			return false;
		}
	}

	if (lastNameValue.trim()!="")
	{
		if (!reg.test(lastNameValue))
		{
			errorField.innerText = "Last name should contain only characters";
			return false;
		}
	}

	if (emailValue.length > 0)
	{
		if(!regex.test(String(emailValue).toLowerCase()))
		{
	    	errorField.innerText = "Please enter a valid email adress";
	    	return false;
		}
	}

	if (passwordValue.length < 8 && passwordValue.length > 0)
	{
		errorField.innerText = "password should contain be at least 8 characters";
		return false;
	}

	if (passwordValue.length > 30)
	{
		errorField.innerText = "password should be less than 30 characters long";
		return false;
	}

	return true;

}
