$("#infoClick").hide();

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

function obtenerArchivos(ruta, titulo) {
	$.ajax({
		url : "ajax.php?peticion_ajax_key=obtener_rutas_contenido&ruta=" + ruta,
		type: "GET",
		success: function(data) {
			data = JSON.parse(data);

			if(data["errors"] != undefined) {
				for(var i = 0; i < data["errors"].length; i++) {
					mostrarErrores(data["errors"][i]);
				}

				return;
			}

			mostrarArchivosVideo(data);
			$("#tituloPelicula").text(titulo);
			location.href = "#openModal";
		},
		error: function(data) {}
	});	
}

function mostrarArchivosVideo(data){
	$("#listaVideos").html("");
	$("#infoClick").show();

	if(data.length > 0) {
		$("#infoClick").text("Haz click sobre el archivo que quiera reproducir.");
	} else {
		$("#infoClick").text("No hay ningun archivo disponible para visualizar.");
	}

	for (var i = 0; i < data.length; i++) {
		var titulo = data[i].split("/");

		titulo = titulo[titulo.length-1];
		$("#listaVideos").append(
			`<li onclick="mostrarVideo('`+ data[i] +`')">`+ titulo +`</li>`
		);
	}
}

function mostrarVideo(url){
	var tipo = "video/mp4";

	if (url.indexOf(".mp4") || url.indexOf(".mpg") || url.indexOf(".mpeg")) {
		tipo = "video/mp4";
	}else if(url.indexOf(".ogg")){
		tipo = "video/ogg";
	}else if (url.indexOf(".webm")) {
		tipo = "video/webm";
	}else if (url.indexOf(".mkv")) {
		tipo = "video/x-matroska; codecs='theora, vorbis'";
	}else if (url.indexOf(".mov")) {
		tipo = "video/mov";
	}

	$("#openModal > div").html(`
		<a href="#close" title="Cerrar" class="close">X</a>
		<video controls>
	  		<source src="reproductor.php?tipo=`+ tipo +`&url=`+ url +`" type="`+ tipo +`">
			Tu navegador no soporta video. Recomendados. Chrome / Firefox / Opera
		</video>
	`);
}

function mostrarErrores(error){
	$("div.error").remove();
	$("div.info").remove();
	$("div.container").prepend("<div class='error'>"+ error +"</div>");
}

function mostrarInfo(info){
	if(info != undefined) {
		for(var i = 0; i < info.length; i++) {
			$("div.info").remove();
			$("div.error").remove();
			$("div.container").prepend("<div class='info'>"+ info[i] +"</div>");
		}
	}
}