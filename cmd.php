<?php
	$count0 = $_GET['count'];
	
			require_once 'Zend/Gdata/YouTube.php';
			
					/* API Functions */
					
					function embedvideo($video)
					{
						?>
							<script type="text/javascript">
							
								var stateObj = { foo: "bar" };
								function change_my_url()
								{
								   history.pushState(stateObj, "page 2", "?id=<?php echo $video->getVideoID(); ?>");
								}
								change_my_url();
							
							</script>
							<iframe width="713" height="402" src="http://www.youtube.com/embed/<?php echo $video->getVideoID(); ?>?wmode=opaque&autoplay=1" frameborder="0" allowfullscreen></iframe>
						<?php
					}
					
					function get_results($videos)
					{
						$count = 1;
						foreach ($videos as $video) {
						embedvideo($video);
						if($count==1)
							break;
						$count++;
						}
					}
					
					/*****************/
					
					$yt = new Zend_Gdata_YouTube(); // on crée une nouvelle instance YouTube
					$yt->setMajorProtocolVersion(2);
					$query = $yt->newVideoQuery();
					$query->startIndex = $count0;
					$query->setOrderBy('relevance'); // les vidéos sont classé par pertinence
					$query->setTime('all_time'); // on souhaite afficher les vidéos qui ont été ajoutées n'importe quand
					
					// Définir la recherche
					
					if(isset($_GET['s']) AND !empty($_GET['s']))
					{
						$recherche = $_GET['s'].' cover';
						$query->setVideoQuery($recherche);
					}
					else
					{
						$query->setVideoQuery("cover");
					}

					// on récupère un flux XML avec la liste des vidéos
					$flux = $yt->getVideoFeed($query->getQueryUrl(2));
					

					// on affiche les miniatures 
					get_results($flux);
?>