<?php fuel_set_var('layout', '_layouts/fixed_width_small'); ?>
    <?php if (isset($resent) && $resent == true) {
        ?>
        <div class="successful">You activation email has been resent!<br /><br />Please check your email for the account verification link. Once your account has been verified, you will be able to start sharing your stories!</div>
        <div id="what-to-do-next">
            <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
            <div class="after-sign-up yellow-box"><?php echo anchor('resend', 'Resend Verification', array('class' => 'resend-link')); ?></div>
            <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Your First Sign In', array('class' => 'signin-link')); ?></div>
            <span class="stretch"></span>

        </div>
    <?php
    } else {
        ?>
        <div class="errors">Your resend access has expired.</div>
        <div id="what-to-do-next">
            <div class="after-sign-up orange-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
            <div class="after-sign-up blue-box"><?php echo anchor('signup', 'Sign Up', array('class' => 'signup-link')); ?></div>
            <span class="stretch"></span>

        </div>
    <?php
    }
    ?>
