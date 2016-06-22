<?php fuel_set_var('layout', '_layouts/fixed_width_small'); ?>
<?php if (isset($registered) && $registered == true) {
    ?>
    <div class="successful">Thanks for registering with Travelled Writers!<br /><br />Please check your email for the account verification link. Once your account has been verified, you will be able to start sharing your stories!</div>
    <div id="what-to-do-next">
        <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
        <div class="after-sign-up yellow-box"><?php echo anchor('resend', 'Resend Verification', array('class' => 'resend-link')); ?></div>
        <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Your First Sign In', array('class' => 'signin-link')); ?></div>
        <span class="stretch"></span>

    </div>
<?php
} else { ?>
    <div class="holder">

        <div class="twitter_note">You are currently signing up with Twitter. All we need now is your email and password!</div>

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
        ?>
            <form method="post" action="signup/twitter">
                <div class="input-group">
                    <input type="text" name="fullname" id="fullname" class="fullname" value="<?php echo $fullname ?>" placeholder="Full name">
                    <label for="fullname" class="hide-label">Full name</label>
                </div>
                <div class="input-group">
                    <input type="text" name="email" id="email" class="email" value="<?php echo $email; ?>" placeholder="Email">
                    <label for="email" class="hide-label">Email</label>
                </div>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="username" value="<?php echo $username; ?>" placeholder="Username">
                    <label for="username" class="hide-label">Username</label>

                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="password" value="<?php echo $password; ?>" placeholder="Password">
                    <label for="password" class="hide-label">Password</label>
                </div>
                <div class="input-group">

                    <button name="sign-up" id="sign-up" class="sign-up finish-link">Complete Sign Up</button>
                    <input type="hidden" name="twitter_id" id="twitter_id" value="<?php if (isset($twitter_id) && $twitter_id == true) { echo $twitter_id; } ?>">
                    <input type="hidden" name="twitter_link" id="twitter_link" value="<?php if (isset($twitter_link) && $twitter_link == true) { echo $twitter_link; } ?>">

                </div>
            </form>

        </div>

    <div class="clear"></div>
</div>
<?php } ?>