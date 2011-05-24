<div id="footer-top">
	<div class="align-left">
		<h4><a href="<?= link::href( 'sitemap', 'view' ) ?>">Sitemap ></a><span><a href="<?= link::href() ?>">Accueil</a></span></h4>
		<!--<p><a href="<?= link::href( 'video' )?>">Videos</a> | <a href="<?= link::href( 'artiste' ) ?>">Artistes</a></p>-->
	</div>
	<div class="align-right">
		<h2><a href="<?= link::href( 'user', 'login' ) ?>"><small><small>admin</small></small></a></h2>
	</div>
	<div class="clear"></div>
</div>
<!-- end of div#footer-top -->

<? global $time_start; ?>
<? $load = microtime( true ) - $time_start; ?>

<div id="footer-middle">
</div>

<div id="footer-bottom">
	<p>Temps de réponse <?=  $load ?> secondes</p>
</div>

<!--
<script type="text/javascript">
	var _gaq = _gaq || [];
	
	_gaq.push(['_setAccount', 'UA-21234025-1']);
	_gaq.push(['_trackPageview']);
	
	(function() {
		var ga = document.createElement('script');

		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

		var s = document.getElementsByTagName('script')[0];

		s.parentNode.insertBefore(ga, s);
	})();
</script>
-->