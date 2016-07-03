<div class="container-fluid">
	<div class="row">
		<div class="col-xs-20 col-left">
			<a href="/">
				<img class="header__logo" src="assets/images/logo/logo_badge--300.png" />
			</a>
		</div>
		<div class="col-xs-20 col-center">
			<img class="header__compass" src="assets/images/logo/compass--300.png" />
		</div>
		<div class="col-xs-20 col-right">
			<div class="header__account">
				<?
				if(isset($user) && $user) { ?>
					<a href="/<?= $user['username']; ?>">My Profile</a>&nbsp;<a href="/account">My Account</a>&nbsp;<a href="/logout">logout</a>
				<? } else { ?>
					<a href="/login" class="modok-trigger" data-url="/login/ajax">login</a>&nbsp;<a href="/register">register</a>
				<? } ?>
			</div>
		</div>
	</div>
</div>