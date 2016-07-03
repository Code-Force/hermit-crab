<div class="login-modal">
	<?php echo validation_errors(); ?>
	<?php echo form_open('login/verify'); ?>
		<input type="text" id="username" name="username" placeholder="Username" />
		<br/>
		<input type="password"  id="passowrd" name="password" placeholder="Password" />
		<br/>
		<input type="submit" value="Login"/>
	</form>
</div>