<?php require('lang.php'); require_once 'Zend/Gdata/YouTube.php'; // on charge la librairie YouTube de Zend ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Youtube COVER</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="liste.js"></script>
		<script type="text/javascript" src="info.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
		
		    <script src="//www.google.com/jsapi"></script> 
			<script> 
			  google.load("swfobject", "2.1");
			</script>
		
		<link rel="shortcut icon" type="image/png" href="images/icon.png" />
		
		<?php lang('<meta http-equiv="Content-Language" content="fr">', '<meta http-equiv="Content-Language" content="en">'); ?>
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<?php lang('<meta name="Title" lang="fr" content="Youtube COVER">', '<meta name="Title" lang="en" content="Youtube COVER">'); ?>
		<meta name="Identifier-url" content="http://youtubecover.williamagay.fr/">
		<meta name="Distribution" content="Global">
		<meta name="Rating" content="General">
		<meta name="Robots" content="index, follow">
		<meta name="Revisit-After" content="7 days">
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-15509303-13']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</head>
	
	<script type="text/javascript">
			$(function(){

				$('.item2').click(function() {
					id_derniere = $('div.count:last').attr("id");
					
					$.ajax({
					   type: "GET",
					   url: "loadmore.php",
					   data: "id_derniere="+id_derniere,
					   success: function(liste){
							$("#more").append(liste);
					   }
					 });
				});

			});
			</script>
	
	<body>
	
			<header>
				<img alt="logo" src="images/logo.png" height="70" class="logo" />

				<p class="info">
					<?php lang("Ce site est fait pour écouter des covers en continu au hasard ou d'en rechercher.", "This site is for listening to random music covers or to search them."); ?>
				</p>
			</header>
			
			<script type="text/javascript">
			$(document).ready( function () {
				/* ##########
					AFFICHAGE DYNAMIQUE DES VIDEOS
				########## */
				if($("#tv-frame")) // afficher une video au chargement de la page
				{
					<?php
						// Si un id est en $_GET
						if(isset($_GET['id']) AND !empty($_GET['id']))
						{
							$urlembed = 'http://www.youtube.com/embed/'.$_GET['id'];
							?>
							$("#tv-frame").html('<iframe width="713" height="402" src="<?php echo $urlembed; ?>?wmode=opaque" frameborder="0" allowfullscreen></iframe>');							
							<?php
						}
						else
						{
						?>
							var urlVideo = $("div.item:first").attr("id");
							$("#tv-frame").html('<iframe width="713" height="402" src="http://www.youtube.com/embed/'+urlVideo+'?wmode=opaque" frameborder="0" allowfullscreen></iframe>');
							
							var stateObj = { foo: "bar" };
							function change_my_url()
							{
							   history.pushState(stateObj, "page 2", "?id="+urlVideo);
							}
							change_my_url();
							
						<?php
						}
					?>
					}
				$("div.item").click( function() { // si on clique sur une miniature on affiche la vidéo
					var idyt = $(this).attr("id");
					var title_cover = $(this).attr("alt");
					$("#tv-frame").html('<iframe width="713" height="402" src="http://www.youtube.com/embed/'+$(this).attr("id")+'?wmode=opaque&autoplay=1" frameborder="0" allowfullscreen></iframe>');
					var stateObj = { foo: "bar" };
					function change_my_url()
					{
					   history.pushState(stateObj, "page 2", "?id="+idyt);
					}
					change_my_url();
					
				});
			});
			</script>
	
		<div class="tv-block">
			
			<!-- TV frame width: & height:  -->
			
			<div id="tv-frame">
				
			</div>
			
		</div>
		
		<!--<div id="liste">
			<div id="liste_header">
			<h3>
				<?php 
				if(isset($_GET['s']) AND !empty($_GET['s']))
				{
					$lang = lang('Recherche :', 'Search :');
					echo $lang.' "'.$_GET["s"].'"';
				}
				else
				{
					lang('COVER récentes', 'Recent COVER'); 
				}
				?>
			</h3>
			
			
			<img alt="<?php lang('Fermer', 'Close'); ?>" title="<?php lang('Fermer', 'Close'); ?>" src="images/close.png" id="liste_close" />
			
			<div id="block_item">
				
				<?php
					require_once('api_youtube/functions.php');
					
					$yt = new Zend_Gdata_YouTube(); // on crée une nouvelle instance YouTube
					$yt->setMajorProtocolVersion(2);
					$query = $yt->newVideoQuery();
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
				
				<!--<div id="more">
				
				</div>
				
				<div class="item2" style="height: 70px;background: #787878;">
					<div id="left" style="float:left;width: 100px;">
						<img alt="<?php lang('Plus...', 'More...'); ?>" src="images/down.png"style="margin-left: 20px; margin-top: 10px;" />
					</div>
					
					<div id="right" style="float:right;width: 250px;padding-top: 10px;margin-top: 17px;">
					<b><?php echo lang('Charger plus de covers', 'Load more covers'); ?></b>
					</div>
				</div>-->
				
			</div>
			
			</div>
		</div>-->
		
			<div class="cmd">
				<img src="images/prev.png" id="prev" class="opa" title="<?php lang('Précédent', ''); ?>"/>
				<img src="images/next.png" id="next" class="opa" title="<?php lang('Suivant', 'Next'); ?>"/>
			</div>
			
			<script type="text/javascript">
			$(function(){

				var count = 1;
				$('#prev').hide();
				
				$('#cmd').click(function() {
					if(count==1)
					{
						$('#prev').hide();
					}
					else
					{
						$('#prev').show();
					}
				});
				
				$('#next').click(function() {
					count++;
					/* On appel */
					$.ajax({
					   type: "GET",
					   url: "cmd.php",
					   data: "count="+count+"&s=<?php echo $_GET['s']; ?>",
					   success: function(msg){
								$("#tv-frame").empty().append(msg);
					   }
					 });
				});
				
				$('#prev').click(function() {
					count--;
					/* On appel */
					$.ajax({
					   type: "GET",
					   url: "cmd.php",
					   data: "count="+count+"&s=<?php echo $_GET['s']; ?>",
					   success: function(msg){
								$("#tv-frame").empty().append(msg);
					   }
					 });				});

			});
			</script>
			
			<div id="recherche">
			
				<form action="." method="GET">
				
				<label for="champ_recherche"><h2><?php lang('Rechercher une cover', 'Search a cover'); ?></h2></label>
				
				<script type="text/javascript">
				$(function(){

					/* On focus on #champ_recherche, empty the input */
					
					$('#champ_recherche').focus(function() {
						$('#champ_recherche').val("");
					});

				});
				</script>
				
				<input type="text" placeholder="<?php 
				if(isset($_GET['s']) AND !empty($_GET['s']))
				{
					echo $_GET["s"];
				}
				else
				{
					lang('Un titre de musique...', 'Title of a music...');
				}
				?>" id="champ_recherche" name="s" />
				
					<br/>
				
				<button id="btn_search"><?php lang('Rechercher...', 'Search...'); ?></button>
				
				</form>
				
			</div>
			
			<footer>
				<p><?php lang('Développé par', 'Developped by'); ?> <a href="http://www.williamagay.com/">William AGAY - 2010</a>
				
				<br/>
				<br/>
			</footer>
	
	</body>
</html>