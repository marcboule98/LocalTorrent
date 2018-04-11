var hide = 0;

$("#sideMenuHideButton").on("click", function() {
	if(hide == 0) {
		$("div.sideMenu").animate({
			marginLeft: '-'+ $("div.sideMenu").width() +'px'
		});
		hide = 1;
		$(this).text(" >> ");
	} else {
		$("div.sideMenu").animate({
			marginLeft: '0%'
		});
		hide = 0;
		$(this).text(" << ");
	}
});