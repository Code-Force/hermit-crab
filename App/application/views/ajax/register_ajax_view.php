<div class="login-modal">

	<?= validation_errors(); ?>
	<?= form_open('register/verify'); ?>
	<input class="login-modal__input" type="text" id="email" value="<?= set_value('email'); ?>" name="email" placeholder="Email" />
	<br/>
	<input class="login-modal__input" type="text" id="username" value="<?= set_value('username'); ?>" name="username" placeholder="Username" />
	<br/>
	<input class="login-modal__input" type="password"  id="passowrd" value="<?= set_value('password'); ?>" name="password" placeholder="Password" />
	<br/>
	<input class="login-modal__input" type="password"  id="passconf" value="<?= set_value('passconf'); ?>" name="passconf" placeholder="Confirm Password" />
	<br/>
	<input class="login-modal__submit" type="submit" value="Register"/>
	</form>
	<span class="login-modal__register">Have an account? <a href="/login" class="modok-trigger" data-url="/login/ajax">login</a></span>

</div>
