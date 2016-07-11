<div class="story">
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
				<time class="header__date">
					<?php
						$date = strtotime($story['date_posted']);
						$date = date("F t, Y", $date);
						echo $date;
					?>
				</time>
				<div class="header__title" data-editable data-name="story-title">
					<h1><?php echo $title; ?></h1>
				</div>
				<div class="header__author">
					<a href="" class="author__image">
						<img />
					</a>
					<a href="" rel="author" class="author__name">
						<?php echo $story['user_id']; ?>
					</a>
				</div>
			</header>

			<!-- story content -->
			<main class="content__body" data-editable data-name="story-content" >
				<?php echo $story['story']; ?>
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