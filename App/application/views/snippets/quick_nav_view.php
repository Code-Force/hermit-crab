<div id="quick-nav">

	<?php
	$quick_nav_html = '';
	?>

	<div class="filters">
		<div class="filters__mood-container">
			<?php
			if (isset($categories)) {
				foreach ($categories as $category) {
					$quick_nav_html .= '
					<input type="checkbox" class="filter-category cat-icon" id="'.$category['handle'].'" checked="checked" name="filter-categories" value="'.$category['category_id'].'" /><label for="'.$category['handle'].'" style="background: url(\''.base_url().'/assets/images/map/icons/'.$category['handle_img'].'.png\')"></label> ';
				}
			}
			?>
			<div class="categories">
				<?php
					echo $quick_nav_html;
				?>
			</div>
			<a href="#" class="clear-filters" data-clear-type="checkbox" data-clear-identifier="category">Clear Categories</a>
		</div>
	</div>

	<!--<div id="nav-toggle"></div>-->
</div>