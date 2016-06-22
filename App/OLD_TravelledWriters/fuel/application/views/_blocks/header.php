<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<?php if (!empty($is_blog)) : ?>
	<title><?php echo $CI->fuel_blog->page_title($page_title, ' : ', 'right')?></title>
	<?php else : ?>
	<title><?php echo fuel_var('page_title', '')?></title>
	<?php endif ?>
	<meta charset="UTF-8" />
	<meta name="ROBOTS" content="ALL" />
	<meta name="MSSmartTagsPreventParsing" content="true" />

	<meta name="keywords" content="<?php echo fuel_var('meta_keywords')?>" />
	<meta name="description" content="<?php echo fuel_var('meta_description')?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php echo css('main, msdropdown/dd, msdropdown/flags, jquery.qtip, colorbox'); ?>
	<?php echo css($css); ?>

	<?php echo js('jquery, main, msdropdown/jquery.dd.min, jquery.qtip.min, jquery.colorbox, jquery-ui.min.js, tag-it, jquery.autosize'); ?>
	<?php echo js($js); ?>


    <link href='http://fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <?php if (!empty($is_blog)) : ?>
	<?php echo $CI->fuel_blog->header()?>
	<?php endif; ?>
	<base href="<?php echo site_url()?>" />
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525b4a9c082fa427"></script>
    <?php
    if (isset($story_viewed) && (!empty($story_viewed))) {
        ?>
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@writerstravel">
        <meta name="twitter:title" content="<?php echo $story_viewed["story_title"];?>">
        <meta name="twitter:description" content="<?php echo $story_viewed["description"];?>">
        <meta name="twitter:creator" content="@writerstravel">
        <meta name="twitter:image:src" content="<?= base_url().'assets/users/'.$story_viewed['folder'].'/stories/'.$story_viewed['album'].'/'.$story_viewed['story_cover']; ?>">
        <meta name="twitter:domain" content="<?= base_url(); ?>">
        <meta name="twitter:app:name:iphone" content="">
        <meta name="twitter:app:name:ipad" content="">
        <meta name="twitter:app:name:googleplay" content="">
        <meta name="twitter:app:url:iphone" content="">
        <meta name="twitter:app:url:ipad" content="">
        <meta name="twitter:app:url:googleplay" content="">
        <meta name="twitter:app:id:iphone" content="">
        <meta name="twitter:app:id:ipad" content="">
        <meta name="twitter:app:id:googleplay" content="">
        <meta property="og:title" content="<?php echo $story_viewed["story_title"];?>" />
        <meta property="og:description" content="<?php echo $story_viewed["description"];?>" />
        <meta property="og:image" content="<?= base_url().'assets/users/'.$story_viewed['folder'].'/stories/'.$story_viewed['album'].'/'.$story_viewed['story_cover']; ?>" />
        <meta property="og:url" content="<?= base_url().$story_viewed['username'].'/'.$story_viewed['slug']; ?>" />

        <link rel="image_src" href="<?= base_url().'assets/users/'.$story_viewed['folder'].'/stories/'.$story_viewed['album'].'/'.$story_viewed['story_cover']; ?>" />
    <?php
    } else { ?>
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@writerstravel">
        <meta name="twitter:title" content="Travelled Writers">
        <meta name="twitter:description" content="Travel the world. Write your story. Share your experience.">
        <meta name="twitter:creator" content="@writerstravel">
        <meta name="twitter:image:src" content="http://www.travelledwriters.com/assets/users/default_story.png">
        <meta name="twitter:domain" content="<?= base_url(); ?>">
        <meta name="twitter:app:name:iphone" content="">
        <meta name="twitter:app:name:ipad" content="">
        <meta name="twitter:app:name:googleplay" content="">
        <meta name="twitter:app:url:iphone" content="">
        <meta name="twitter:app:url:ipad" content="">
        <meta name="twitter:app:url:googleplay" content="">
        <meta name="twitter:app:id:iphone" content="">
        <meta name="twitter:app:id:ipad" content="">
        <meta name="twitter:app:id:googleplay" content="">
        <meta property="og:title" content="Travelled Writers" />
        <meta property="og:description" content="Travelled Writers is a community for travellers, by travellers. Share your experiences and travel adventures with other like minded people. Read about interesting people and their adventures from literally everywhere in the world!" />
        <meta property="og:image" content="<?= base_url().'assets/images/default_image.png'; ?>" />
        <meta property="og:url" content="<?= base_url().'discover'; ?>" />
        <?php
    }
    ?>


    <script>
        window.fbAsyncInit = function() {
            // init the FB JS SDK
            FB.init({
                appId      : '243282025825120', // App ID
                channelURL : '', // Channel File, not required so leave empty
                status     : true, // check login status
                cookie     : true, // enable cookies to allow the server to access the session
                oauth      : true, // enable OAuth 2.0
                xfbml      : true  // parse XFBML
            });

            // Additional initialization code such as adding Event Listeners goes here
        };

        // Load the SDK asynchronously
        (function(){
            // If we've already installed the SDK, we're done
            if (document.getElementById('facebook-jssdk')) {return;}

            // Get the first script element, which we'll use to find the parent node
            var firstScriptElement = document.getElementsByTagName('script')[0];

            // Create a new script element and set its id
            var facebookJS = document.createElement('script');
            facebookJS.id = 'facebook-jssdk';

            // Set the new script's source to the source of the Facebook JS SDK
            facebookJS.src = '//connect.facebook.net/en_US/all.js';

            // Insert the Facebook JS SDK into the DOM
            firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);



        }());

        // logs the user in the application and facebook
        function login(){
            FB.getLoginStatus(function(r){
                if(r.status === 'connected'){

                    window.location.href = 'connectfacebook';
                }else{

                    FB.login(function(response) {

                        if(response.authResponse) {
                            //if (response.perms)
                            window.location.href = 'connectfacebook';
                        } else {
                            // user is not logged in
                        }
                    },{scope:'email'}); // which data to access from user profile
                }
            });
        }
    </script>
</head>

<?php
if (isset($user) && !empty($user)) {
?>
<body class="<?php echo fuel_var('body_class', '');?> logged_in_user">
<?php
} else {
?>
<body class="<?php echo fuel_var('body_class', '');?> logged_out_user">
<?php
}
?>
<div id="site-container">
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=404269039700963";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

<header>
    <div id="header_container">
        <?php

        $headers = array('b', 'y', 'r', 'o', 'g');
        ?>
        <div  id="logo">
            <?php
            if (isset($user) && !empty($user)) {
                ?>
                <a href="/discover" class="logo-header-b<?php /*echo $headers[rand(0,4)]; */?>">Travelled Writers</a>
            <?php
            } else {
                ?>
                <a href="<?= base_url(); ?>" class="logo-header-b<?php /*echo $headers[rand(0,4)]; */?>">Travelled Writers</a>

            <?php
            }
            ?>
        </div>
        <div id="discover-link">
            <a href="/discover" class="sign-up-link discover signup-link" title="Discover">Discover Stories</a>
            <a href="/<?= $random_story['username'].'/'.$random_story['slug']; ?>" class="shuffle-link" title="Random Story">Random Story</a>
        </div>
        <nav>
		<?php
        if (isset($user_logged) && $user_logged) {
            $show_username = ($user['show_name'] == 'on' ? $user['fullname'] : $user['username']);
            $updates = 0;

            echo fuel_nav(array('file' => 'logged_in_nav', 'container_tag_id' => 'logged_in_nav', 'item_id_prefix' => 'logged_in_nav_', 'var' => 'logged_in_nav'));

            ?>
            <div class="header-content-box" id="notifications-link-box">
                <div  id="notifications-link-box-inner">
                <?php
                if (!empty($user['updates'])) {
                    $date = $user['updates'][0]['notification_date'];

                    foreach ($user['updates'] as $update) {
                        if ($update['show_name'] == 'on') {
                            $show_update_username = $update['fullname'];
                        } else {
                            $show_update_username = $update['username'];
                        }

                        if ($update['seen'] == 0) {
                            $updates++;
                        } ?>


                            <?php
                        if ($update['type'] == 'like') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['story_username'].'/'.$update['slug']; ?>">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                                echo '<div class="not_text">'.anchor($update['username'], $show_update_username).' liked your story<br />'.anchor($update['story_username'].'/'.$update['slug'], $update['story_title']).'</div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }
                        if ($update['type'] == 'new_post') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['story_username'].'/'.$update['slug']; ?>">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                                echo '<div class="not_text">'.anchor($update['username'], $show_update_username).' posted a new story
                                <br /><br />'.anchor($update['story_username'].'/'.$update['slug'], $update['story_title']).'
                                <div class="story-location">
                                    <img src="assets/images/msdropdown/icons/blank.gif" class="flag '.strtolower($update['iso']).' fnone" title="'.$update['nicename'].'" />
                                    '.$update['nicename'].', '.$update['location'].'
                                </div>
                            </div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }
                        if ($update['type'] == 'comment') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['story_username'].'/'.$update['slug']; ?>#comments">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                                echo '<div class="not_text">'.anchor($update['username'], $show_update_username).' commented on your story<br />'.anchor($update['story_username'].'/'.$update['slug'].'#comments', $update['story_title']).'</div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }
                        if ($update['type'] == 'reply') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['story_username'].'/'.$update['slug']; ?>#comments">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                                echo '<div class="not_text">'.anchor($update['username'], $show_update_username).' replied to your comment on<br />'.anchor($update['story_username'].'/'.$update['slug'].'#comments', $update['story_title']).'</div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }
                        if ($update['type'] == 'follow') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['username']; ?>">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                            echo '<div class="not_text">'.anchor($update['username'], $show_update_username).' has started following you</div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }
                        if ($update['type'] == 'announcement') {
                            ?>
                            <div class="notification <?php if ($update['seen'] == 0) echo 'new'; ?> <?= $update['type']; ?>" data-link-value="<?= $update['username'].'/'.$update['slug']; ?>">
                                <img src="<?php echo base_url().'assets/users/'.$update['folder'].'/small/'.$update['profile_photo'] ?>" />
                                <?php
                                echo '<div class="not_text">There is a new announcement waiting for you!</div>';
                                echo '<div class="not_date">'.$update['dated'].'</div>';

                                ?>
                            </div>
                        <?php
                        }

                    }
                } else {
                    $date = '';
                    ?>
                    <div class="no_nots">You have no notifications</div>
                    <?php
                }

                ?>
                </div>
            </div>
            <?php

            ?>
            <div class="header-content-box" id="profile-link-box">
                <div class="details">
                    <div class="photo" id="mini-photo" ><a href="<?= base_url().$user['username']; ?>"><img src="<?php echo base_url().'assets/users/'.$user['folder'].'/small/'.$user['profile_photo'] ?>" width="50px" /></a></div>
                    <div class="mini-details">
                        <?php echo anchor($user['username'], $show_username); ?>
                        <?php
                        if ($user['nationality'] > 0) {
                            foreach ( $countries as $country ) {

                                if ( $user['nationality'] == $country->country_id ) {
                                    echo '<div class="nationality">';
                                    echo '<img src="assets/images/msdropdown/icons/blank.gif" class="flag '.strtolower($country->iso).' fnone" />'.$country->nicename;
                                    echo '</div>';
                                }

                            }
                        }
                        ?>
                        <?php echo anchor('profile', 'Edit Profile', 'class="edit-profile"'); ?>

                    </div>
                </div>

                <div class="meta-options">
                    <?php echo anchor('settings', 'Settings', 'class="edit-settings"'); ?>
                    <?php echo anchor('signout', 'Sign Out', 'class="sign-out"'); ?>
                </div>
            </div>
            <input type="hidden" id="last_notifications" value="<?= $date; ?>" />
            <?php

        } else {
            ?>

            <div class="not-logged-in">
                <span>Sign up with </span>
                <a href="/signup" class="sign-up-link signup-link2" id="sign-up-link" title="Sign up with your email">Sign Up</a>
                <div class="social-connect">
                    <div id="facebook-connect" title="Sign up with your Facebook"><div class="facebook-connect"></div></div>
                    <div id="twitter-connect" title="Sign up with your Twitter"><div class="twitter-connect"><a href="/connecttwitter"></a></div></div>
                    <button id="google-connect"  title="Sign up with your Google"class="g-signin"
                            data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email"
                            data-requestvisibleactions="http://schemas.google.com/AddActivity"
                            data-clientId="735292588191.apps.googleusercontent.com"
                            data-callback="onSignInCallback"
                            data-theme="dark"
                            data-cookiepolicy="single_host_origin" style="background: none; padding: 0px"><div class="google-connect"></div>
                    </button>
                    <span class="stretch"></span>
                </div><span>or</span> <a href="/signin" class="sign-in-link signin-link" id="sign-in-link" title="Sign In">Sign In</a>
            </div>
            <?php

        }

        ?>
		</nav>
        <?php
        if (isset($updates) && $updates > 0){
            ?>
            <div id="update_number"><?= $updates; ?></div>
        <?php
        }
        ?>



    </div>

    </header>
	<main>