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
    } else {
        if (!empty($_POST)) {
        (isset($_POST['email']) && $_POST['email'] == '') ? $email = 'error' : $email = 'success';
        (isset($_POST['username']) && $_POST['username'] == '') ? $username = 'error' : $username = 'success';
        (isset($_POST['password']) && $_POST['password'] == '') ? $password = 'error' : $password = 'success';
        (isset($_POST['fullname']) && $_POST['fullname'] == '') ? $fullname = 'error' : $fullname = 'success';
            $signup = 'Complete your sign up';
        } else {
            $email = '';
            $username = '';
            $password = '';
            $fullname = '';
            $signup = 'Sign up';
        }
        ?>
        <div id="fb-root"></div>

        <div class="title signup-link-d"><?= $signup; ?></div>
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
        <div class="sign-in-page">
            <div class="holder">

                <div class="still-social">
                    <div class="text">Connect via social networks!</div>
                    <div class="social-connect">
                        <div id="facebook-connect"><div class="facebook-connect">connect</div></div>
                        <div id="twitter-connect"><div class="twitter-connect"><a href="/connecttwitter">connect</a></div></div>
                        <button id="google-connect" class="g-signin"
                                data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email"
                                data-requestvisibleactions="http://schemas.google.com/AddActivity"
                                data-clientId="735292588191.apps.googleusercontent.com"
                                data-callback="onSignInCallback"
                                data-theme="dark"
                                data-cookiepolicy="single_host_origin" style="background: none; padding: 0px"><div class="google-connect">connect</div>

                        </button>
                        <span class="stretch"></span>
                    </div>
                </div>
                <div class="sign-up-form">
                <div class="text">Or sign up with your details</div>

                    <form method="post" action="signup">
                        <div class="input-group">
                            <input type="text" name="fullname" id="fullname" class="fullname <?php echo $fullname; ?>" value="<?php echo set_value('fullname'); ?>" placeholder="Full name">
                            <label for="fullname" class="hide-label">Full name</label>
                        </div>
                        <div class="input-group">
                            <input type="text" name="email" id="email" class="email <?php echo $email; ?>" value="<?php echo set_value('email'); ?>" placeholder="Email">
                            <label for="email" class="hide-label">Email</label>
                        </div>
                        <div class="input-group">
                            <input type="text" name="username" id="username" class="username <?php echo $username; ?>" value="<?php echo set_value('username'); ?>" placeholder="Username">
                            <label for="username" class="hide-label">Username</label>

                        </div>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="password <?php echo $password; ?>" value="<?php echo set_value('password'); ?>" placeholder="Password">
                            <label for="password" class="hide-label">Password</label>
                        </div>
                        <div class="input-group">
                        <?php
                        include('_blocks/countries.php');
                        $selected = ' selected="selected"';
                        $_country = NULL;
                        if ( isset($_GET['country']) ) {
                            $_country = isset($countries[$_GET['country']]) ? $_GET['country'] : NULL;
                        }

                        echo "<select name=\"nationality\" id=\"nationality\" style=\"width: 318px\">";
                        echo "<option value='' data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag none\" data-title=\"Nationality\">Nationality</option>";
                        foreach ( $countries as $code => $country ) {
                            echo "<option value=\"$code\" data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag $code\" data-title=\"".ucwords($country)."\"";
                            if ( isset($_POST['nationality']) && $_POST['nationality'] == $code ) {
                                echo $selected;
                            }
                            echo ">".ucwords($country)."</option>\n";
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
<!--                        <div class="text gray">By clicking the "Complete Sign Up" button below, you agree to our <?php /*echo anchor('terms', 'terms of use policy'); */?>. Please read it carefully! Who knows, maybe you're selling your soul?!</div>
-->                        <div class="input-group">
                            <button name="sign-up" id="sign-up" class="sign-up finish-link">Complete Sign Up</button>
                        </div>
                    </form>
                    <div class="text">Already a member? <?php echo anchor('signin', 'Sign In'); ?></div>

                </div>
            </div>

            <div class="clear"></div>
        </div>

    <?php
    }
    ?>
