<?= validation_errors(); ?>
<?= form_open('register/verify'); ?>
<label for="username">Email:</label>
<input type="text" id="email" value="<?= set_value('email'); ?>" name="email"/>
<br/>
<label for="username">Username:</label>
<input type="text" id="username" value="<?= set_value('username'); ?>" name="username"/>
<br/>
<label for="password">Password:</label>
<input type="password"  id="passowrd" value="<?= set_value('password'); ?>" name="password"/>
<br/>
<label for="password">Confirm Password:</label>
<input type="password"  id="passconf" value="<?= set_value('passconf'); ?>" name="passconf"/>
<br/>
    <input type="submit" value="Register"/>
</form>
