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
	<?php echo css('main'); ?>
	<?php echo css($css); ?>

	<?php echo js('jquery, main'); ?>
	<?php echo js($js); ?>
	
	<?php if (!empty($is_blog)) : ?>
	<?php echo $CI->fuel_blog->header()?>
	<?php endif; ?>
	<base href="<?php echo site_url()?>" />

    <div id="fb-root"></div>
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
    <meta property="og:url" content="<?= base_url(); ?>" />

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

<body class="<?php echo fuel_var('body_class', '');?>">
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=404269039700963";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
	<main>
