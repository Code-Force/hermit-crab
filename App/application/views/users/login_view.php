<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Welcome to Travelled Writers</title>
</head>
<body>
<h1>Welcome to Travelled Writers</h1>
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
</body>
</html>