$(document).ready(function(){
	$("#registro").hide();
})

$("#registrar").click(function(){
	$("#registro").show();
	$("#login").hide();
});

$("#iniciarSession").click(function(){
	$("#registro").hide();
	$("#login").show();
});