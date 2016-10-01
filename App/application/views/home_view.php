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
						<div class="home-story__quick-actions">
							<div class="home-story__quick-action home-story__quick-action--share">
								<i class="home-story__action-icon fa fa-share" aria-hidden="true" title="Share"></i>
							</div>
							<div class="home-story__quick-action home-story__quick-action--read-later">
								<i class="home-story__action-icon fa fa-clock-o" aria-hidden="true" title="Read later"></i>
							</div>
							<div class="home-story__quick-action home-story__quick-action--description">
								<i class="home-story__action-icon fa fa-align-left" aria-hidden="true" title="Description"></i>
							</div>
							<div class="home-story__quick-action home-story__quick-action--like">
								<i class="home-story__action-icon fa fa-heart" aria-hidden="true" title="Like"></i>
							</div>
						</div>
						<div class="home-story__description">
							<p><?= $story['description']; ?></p>
						</div>
						<!--<p><?= $story['description']; ?></p>
						<a href="<?= base_url().'stories/'.$story['slug']; ?>">View Story</a>-->
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
