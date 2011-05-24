<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title><?= $title ?></title>

<link type="text/css" rel="stylesheet" href="<?= css::minify() ?>" />

<script type="text/javascript">
	var URL = '<?= URL ?>';
</script>

<script type="text/javascript" src="<?= js::minify() ?>"></script>

<link rel="alternate" type="application/rss+xml" title="fftwirling.fr RSS Feed" href="<?= link::href( 'actu', 'rss' ) ?>" /> 