<?php fuel_set_var('layout', ''); ?>

<?php $this->load->view('_blocks/header_splash')?>

<div id="main-inner">
    <div class="logo-holder"><img src="assets/images/logo-splash.png" /></div>
    <div class="holder">
        <div class="title about-link-d">Welcome</div>
        <div class="text">Sign up through social connect...</div>
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
        <div class="text">... or the old fashioned way.</div>

        <div class="sign-up-form">
            <form method="post" action="signup">
                <input type="hidden" name="fullname" class="fullname" id="fullname" />
                <div class="input-group">
                    <input type="text" name="email" id="email" value="" placeholder="Email">
                    <label for="email" class="hide-label">Email</label>
                </div>
                <div class="input-group">
                    <input type="text" name="username" id="username" value="" placeholder="Username">
                    <label for="username" class="hide-label">Username</label>

                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="password" value="" placeholder="Password">
                    <label for="password" class="hide-label">Password</label>
                    <button name="sign-up" id="sign-up" class="sign-up finish-link">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="text">Already a member? <?php echo anchor('signin', 'Sign In'); ?></div>
        <br /><br /><br />
        <div class="text">
            <div class="bottom_links">
            <?php echo anchor('discover', 'Discover'); ?>
            <?php echo anchor('terms-and-conditions', 'Terms &amp; Conditions'); ?>
            <?php echo anchor('privacy-policy', 'Privacy Policy'); ?>
            </div>
            </div>
<!--        <div class="sign-in-form">
            <div class="title">Sign In</div>
            <form method="post" action="">
                <div class="input-group">
                    <input type="text" name="user-or-email" id="user-or-email" value="" placeholder="Username or email">
                    <label for="user-or-email" class="hide-label">Username or email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="password" value="" placeholder="Password">
                    <label for="password" class="hide-label">Password</label>
                    <button name="sign-in" id="sign-in" class="sign-in">Sign In</button>
                </div>
                <div class="input-group">
                    <input type="checkbox" name="remember-me" id="remember-me" class="remember-me" /> <label for="remember-me">&nbsp;Remember Me</label> - <?php /*echo anchor('forgot', 'Forgot Password?'); */?>
                </div>
            </form>
        </div>-->
        <div class="clear"></div>

    </div>
    <div class="clear"></div>

</div>

<div class="clear"></div>

<?php $this->load->view('_blocks/footer_splash')?>

