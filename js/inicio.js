setInterval(obtener_torrents, 5000);

obtener_torrents();

function obtener_torrents() {
	$.ajax({
		url : "ajax.php?peticion_ajax_key=obtener_torrents",
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
			actualizarTorrents(data);
		},
		error: function(data) {}
	});	
}

function eliminarTorrent(id, rutaBBDD) {
	$.ajax({
		url : "ajax.php?peticion_ajax_key=eliminar_torrent&idTorrent=" + id + "&rutaBBDD=" + rutaBBDD,
		type: "GET",
		success: function(data) {
			data = JSON.parse(data);

			if(data["errors"] != undefined) {
				for(var i = 0; i < data["errors"].length; i++) {
					mostrarErrores(data["errors"][i]);
				}

				return;
			}
			
			obtener_torrents();
			mostrarInfo(data["info"]);
		},
		error: function(data) {}
	});	
}

function actualizarTorrents(arrayTorrents) {
	$("#torrents").html("");

	for (var i = 0; i < arrayTorrents.length; i++) {
		$("#torrents").append(`<tr>
			<td>`+ arrayTorrents[i].nombre +`</td>
			<td>
				<div class="progressBarContainer `+ (arrayTorrents[i].completado == 0 ? "activo" : "acabado") +`" style="width: `+ arrayTorrents[i].completado +`%">
					<span>`+ arrayTorrents[i].completado +`%</span>
				</div>
			</td>
			<td>`+ arrayTorrents[i].ratioDescarga +`</td>
			<td>`+ arrayTorrents[i].ratioSubida +`</td>
			<td><i class="fa fa-trash" onclick="eliminarTorrent(`+ arrayTorrents[i].idTorrent +`, '`+ arrayTorrents[i].rutaBBDD +`')"></i></td>
		</tr>`);
	}
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