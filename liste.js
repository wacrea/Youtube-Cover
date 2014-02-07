/* Liste */

$(function(){

	/* Par d�faut, la liste est ferm�e au chargement */
	$('#liste').hide();
	
	/* Ouvrir la liste */
	$('#liste_btn_ouverture').click(function() {
		$(this).fadeOut('50');
		$('#liste').show('200');
	});
	
	/* Fermer la liste */
	$('#liste_close').click(function() {
		$('#liste').hide('200');
		$('#liste_btn_ouverture').fadeIn('50');
	});
	
});