<?php fuel_set_var('layout', '_layouts/fixed_width_small'); ?>
    <?php if (isset($activated) && $activated == true) {
        ?>
        <div class="successful"><?php echo $is_activated; ?></div>
        <div id="what-to-do-next">
            <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
            <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Your First Sign In', array('class' => 'signin-link')); ?></div>
            <span class="stretch"></span>
        </div>
    <?php
    } else {
        ?>
        <div class="errors"><?php echo $is_activated; ?></div>
        <div id="what-to-do-next">
            <div class="after-sign-up blue-box"><?php echo anchor('discover', 'Discover Stories', array('class' => 'discover-link')); ?></div>
            <div class="after-sign-up orange-box"><?php echo anchor('signin', 'Your First Sign In', array('class' => 'signin-link')); ?></div>
            <span class="stretch"></span>
        </div>
    <?php
    }
    ?>
