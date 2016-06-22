<?php fuel_set_var('layout', '');
$this->load->view('_blocks/header');

//var_dump($stories);
?>
<div id="this_user_profile">
    <div class="profile_pic">
    <img src="<?= base_url().'assets/users/'.$user_viewed['folder'].'/'.$user_viewed['profile_photo'] ?>" width="200px" />
    </div>
    <div class="profile_info">
        <div class="who_am_i">
            <?= anchor($user_viewed['username'], ($user_viewed['show_name'] == 'on' ? $user_viewed['fullname'] : $user_viewed['username'])); ?>

        </div>

        <div class="following_count" title="Following"><?= $following; ?></div><div class="followers_count" title="Followers"><?= $followers; ?></div>
        <div style="float: left; clear:left">
        <?php
        if ($user_viewed['nationality'] > 0) {
            foreach ( $countries as $country ) {

                if ( $user_viewed['nationality'] == $country->country_id ) {
                    echo '
                            <div class="nationality">
                            <img src="assets/images/msdropdown/icons/blank.gif" class="flag '.strtolower($country->iso).' fnone" />'.$country->nicename.'</div>';
                }

            }
        }
        ?>
               <?php if (isset($user) && !empty($user) && ($user_viewed['blogger_id'] == $user['blogger_id'])) { ?><?php echo anchor('profile', 'Edit Profile', 'class="edit-profile"'); ?><?php } ?>
        </div>
        <div class="bio">
            <?php if ($user_viewed['bio'] != '') { ?>
            <?= $user_viewed['bio']; ?>
            <?php } elseif ((isset($user) && !empty($user)) && ($user_viewed['blogger_id'] == $user['blogger_id'])) { ?>
                <i>You haven't entered your bio yet.</i>
            <?php } else { ?>
                <i>This user hasn't entered their bio yet.</i>
            <?php } ?>
        </div>
        <div class="social_links">
            <?php
            if (($user_viewed['website'] != '') || ($user_viewed['facebook_link'] != '') || ($user_viewed['google_link'] != '') || ($user_viewed['twitter_link'] != '')) {
                ?>

                <?php
                if (($user_viewed['twitter_link'] != '')) {
                    echo '<a href="'.$user_viewed['twitter_link'].'" target="_blank" title="Twitter"><div class="social_icon twitter"></div></a>';
                }
                if (($user_viewed['google_link'] != '')) {
                    echo '<a href="'.$user_viewed['google_link'].'" target="_blank" title="Google Plus"><div class="social_icon googleplus"></div></a>';
                }
                if (($user_viewed['facebook_link'] != '')) {
                    echo '<a href="'.$user_viewed['facebook_link'].'" target="_blank" title="Facebook"><div class="social_icon facebook"></div></a>';
                }
                if (($user_viewed['website'] != '')) {
                    echo '<a href="'.$user_viewed['website'].'" target="_blank" title="Personal Website"><div class="social_icon website"></div></a>';
                }
                    ?>
                    <?php
            }

            ?>
        </div>
        <?php
        if (isset($user['blogger_id']) && $user_viewed['blogger_id'] != $user['blogger_id']) {
            ?>
            <div class="follow-user <?php if ($is_following == true) echo 'followed';  ?>" data-clientId="<?= $user_viewed['blogger_id'] ?>" title="<?php if ($is_following == true) { echo 'Unfollow'; } else { echo'Follow'; } ?>">
                <?php if ($is_following == true) { echo 'Unfollow'; } else { echo'Follow'; } ?>
            </div>

        <?php
        }
        ?>
    </div>
</div>
<?php
$this->load->view('_blocks/filters'); ?>

    <div id="stories" class="variable-sizes clearfix">
        <?= $stories; ?>
    </div> <!-- #container -->
    <div id="search_errors" class="clearfix">
    </div>
    <div class="loading_loader"><img src="<?= base_url().'assets/images/load-stories.gif';?>" /> </div>

    <!-- AddThis Smart Layers BEGIN -->
    <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525b4a9c082fa427"></script>
    <script type="text/javascript">
        addthis.layers({
            'theme' : 'transparent',
            'share' : {
                'position' : 'left',
                'numPreferredServices' : 6
            }
        });
    </script>
    <!-- AddThis Smart Layers END -->
<?php
$this->load->view('_blocks/footer');
