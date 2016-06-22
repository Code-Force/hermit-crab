<?php fuel_set_var('layout', '_layouts/fixed_width_small'); ?>


    <div class="errors">
        <p>There was an error with your Twitter Connection</p>
    </div>

    <div id="what-to-do-next">
        <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
        <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Sign In', array('class' => 'signin-link')); ?></div>
        <div class="after-sign-up yellow-box"><?php echo anchor('signup', 'Sign Up', array('class' => 'signup-link')); ?></div>
        <span class="stretch"></span>

    </div>
