<?php fuel_set_var('layout', '_layouts/fixed_width_small');?>
<div class="title settings-link-d">Settings</div>
<div class="text top20">Manage all of your account and social media settings from here. Other information, such as your bio and public information, can be found on the  <?php echo anchor('profile', 'edit profile'); ?> page.</div>
<?php


if (validation_errors() || (isset($errors))) {
    if ($errors == 1) {
        ?>
        <div class="successful">
            <p>Settings updated</p>
        </div>
    <?php
    } else {
        ?>
        <div class="errors">
            <?php
            echo validation_errors();
            echo isset($errors) ? $errors : false;
            ?>
        </div>
    <?php
    }

}
?>
<div class="settings_holder">
    <?php if ($user['facebook_id'] > 0) {
        $width = 109;
    }  else {
        $width = 93;
    }
    if ($user['twitter_id'] > 0) {
        $width += 109;
    }  else {
        $width += 93;
    }
    if ($user['google_id'] > 0) {
        $width += 109;
    }  else {
        $width += 93;
    } ?>

            <div class="social-connect">
                <?php if ($user['facebook_id'] > 0) { ?>
                    <div id="facebook-disconnect"><div class="facebook-connect" onclick="disconnect_social('facebook');"><a href="javascript:void(0)">disconnect</a></div></div>
                <?php }  else { ?>
                    <div id="facebook-connect"><div class="facebook-connect">connect</div></div>

                <?php } ?>
                <?php if ($user['twitter_id'] > 0) { ?>
                    <div id="twitter-disconnect"><div class="twitter-connect" onclick="disconnect_social('twitter');"><a href="javascript:void(0)">disconnect</a></div></div>
                <?php }  else { ?>
                    <div id="twitter-connect"><a href="/connecttwitter"><div class="twitter-connect">connect</div></a></div>

                <?php } ?>
                <?php if ($user['google_id'] > 0) { ?>
                    <div id="google-disconnect"><div class="google-connect" onclick="disconnect_social('google');"><a href="javascript:void(0)">disconnect</a></div></div>

                <?php }  else { ?>
                    <button id="google-connect" class="g-signin"
                            data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email"
                            data-requestvisibleactions="http://schemas.google.com/AddActivity"
                            data-clientId="735292588191.apps.googleusercontent.com"
                            data-callback="onSignInCallback"
                            data-theme="dark"
                            data-cookiepolicy="single_host_origin" style="background: none; padding: 0px"><div class="google-connect">connect</div>

                    </button>

                <?php } ?>

                <span class="stretch"></span>
            </div>

    <div class="holder">

        <form method="post" action="settings">

            <div class="mini-title">Email Settings</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="text" name="email" id="email" class="email" value="<?php echo $user['email']; ?>" placeholder="Email">
                    <label for="email" class="hide-label">Email</label>
                </div>
                <div class="input-group">
                    <div class="text bottom3">Email me...</div>
                    <input type="checkbox" name="email_new_feature" id="email_new_feature" class="email_new_feature" <?php if ($user['email_new_feature'] == 'on') { echo 'checked="checked"'; } ?> />
                    <label for="email_new_feature">&nbsp;&nbsp;about new website features.</label>
                </div>
                <div class="input-group">
                    <input type="checkbox" name="email_new_story" id="email_new_story" class="email_new_story" <?php if ($user['email_new_story'] == 'on') { echo 'checked="checked"'; } ?> />
                    <label for="email_new_story">&nbsp;&nbsp;when someone I follow writes a new story</label>
                </div>

                <div class="input-group">
                    <input type="checkbox" name="email_new_action" id="email_new_action" class="email_new_action" <?php if ($user['email_new_action'] == 'on') { echo 'checked="checked"'; } ?> />
                    <label for="email_new_action">&nbsp;&nbsp;when someone interacts with my comments or stories.</label>
                </div>
                <div class="input-group">
                    <input type="checkbox" name="email_follow_me" id="email_follow_me" class="email_follow_me" <?php if ($user['email_follow_me'] == 'on') { echo 'checked="checked"'; } ?> />
                    <label for="email_follow_me">&nbsp;&nbsp;when someone follows me.</label>
                </div>
            </div>
            <div class="mini-title">Username Settings</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="text" name="username" id="username" class="username" value="<?php echo $user['username']; ?>" placeholder="Username">
                    <label for="username" class="hide-label">Username</label>

                </div>
            </div>
            <div class="mini-title">Password Settings</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="password" name="old_password" id="old_password" class="old_password" value="" placeholder="Old password">
                    <label for="old_password" class="hide-label">Old password</label>
                </div>
                <div class="input-group">
                    <input type="password" name="new_password" id="new_password" class="new_password" value="" placeholder="New Password">
                    <label for="new_password" class="hide-label">New password</label>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_new_password" id="confirm_new_password" class="confirm_new_password" value="" placeholder="Confirm new password">
                    <label for="confirm_new_password" class="hide-label">Confirm new password</label>
                </div>
            </div>
            <div class="input-group">
                <button name="save-profile" id="save-profile" class="sign-up finish-link">Save Settings</button>
            </div>
            <div class="clear"></div>
<!--            <div class="mini-title top40">Account Deactivation</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <div class="after-sign-up red-box"><a href="#" class="cancel-link">Deactivate Account</a></div>
                </div>
            </div>-->




        </form>

    </div>

</div>
<div id="photo_hider">
    <div id="photo_uploader">
        <div class="profile_left">
            <div class="photo_holder">
                <img src="<?php echo base_url().'assets/users/'.$user['folder'].'/'.$user['profile_photo'] ?>" width="200" class="img">
            </div>
            <button type="button" class="btn btn-info btn-small ajaxupload upload-link">Upload New Photo</button>

        </div>
        <div id="right_upload" class="profile_right">
            <div class="imgSelect-container">
                <div class="imgSelect-upload"></div>
                <div class="imgSelect-webcam">
                    <div class="crop"></div>
                    <div class="preview"></div>
                </div>

                <input type="hidden" id="x1">
                <input type="hidden" id="y1">
                <input type="hidden" id="w">
                <input type="hidden" id="h">

                <div class="imgSelect-actions">
                    <button type="button" class="btn btn-primary save-link btn-small save" onclick="imgSelect.save()">Save Image</button>
                    <button type="button" class="btn btn-default cancel-link btn-small" onClick="imgSelect.cancel()">Cancel</button>
                </div>
            </div>
            <div class="imgSelect-alert alert successful"></div>
        </div>
    </div>
</div>
