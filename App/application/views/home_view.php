<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
	<h1>Welcome to being a towel</h1>

	<div id="body">
		No you're a towel
	</div>

	<div class="stories">
		<ul>
			<?
			$story_html = '';
			foreach ($stories as $story) {
				$story_html .= '
				<li class="story-link">
					<a href="'.base_url().'stories/'.$story['slug'].'">'.$story['story_title'].'</a>
				</li>';
			 }
			echo $story_html;
			?>
		</ul>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
