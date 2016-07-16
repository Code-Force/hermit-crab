<div class="story" data-id="<?= $story['story_id']; ?>">
	<div class="story__featured-image">
		<img src="<?= base_url(); ?>assets/images/stock/splash-bg.jpg" />
		<div class="featured-image__upload">
			<a href="">
				<i class="fa fa-camera upload__icon" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<section class="story__wrapper">
		<article class="wrapper__content container">
			<!-- article title, date and author -->
			<header class="content__header">
				<div class="header__date">
					<time class="date__created">
						<?php
							$date = strtotime($story['date_posted']);
							$date = date("F t, Y", $date);
							echo $date;
						?>
					</time>
					<div class="date__update">
						Last updated on 
						<time>
							<?php
								$date = strtotime($story['date_updated']);
								$date = date("F t, Y", $date);
								echo $date;
							?>
						</time>
					</div>
				</div>
				<div class="header__title" data-editable data-name="story-title">
					<h1><?= strip_tags($title); ?></h1>
				</div>
				<div class="header__author">
					<a href="<?= base_url() . $story['username'] ?>" class="author__image">
						<img src="<?= $story['profile'] ?>" />
					</a>
					<a href="<?= base_url() . $story['username'] ?>" rel="author" class="author__name">
						<?= $story['fullname']; ?>
					</a>
				</div>
			</header>

			<!-- story content -->
			<main class="content__body" data-editable data-name="story-content" >
				<?= $story['story']; ?>
			</main>

			<!-- tags -->
			<footer class="content__footer">

			</footer>
		</article>
	</section>
	<!-- comment section -->
	<section class="story__comment">
		<div class="container">

		</div>
	</section>
</div>