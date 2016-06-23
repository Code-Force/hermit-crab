<h1> Edit profile</h1>
<?php if( isset($err)): ?>
    <div class="alert alert-error">
        <?php echo($err) ?>
    </div>
<?php endif; ?>
<?php echo form_open_multipart('/index.php/profile/updateprofile');?>
<p>
    User name: <?php echo($user->username) ?>
</p>

<p>
    <label>Name </label> <br/>
    <input type="text" name="fullname" value="<?php echo($user->name) ?>" />
</p>
<p>
    <label>Info </label> <br/>
    <textarea rows="5" cols="50" name="summary"><?php echo($user->summary) ?></textarea>
</p>
<p>
    <label>Profile Image: </label> </br>
    <?php if($user->profileimage !=null): ?>
        <img src="<?php echo( '/profile/thumb/'.$user->id) ?>" />
    <?php endif; ?>
</p>
<p>
    <input type="file" name="userfile" size="20" />
</p>
<p>
    <input class="btn btn-primary" type="Submit" value="Update" />
</p>
</form>