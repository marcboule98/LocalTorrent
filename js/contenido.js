$("#search").on("keyup", function(){
	var searchValue = $(this).val().toLowerCase();

	$("div.item").each(function(index, element){
		var itemText = $(element).children().eq(1).text().toLowerCase();

		if(searchValue == "") {
			$(element).css({"display" : "inline-block"});
		} else if(itemText.indexOf(searchValue) == -1) {
			$(element).css({"display" : "none"});
		} else if(itemText.indexOf(searchValue) > -1) {
			$(element).css({"display" : "inline-block"});
		}
	});
});

function obtenerArchivos(ruta) {
	alert(ruta);
}