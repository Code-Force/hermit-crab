<div class="container-fluid">
	<div class="row">
		<div class="col-xs-30 col-left">
			<div class="logo-holder">
				<a href="/">
					<img class="logo-holder__logo" src="<?= base_url(); ?>assets/images/logo/logo_badge--300.png" />
				</a>
			</div>
		</div>
		<div class="col-xs-30 col-right">
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
