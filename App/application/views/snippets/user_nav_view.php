<div id="user-nav">
	<div class="row">
		<div class="col-xs-10 col-left">
			<div class="logo-holder">
				<a href="/">
					<img class="logo-holder__logo" src="<?= base_url(); ?>assets/images/logo/logo_badge--300.png" />
				</a>
			</div>
		</div>
		<div class="col-xs-40 col-center">
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
					<input type="checkbox" class="filter-category cat-icon" id="'.$category['handle'].'" name="filter-categories" value="'.$category['category_id'].'" /><label for="'.$category['handle'].'" title="'.$category['name'].'" style="background: url(\''.base_url().'/assets/images/map/icons/'.$category['handle_img'].'.png\')"></label> ';
							}
						}
						?>
						<div class="categories">
							<?php
							echo $quick_nav_html;
							?>
						</div>
						<!--<a href="#" class="clear-filters" data-clear-type="checkbox" data-clear-identifier="category">Clear Categories</a>-->
					</div>
				</div>

				<!--<div id="nav-toggle"></div>-->
			</div>
		</div>
		<div class="col-xs-10 col-right">
			<div class="header__account">
				<?
				if(isset($user) && $user) { ?>
					<a href="/<?= $user['username']; ?>">My Profile</a>&nbsp;<a href="/account">My Account</a>&nbsp;<a href="/logout">logout</a>
				<? } else { ?>
					<a href="/login" class="modok-trigger" data-url="/login/ajax">login</a>&nbsp;<a href="/register" class="modok-trigger" data-url="/register/ajax">register</a>
				<? } ?>
			</div>
		</div>
	</div>
</div>