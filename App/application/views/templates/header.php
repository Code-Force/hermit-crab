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
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<!-- end fonts -->
	
	<!-- stylesheet -->
	<link href="<?= base_url(); ?>styles/main.css" rel="stylesheet">
	<!-- end stylesheet -->
	
	<!-- scripts -->
	<script src="<?php echo base_url('js/head.min.js');?>"></script>
	<script>
		head.load(
			{ jQuery: 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js' }
		);
	</script>
	<!-- end scripts -->
</head>
<body>
	<h1><?php echo $title; ?></h1>