<?php
require_once 'Zend/Gdata/YouTube.php'; // on charge la librairie YouTube de Zend

	/******** FONCTIONS POUR L'API YOUTUBE ********/
	// On recupère l'url du player flash et une miniature de la video (format 120*90)
	// et on affiche la miniature en mettant l'url du player en id (pour le récupérer avec JQuery après)
	function afficheMiniature($video)
	{
		$miniature = $video->getVideoThumbnails();
		?>
			<div class="item" id="<?php echo $video->getVideoID() .'" src="' . $miniature[0]['url']; ?>">
				
				<div id="left" style="float:left;height: 100px;width: 100px;">
				<img title="<?php lang('Lire', 'Play'); ?>" class="videoThumb" src="<?php echo $miniature[0]['url']; ?>" alt="<?php lang('Miniature', 'Thumb'); ?>" />
				</div>
				
				<div id="right" style="font-size: 15px;float:right;height:100px;width: 250px;padding-top: 10px;">
				<?php echo $video->getVideoTitle(); ?>
				</div>
			</div>
		<?php
	}

	// fonction permettant d'afficher les vidéos provenant d'un flux
	function get_results($videos)
	{
	    $count = 1;
		// echo count($videos);
	    foreach ($videos as $video) {
			echo '<div class="count" id="'.$count.'">';
		afficheMiniature($video);
			echo '</div>';
		if($count==25)
			break;
		$count++;
	    }
	}
?>