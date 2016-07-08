<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
	<div class="stories">

<style>
	html, body, #map {
		height: 100vh;
		margin: 0px;
		padding: 0px
	}

	/* Limit the height to 300px */
	#map {
		height: 100vh;
	}
	.outer-box div:nth-child(2) {
		border: 1px solid #000;
		box-shadow: none !important;
		background: none;
		border-radius: 10px !important;
	}
	.outer-box div:nth-child(4) {
		border-radius: 10px !important;
	}
</style>
		<div id="map">
		</div>
		<!--<ul>
			<?
			/*$story_html = '';
			foreach ($stories as $story) {
				$story_html .= '
				<li class="story-link">
					<a href="'.base_url().'stories/'.$story['slug'].'">'.$story['story_title'].'</a>
				</li>';
			 }
			echo $story_html;*/
			?>
		</ul>-->
	</div>
</div>
