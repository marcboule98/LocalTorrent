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

			mostrarArchivosVideo(data, ruta, titulo);
			$("#tituloPelicula").text(titulo);
			$("#openModal").addClass("verModal");
		},
		error: function(data) {}
	});	
}

function mostrarArchivosVideo(data, ruta, titulo){
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
			`<li onclick="mostrarVideo('`+ data[i] +`', '`+ ruta +`', '`+ titulo +`')">`+ titulo +`</li>`
		);
	}
}

function mostrarVideo(url, ruta, titulo){
	$("#openModal").removeClass("verModal");
	$("#openModalVideo").addClass("verModal");

	var tipo = "video/mp4";

	if (url.indexOf(".mp4") > -1 || url.indexOf(".mpg") > -1 || url.indexOf(".mpeg")> -1) {
		tipo = "video/mp4";
	}else if(url.indexOf(".ogg")){
		tipo = "video/ogg";
	}else if (url.indexOf(".webm")) {
		tipo = "video/webm; codecs='vp8, vorbis'";
	}else if (url.indexOf(".mkv")) {
		tipo = "video/x-matroska; codecs='theora, vorbis'";
	}else if (url.indexOf(".mov")) {
		tipo = "video/mov";
	}

	$("#openModalVideo > div").html(`
			<a href="#" title="Cerrar" class="volver" onclick="volverOpenModal('`+ ruta +`', '`+ titulo +`')">
				<i class="fa fa-arrow-circle-left"></i>
			</a>
			<a href="#" title="Cerrar" class="close" onclick="pausarVideo()">X</a>
			<video controls autoplay controlsList="nodownload" preload="metadata">
		  		<source src="reproductor.php?tipo=`+ tipo +`&url=`+ url +`" type="`+ tipo +`">
				Tu navegador no soporta video. Recomendados. Chrome / Firefox / Opera
			</video>`);
}

function volverOpenModal(ruta, titulo) {
	pausarVideo();

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

			mostrarArchivosVideo(data, ruta);
			$("#tituloPelicula").text(titulo);
			$("#openModal").addClass("verModal");
		},
		error: function(data) {}
	});	
}

function pausarVideo() {
	$("video").each(function(){
    	$(this).get(0).pause();
	});

	$("#openModal").removeClass("verModal");
	$("#openModalVideo").removeClass("verModal");
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