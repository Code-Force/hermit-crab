<div class="login-modal">
	<?php echo validation_errors(); ?>
	<?php echo form_open('login/verify'); ?>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username"/>
		<br/>
		<label for="password">Password:</label>
		<input type="password"  id="passowrd" name="password"/>
		<br/>
		<input type="submit" value="Login"/>
	</form>
</div>