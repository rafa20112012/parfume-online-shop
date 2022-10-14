function fValidateLogin() {
	if (document.getElementById("txtNumeUtilizator").value.length < 5) {
		alert("Username must be at least 5 characters long");
		document.getElementById("txtNumeUtilizator").focus();
		return false;
	}
	if (document.getElementById("txtParola").value.length < 5) {
		alert("The password must contain at least 5 characters");
		document.getElementById("txtParola").focus();
		return false;
	}
	return true;
}