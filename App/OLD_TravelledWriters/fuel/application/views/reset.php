<?php fuel_set_var('layout', '_layouts/fixed_width_small'); ?>
<?php
if (validation_errors() || (isset($errors))) {
    ?>
    <div class="errors">
        <?php
        echo validation_errors();
        echo isset($errors) ? $errors : false;
        ?>
    </div>
<?php
}
if (isset($success) && $success == 'reset_password') {
    ?>
    <div class="successful">Your password has been reset</div>
    <div id="what-to-do-next">
        <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Sign In', array('class' => 'signin-link')); ?></div>
        <span class="stretch"></span>
    </div>
<?php
} else {
?>

<div class="holder">
    <div class="forgot-username-form">
        <div class="title signin-link-d">Reset your password</div>
        <form method="post" id="reset_form">
            <div class="input-group">
                <input type="text" name="email" id="email" class="email" value="<?php echo set_value('email'); ?>" placeholder="Email">
                <label for="email" class="hide-label">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" class="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                <label for="password" class="hide-label">Password</label>
            </div>
            <div class="input-group">
                <input type="password" name="confpassword" id="confpassword" class="confpassword" value="<?php echo set_value('confpassword'); ?>" placeholder="Confirm Password">
                <label for="confpassword" class="hide-label">Confirm Password</label>
            </div>
            <div class="input-group">
                <?= form_hidden("activation_code", $activation_code); ?>
                <button name="sign-up" id="sign-up" class="sign-up finish-link">Reset Password</button>
            </div>
        </form>

    </div>
</div>




<?php
}
?>
