<?php include('config.php') ?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php l('head title') ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php l('head description') ?>">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--[if lte IE 8]><script src="<?php echo DOMAIN ?>/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="<?php echo DOMAIN ?>/assets/css/main.css">
	<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo DOMAIN ?>/assets/css/ie8.css" /><![endif]-->
	<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo DOMAIN ?>/assets/css/ie9.css" /><![endif]-->
	<link rel="stylesheet" href="<?php echo DOMAIN ?>/assets/css/bludit.css">

	<link rel="icon" type="image/png" href="<?php echo DOMAIN ?>/assets/favicon.png">

	<!-- Twitter Cards -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@bludit" />
	<meta name="twitter:title" content="<?php l('head title') ?>" />
	<meta name="twitter:description" content="<?php l('head description') ?>" />
	<meta name="twitter:image" content="https://cdn.bludit.com/images/bludit-twitter-cards.png" />

	<!-- Open Graph -->
	<meta property="og:locale" content="<?php echo $defaultLocale ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php l('head title') ?>" />
	<meta property="og:description" content="<?php l('head description') ?>" />
	<meta property="og:url" content="<?php echo $topbar['website'] ?>" />
	<meta property="og:image" content="https://cdn.bludit.com/images/bludit-facebook-cards.png" />
	<meta property="og:image:type" content="image/png" />
	<meta property="og:image:alt" content="Blue Bludit Logo" />

	<!-- Google hreflang tag -->
	<link rel="alternate" hreflang="en" href="<?php echo DOMAIN ?>" />
	<?php
		$tmpLanguages = $acceptedLanguages;
		unset($tmpLanguages[0]);
		foreach ($tmpLanguages as $lang) {
			echo '<link rel="alternate" hreflang="'.$lang.'" href="'.DOMAIN . '/' . $lang.'/"/>'.PHP_EOL;
		}
	?>

	<!-- Google Analytics tag -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-67610404-5', 'auto');
		ga('send', 'pageview');
	</script>
</head>
<body class="no-sidebar">
<div id="page-wrapper">

	<!-- NAVBAR -->
	<header id="header">
		<h1 id="logo"><a href="https://www.bludit.com">BLUDIT</a></h1>
		<nav id="nav">
		<ul>
			<li><a href="<?php echo $topbar['download'] ?>"><?php l('Download') ?></a></li>
			<li><a href="<?php echo $topbar['demo'] ?>"><?php l('Demo') ?></a></li>
			<li><a href="<?php echo $topbar['docs'] ?>"><?php l('Documentation') ?></a></li>
			<li><a href="<?php echo $topbar['themes'] ?>"><?php l('Themes') ?></a></li>
			<li><a href="<?php echo $topbar['plugins'] ?>"><?php l('Plugins') ?></a></li>
			<li><a href="<?php echo $topbar['donations'] ?>"><?php l('Donations') ?></a></li>
			<!-- <li><a href="<?php echo $topbar['pro'] ?>">Bludit PRO</a></li> -->
		</ul>
		</nav>
	</header>

	<!-- MAIN -->
	<article id="main">

		<header class="special container">
			<h2><?php l('plugins') ?></h2>
			<p class="little-description"><?php l('little-description-paragraph1') ?></p>
		</header>

		<section class="container">
			<input id="search" type="text" placeholder="<?php l('Search') ?>">
		</section>

		<section class="container">
		<div class="row">

			<?php
				$tmp = array();
				$directories = listDirectories(FILES, $regex='*', $sortByDate=false);
				foreach ($directories as $dir) {
					// Try to load the language file of the page
					$languageFile = $dir.DS.'en_US.json';
					if (file_exists($dir.DS.$defaultLocale.'.json')) {
						$languageFile = $dir.DS.$defaultLocale.'.json';
					}

					# Name and Description of the plugin
					$information = json_decode(file_get_contents($languageFile), true);
					if (isset($information['plugin-data'])) {
						$information = $information['plugin-data'];
					} elseif (isset($information['theme-data'])) {
						$information = $information['theme-data'];
					}

					# Metadata.json of the plugin
					$metadata = json_decode(file_get_contents($dir.DS.'metadata.json'), true);

					# Repository information, generated by python
					$repository = json_decode(file_get_contents($dir.DS.'repository.json'), true);

					$key = mb_strtolower($information['name'], 'UTF-8');
					$tmp[$key] = array_merge($information, $metadata, $repository);
				}

				// Sort alphabetical
				ksort($tmp);

				foreach ($tmp as $box) {
					echo '
					<div class="box-wrapper 6u 12u(narrower)">
					<section class="box">
						<p class="title">'.$box['name'].'</p>
						<p class="author">'.$box['author'].'</p>
						<p class="description">'.$box['description'].'</p>
						<p class="version">Version: '.$box['version'].'</p>
						<a class="box-button" target="_blank" href="'.$box['downloadMaster'].'"><i class="icon fa-download"></i> Download</a>
						<a class="box-button" target="_blank" href="'.$box['githubRepository'].'"><i class="icon fa-github"></i> Github</a>
						<a class="box-button" target="_blank" href="'.$box['website'].'"><i class="icon fa-link"></i> Website</a>
					</section>
					</div>
					';
				}
			?>

		</div>
		</section>

	</article>

	<!-- Footer -->
	<footer id="footer">

			<ul class="icons">
				<li><a href="https://twitter.com/bludit" class="icon circle fa-twitter"><span class="label">Twitter</span></a></li>
				<li><a href="https://www.facebook.com/bluditcms" class="icon circle fa-facebook"><span class="label">Facebook</span></a></li>
				<li><a href="https://plus.google.com/+bluditcms" class="icon circle fa-google-plus"><span class="label">Google+</span></a></li>
				<li><a href="https://github.com/dignajar/bludit" class="icon circle fa-github"><span class="label">Github</span></a></li>
			</ul>

			<ul class="copyright">
				<li>Bludit CMS &copy; <?php echo date('Y') ?></li><li><?php l('bludit-license') ?></li>
			</ul>

			<ul class="copyright">
				<li><a href="https://plugins.bludit.com">English</a></li>
				<li><a href="https://plugins.bludit.com/de/">Deutsch</a></li>
				<li><a href="https://plugins.bludit.com/es/">Español</a></li>
			</ul>

		</footer>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$("#search").on("keyup", function() {
		$("div.box-wrapper").hide();
		var textToSearch = $(this).val().toLowerCase();
		$("p.title, p.description").each( function() {
			var element = $(this).text().toLowerCase();
			if (element.indexOf(textToSearch)!=-1) {
				$(this).parent().parent().show();
			}
		});
	});
});
</script>

</body>
</html>