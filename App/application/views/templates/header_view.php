<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="description" content="Travel Blog">
	<meta name="keywords" content="travel,blog,writing,articles">
	<meta name="author" content="Code Force">
	
	<!-- Favicons -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url(); ?>assets/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url(); ?>assets/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url(); ?>assets/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assets/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url(); ?>assets/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url(); ?>assets/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url(); ?>assets/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>assets/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>assets/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url(); ?>assets/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url(); ?>assets/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url(); ?>assets/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- end favicons -->
	
	<title>Travelled Writers</title>
	
	<!-- fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Rasa:400,700" rel="stylesheet">
	<!-- end fonts -->
	
	<!-- stylesheet -->
	<link href="<?= base_url(); ?>assets/styles/main.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/styles/vendors/content-tools/content-tools.min.css" rel="stylesheet">
	<!-- end stylesheet -->

	<!-- scripts -->
	<script src="<?= base_url(); ?>assets/scripts/vendors/head.min.js"></script>
	<script data-turbolinks-track="reload">
		head.load(
			{ jQuery: 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js' },
			{ turbolinks: '<?= base_url(); ?>assets/scripts/vendors/turbolinks.min.js' },
			{ smoothWheel: '<?= base_url(); ?>assets/scripts/vendors/smoothwheel.min.js' },
			{ generalScripts: '<?= base_url(); ?>assets/scripts/general-scripts.min.js' },
			{ modok: '<?= base_url(); ?>assets/scripts/modok.min.js' },
			{ contentLinks: '<?= base_url(); ?>assets/scripts/vendors/content-tools.min.js' },
			{ contentEditor: '<?= base_url(); ?>assets/scripts/content-editor.min.js' },
			{ fontAwesome: 'https://use.fontawesome.com/72cb2b2ecf.js' },
			{ quickNav: '<?= base_url(); ?>assets/scripts/quick-nav.js' }
			<?php
			if (isset($custom_js)) {
				foreach ($custom_js as $key => $value) {
					echo ',{ '.$key.': \''. $value.'\' } ';
				}
			}
			?>

		);
	</script>
	<!-- end scripts -->
</head>
<body>
<header class="header">
	<?= $header_snippets['user_nav_html']; ?>
</header>
