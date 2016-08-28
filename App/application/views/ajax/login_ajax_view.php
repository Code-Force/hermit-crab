<div class="login-modal">
	<?php echo validation_errors(); ?>
	<?php echo form_open('login/verify'); ?>
		<input class="login-modal__input" type="text" id="username" name="username" placeholder="Username" />
		<br/>
		<input class="login-modal__input" type="password"  id="passowrd" name="password" placeholder="Password" />
		<br/>
		<input class="login-modal__submit" type="submit" value="Login"/>
	</form>
	<span class="login-modal__register">Don't have an account? <a href="/register" class="modok-trigger" data-url="/register/ajax">register</a></span>
</div>