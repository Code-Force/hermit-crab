<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Welcome to Travelled Writers</title>
</head>
<body>
<h1>Welcome to Travelled Writers</h1>
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
</body>
</html>