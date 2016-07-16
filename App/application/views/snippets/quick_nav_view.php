<div id="quick-nav">
	<div class="quick-nav__logo-holder">
		<a href="/">
			<img class="logo-holder__logo" src="<?= base_url(); ?>assets/images/logo/logo_badge--300.png" />
		</a>
	</div>
	<?php
	$quick_nav_html = '';
	?>

	<div class="filters">
		<div class="filters__mood-container">
			<?php

			if (isset($categories)) {

				foreach ($categories as $category) {
					$quick_nav_html .= '
				<div class="mood-container__category">
					<label><input type="checkbox" class="filter-category" checked="checked" name="filter-categories" value="'.$category['category_id'].'" /> '.$category['name'].'</label>
				</div>';
				}
				$quick_nav_html .= '
				<div class="mood-container__category">
					<a href="#" class="clear-filters" data-clear-type="checkbox" data-clear-identifier="category">Clear Categories</a>
				</div>';
			}
			?>
			<?php
			echo $quick_nav_html;
			?>
		</div>
	</div>

	<!--<div id="nav-toggle"></div>-->
</div>
<div id="filter-overlay">
	<div class="filter-overlay__the-cover">

	</div>
	<div class="filter-overlay__the-loader">

	</div>
</div>