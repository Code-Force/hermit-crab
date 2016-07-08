<?php /*var_dump($story);*/ ?>
<div>
	<img src="<?php echo $story['story_cover']; ?>" />
</div>
<article class="container">
	<header>
		<time>
			<?php
				$date = strtotime($story['date_posted']);
				$date = date("F tS, Y", $date);
				echo $date;
			?>
		</time>
		<h1><?php echo $title; ?></h1>
		<a href="" rel="author"><?php echo $story['user_id']; ?></a>
	</header>

	<main>
		<?php echo $story['story']; ?>
	</main>
</article>