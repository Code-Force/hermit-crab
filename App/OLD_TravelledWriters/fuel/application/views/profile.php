<?php fuel_set_var('layout', '_layouts/fixed_width_small');?>
<div class="title signup-link-d">Edit Profile</div>
<div class="text top20">This section is for editing the public information that other users can see on your profile and posts. Other information, such as your email and username, can be found on the  <?php echo anchor('settings', 'settings'); ?> page.</div>
<?php


if (validation_errors() || (isset($errors))) {
    if ($errors == 1) {
        ?>
        <div class="successful">
            <p>Profile updated</p>
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
<div class="profile_holder">
    <div class="profile_left">
        <div class="mini-title">Profile Photo</div>
        <div class="mini-form-class">
        <div class="photo_holder">
            <img src="<?php echo base_url().'assets/users/'.$user['folder'].'/'.$user['profile_photo'] ?>" width="200" class="img">
        </div>
        <div class="green-box"><a href="#photo_uploader" class= "inline edit-link">Edit Photo</a></div>
        <div class="clear"></div>
        </div>

    </div>
    <div class="profile_right">

        <form method="post" action="profile">
            <div class="mini-title">My terrific travelling name</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="text" name="fullname" id="fullname" class="fullname" value="<?php echo $user['fullname']; ?>" placeholder="Full name">
                    <label for="fullname" class="hide-label">Full name</label>
                </div>
                <div class="input-group">
                    <input type="checkbox" name="show_name" id="show_name" class="show_name" <?php if ($user['show_name'] == 'on') { echo 'checked="checked"'; } ?> />
                    <label for="show_name">&nbsp;Use my full name on my public profile.</label>
                </div>
            </div>
            <div class="mini-title">About</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <textarea name="bio" id="bio" class="bio" placeholder="Bio (Max 300 characters)"><?php echo $user['bio']; ?></textarea>
                    <label for="bio" class="hide-label">Bio (Max 300 characters)</label>
                </div>
                <div class="input-group">
                    <?php
                    $selected = ' selected="selected"';

                    echo "<select name=\"nationality\" id=\"nationality\" style=\"width: 280px\">";
                    echo "<option value='' data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag none\" data-title=\"Nationality\">Nationality</option>";
                    foreach ( $countries as $country ) {
                        echo "<option value=\"$country->country_id\" data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag ".strtolower($country->iso)."\" data-title=\"".ucwords($country->nicename)."\"";
                        if ($user['nationality'] == $country->country_id) {
                            echo $selected;
                        }
                        echo ">".ucwords($country->nicename)."</option>\n";
                    }
                    echo "</select>";
                    ?>
                    <label for="countries" class="hide-label">Country</label>

                    <script>
                        $(document).ready(function() {
                            $("#nationality").msDropdown();
                        })
                    </script>
                </div>
            </div>
            <div class="mini-title">Social &amp; website info</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="text" name="website" id="website" class="website" value="<?php echo $user['website']; ?>" placeholder="Website">
                    <label for="website" class="hide-label">Website</label>
                </div>

                <div class="input-group">
                    <div class="social-change-image">
                        <img src="../../../assets/images/social/fb-connect.png">
                    </div>
                    <div class="social-change-link">
                        <input type="text" name="facebook_link" id="facebook_link" class="facebook_link" value="<?php echo $user['facebook_link']; ?>" placeholder="Facebook link">
                        <label for="facebook_link" class="hide-label">Facebook link</label>
                    </div>
                </div>
                <div class="input-group">
                    <div class="social-change-image">
                        <img src="../../../assets/images/social/twit-connect.png">
                    </div>
                    <div class="social-change-link">
                        <input type="text" name="twitter_link" id="twitter_link" class="twitter_link" value="<?php echo $user['twitter_link']; ?>" placeholder="Twitter link">
                        <label for="twitter_link" class="hide-label">Twitter link</label>
                    </div>
                </div>
                <div class="input-group">
                    <div class="social-change-image">
                        <img src="../../../assets/images/social/google-connect.png">
                    </div>
                    <div class="social-change-link">
                        <input type="text" name="google_link" id="google_link" class="google_link" value="<?php echo $user['google_link']; ?>" placeholder="Google+ link">
                        <label for="google_link" class="hide-label">Google+ link</label>
                    </div>
                </div>
            </div>

            <div class="input-group">
                <button name="save-profile" id="save-profile" class="sign-up finish-link">Save Profile</button>
            </div>
        </form>

    </div>
    <script src="<?php echo base_url().'assets/js/imgSelect.js'; ?>"></script>
    <link href='<?php echo base_url().'assets/css/imgSelect.css'; ?>' rel='stylesheet' type='text/css'>
    <input type="hidden" id="photo_upload_action" value="profile" />
    <script>
        $(".inline").colorbox({inline:true, opacity: 0.8, transition:"none", onClosed:function(){ $('.imgSelect-upload').html('" />'); $('.imgSelect-container, .imgSelect-upload, .imgSelect-actions').hide(); $( ".imgareaselect-outer" ).remove(); $( ".imgareaselect-selection" ).remove(); $( ".imgareaselect-border1" ).remove(); $( ".imgareaselect-border2" ).remove(); }});
    </script>
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
