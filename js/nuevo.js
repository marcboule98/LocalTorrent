var timeoutSearch;

$('#search').on('keyup', function(){
	clearTimeout(timeoutSearch);

	timeoutSearch = setTimeout(function(){
		mejorTorrent($('#search').val().trim());
	}, 300);
});

function mejorTorrent(input){
	$("#search").prop("disabled", true);

	$.ajax({
		url : "ajax.php?peticion_ajax_key=nuevo_contenido&pagina=mejorTorrent&input=" + input,
		type: "GET",
		success: function(data) {
			data = JSON.parse(data);
			$("#search").prop("disabled", false);

			if(data["errors"] != undefined) {
				for(var i = 0; i < data["errors"].length; i++) {
					mostrarErrores(data["errors"][i]);
				}

				return;
			}
			
			mostrarTorrents(data["MejorTorrent"]);
			mostrarInfo(data["info"]);
		},
		error: function(data) {}
	});	
}

function mostrarTorrents(arrayTorrents) {
	$("#torrents").html('');
	for (var i = 0; i < arrayTorrents.length; i++) {
		$("#torrents").append(`<tr>
			<td>`+ arrayTorrents[i].nombre +`</td>
			<td>`+ arrayTorrents[i].idioma +`</td>
			<td>`+ arrayTorrents[i].calidad +`</td>
			<td>`+ (arrayTorrents[i].size / 1000000 ).toFixed(2) +` GB</td>
			<td>
				<i class="fa fa-arrow-circle-o-down" onclick="descargarTorrent('`+arrayTorrents[i].url+`', '`+arrayTorrents[i].nombre+`', '`+arrayTorrents[i].idioma+`', '`+arrayTorrents[i].calidad+`', '`+arrayTorrents[i].size+`')"></i>
			</td>
		</tr>`);
		
	}
}

function descargarTorrent(url, nombre, calidad, size) {
	$.ajax({
		url : "ajax.php?peticion_ajax_key=descargar_torrent&url=" + url + "&nombre=" + nombre + "&calidad=" + calidad + "&size=" + size,
		type: "GET",
		success: function(data) {
			data = JSON.parse(data);

			if(data["errors"] != undefined) {
				for(var i = 0; i < data["errors"].length; i++) {
					mostrarErrores(data["errors"][i]);
				}

				return;
			}

			mostrarInfo(data["info"]);
		},
		error: function(data) {}
	});	
}

function mostrarErrores(error){
	$("div.error").remove();
	$("div.container").prepend("<div class='error'>"+ error +"</div>");
}

function mostrarInfo(info){
	if(info != undefined) {
		for(var i = 0; i < info.length; i++) {
			$("div.info").remove();
			$("div.container").prepend("<div class='info'>"+ info[i] +"</div>");
		}
	}
}