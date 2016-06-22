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
if (isset($success) && $success == 'resend_username') {
    ?>
    <div class="successful">Your username has been resent to your email!</div>
    <div id="what-to-do-next">
        <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
        <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Sign In', array('class' => 'signin-link')); ?></div>
        <span class="stretch"></span>
    </div>
    <?php
} elseif (isset($success) && $success == 'reset_password') {
    ?>
    <div class="successful">You have been sent a link to reset your password</div>
    <div id="what-to-do-next">
        <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
        <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Sign In', array('class' => 'signin-link')); ?></div>
        <span class="stretch"></span>
    </div>
<?php
} else {
?>
<div class="forgot-password-form">
    <div class="title signin-link-d">Forgot Password</div>
    <form method="post" id="forgot_password_form">
        <div class="input-group">
            <input type="text" name="username" id="username" class="username" value="" placeholder="Username">
            <label for="username" class="hide-label">Username</label>
        </div>
        <div class="input-group">
            <input type="text" name="email" id="email" class="email" placeholder="Email">
            <label for="email" class="hide-label">Email</label>
        </div>
        <div class="input-group">
            <button name="sign-up" id="sign-up" class="sign-up finish-link">Reset Password</button>
        </div>
    </form>

</div>

<div class="forgot-username-form">
    <div class="title signup-link-d">Forgot Username</div>
    <form method="post" id="forgot_username_form">
        <div class="input-group">
            <input type="text" name="email" id="email" class="email" placeholder="Email">
            <label for="email" class="hide-label">Email</label>
        </div>
        <div class="input-group">
            <button name="sign-up" id="sign-up" class="sign-up finish-link">Send Username</button>
        </div>
    </form>

</div>
<?php
}
?>
