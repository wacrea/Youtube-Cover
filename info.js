$(function(){

	/* Par défaut, la liste est fermée au chargement */
	$('#info').hide();
	
	/* Ouvrir la liste */
	$('#info_btn_ouverture').click(function() {
		$(this).fadeOut('50');
		$('#info').show('200');
	});
	
	/* Fermer la liste */
	$('#info_close').click(function() {
		$('#info').hide('200');
		$('#info_btn_ouverture').fadeIn('50');
	});
	
});