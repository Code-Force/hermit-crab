<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="home">
	<div class="container-fluid">
		<?= $header_snippets['quick_nav_html']; ?>
		<div class="home__grid row">
			<?php foreach ($stories as $key=>$story) { ?>
			<a href="<?= base_url().'stories/'.$story['slug']; ?>">
				<div class="grid__story-col col-md-20 col-xs-30">
					<div class="story-col__story">
						<div class="story__image-wrapper">
							<img class="image-wrapper__image" src="<?= base_url().'assets/users/'.$story['folder'].'/stories/'.$story['album'].'/'.$story['story_cover'] ?>" alt="<?= $story['story_title']; ?>">
						</div>
						<div class="story__info">
							<h2 class="info__title"><?= $story['story_title']; ?></h2>
							<p class="info__location">
								<i class="location__pin fa fa-map-marker" aria-hidden="true"></i>
								<span class="location__name"><?= $story['location']; ?></span>
							</p>
						</div>
						<!--<p><?= $story['description']; ?></p>
						<a href="<?= base_url().'stories/'.$story['slug']; ?>">View Story</a>-->
					</div>
				</div>
				<?php if(($key + 1) % 3 == 0) { ?>
				<div class="clearfix hidden-xs hidden-sm"></div>
				<?php } ?>
				<?php if(($key + 1) % 2 == 0) { ?>
				<div class="clearfix visible-xs visible-sm"></div>
				<?php } ?>
			</a>
			<?php } ?>
		</div>
	</div>
</div>
