$(document).ready(function(){
	$("#registrar").click(function(){
		$("#registro").show();
		$("#login").hide();	
	});

	$("#iniciarSession").click(function(){
		$("#registro").hide();
		$("#login").show();
	});
});

$("#formLogin").submit(function() {
	var nombreLogin = $("#nombreLogin").val().trim();
	var passwordLogin = $("#passwordLogin").val().trim();

	$("#nombreVacioLogin").hide();
	$("#passwordVacioLogin").hide();

	if(nombreLogin == "") {
		$("#nombreVacioLogin").show();
		return false;
	}

	if(passwordLogin == "") {
		$("#passwordVacioLogin").show();
		return false;
	}

	return true;
});

$("#formRegistro").submit(function() {
	var nombreRegitro = $("#nombreRegistro").val().trim();
	var emailRegistro = $("#emailRegistro").val().trim();
	var passwordRegistro = $("#passwordRegistro").val().trim();

	$("#nombreVacioRegistro").hide();
	$("#emailInvalidoRegistro").hide();
	$("#passwordVacioRegistro").hide();


	if(nombreRegitro == "") {
		$("#nombreVacioRegistro").show();
		return false;
	}

	if(!emailValido(emailRegistro)) {
		$("#emailInvalidoRegistro").show();
		return false;
  	}

	if(passwordRegistro == "") {
		$("#passwordVacioRegistro").show();
		return false;
	}

	return true;
});

function emailValido(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}