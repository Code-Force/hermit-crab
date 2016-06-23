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
            (isset($_POST['username']) && $_POST['username'] == '') ? $username = 'error' : $username = 'success';
            (isset($_POST['password']) && $_POST['password'] == '') ? $password = 'error' : $password = 'success';

        } else {
            $username = '';
            $password = '';
        }
        ?>



            <div id="profile"></div>


            <div class="title signin-link-d">Sign In</div>
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


                <div class="sign-in-form">
                    <div class="text">Or sign in with your details</div>


                    <form method="post" action="">
                        <div class="input-group">
                            <input type="text" name="username" id="username" class="username <?php echo $username; ?>" value="<?php echo set_value('username'); ?>" placeholder="Username">
                            <label for="username" class="hide-label">Username</label>

                        </div>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="password <?php echo $password; ?>" value="<?php echo set_value('password'); ?>" placeholder="Password">
                            <label for="password" class="hide-label">Password</label>
                        </div>
                        <div class="input-group top5">
                            <input type="checkbox" name="remember_me" id="remember_me" class="remember_me" checked="checked" /> <label for="remember_me">&nbsp;Remember Me</label> - <?php echo anchor('forgot', 'Forgot Password?'); ?>
                        </div>
                        <div class="input-group top20">
                            <button name="sign-in" id="sign-in" class="sign-in signin-link">Sign In</button>
                        </div>

                    </form>
                </div>



                <div class="clear"></div>


            </div>
        </div>
    <?php
    }
    ?>
