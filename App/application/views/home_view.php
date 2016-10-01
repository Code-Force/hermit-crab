<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="home">
	<div id="home-grid" class="home__grid">
		<?php foreach ($stories as $key=>$story) { ?>
			<div class="home__element" data-date="<?= $story['date_posted']; ?>">
				<a href="<?= base_url().'stories/'.$story['slug']; ?>">
					<div class="home-story">
						<div class="home-story__image-wrapper">
							<img class="home-story__image" src="<?= base_url().'assets/users/'.$story['folder'].'/stories/'.$story['album'].'/'.$story['story_cover'] ?>" alt="<?= $story['story_title']; ?>">
						</div>
						<div class="home-story__info">
							<h2 class="home-story__title"><?= $story['story_title']; ?></h2>
							<p class="home-story__location">
								<i class="home-story__location-pin fa fa-map-marker" aria-hidden="true"></i>
								<span class="home-story__location-name"><?= $story['location']; ?></span>
							</p>
						</div>
						<!--<p><?= $story['description']; ?></p>
						<a href="<?= base_url().'stories/'.$story['slug']; ?>">View Story</a>-->
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
