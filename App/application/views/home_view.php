<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="home__feed">
	<div class="container">
		<?= $header_snippets['quick_nav_html']; ?>
		<div class="stories__holder">
			<?php
			foreach ($stories as $story) {
				?>
				<div class="story">
					<h3><?= $story['story_title']; ?></h3>
					<p><?= $story['description']; ?></p>
					<a href="<?= base_url().'stories/'.$story['slug']; ?>">View Story</a>
				</div>
				<?php
			}
			?>
		</div>

	</div>
</div>
