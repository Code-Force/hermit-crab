<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="description" content="Travel Blog">
	<meta name="keywords" content="travel,blog,writing,articles">
	<meta name="author" content="Code Force">
	
	<title>Travelled Writers</title>
	
	<!-- fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Rasa:400,700" rel="stylesheet">
	<!-- end fonts -->
	
	<!-- stylesheet -->
	<link href="<?= base_url(); ?>assets/styles/main.css" rel="stylesheet">
	<!-- end stylesheet -->
	
	<!-- scripts -->
	<script src="<?= base_url(); ?>assets/scripts/vendors/head.min.js"></script>
	<script>
		head.load(
			{ jQuery: 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js' },
			{ turbolinks: 'assets/scripts/vendors/turbolinks.min.js' },
			{ modok: 'assets/scripts/modok.js' },
			{ fontAwesome: 'https://use.fontawesome.com/72cb2b2ecf.js' }
		);
	</script>
	<!-- end scripts -->
</head>
<body>
<header class="header">
	<?= $header_snippets['user_nav_html']; ?>
</header>
	<h1><?php echo $title; ?></h1>