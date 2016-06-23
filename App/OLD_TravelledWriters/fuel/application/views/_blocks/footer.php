
<div id="back-top"><a href="#top"><img src="<?= base_url().'assets/images/icons/backtop.png'?>" /><br /><br />back to top</a></div>
<div id="feedback">suggestions</div>
<div id="feedback-container">
<div id="close-feedback"></div>
    <div id="feedback_form">
        <?php
        if (isset($user) && !empty($user)) {
            ?>
            <div class="input-group feedback_logged_in">
                You are logged in as <?= $user['fullname']; ?>. Please submit your feedback below!
            </div>
            <input type="hidden" name="feedback_name" id="feedback_name" class="feedback-field" value="<?= $user['fullname']; ?>" placeholder="Name">
            <input type="hidden" name="feedback_email" id="feedback_email" class="feedback-field" value="<?= $user['email']; ?>" placeholder="Email">
        <?php
        } else {
            ?>
        <div class="input-group">
            <input type="text" name="feedback_name" id="feedback_name" class="feedback-field" value="" placeholder="Name">
            <label for="feedback_name" class="hide-label">Name</label>
        </div>
        <div class="input-group">
            <input type="text" name="feedback_email" id="feedback_email" class="feedback-field" value="" placeholder="Email">
            <label for="feedback_email" class="hide-label">Email</label>
        </div>
        <?php
        } ?>


        <div class="input-group">
            <textarea name="feedback_text" id="feedback_text" class="feedback-field" placeholder="Feedback"></textarea>
            <label for="feedback_text" class="hide-label">Feedback</label>
        </div>
        <div class="input-group box green-box">
        <a href="javascript:void(0)" class="finish-link" id="feedback_submit" title="Submit Feedback">Submit Feedback</a>
        </div>
        <div id="feedback_errors"></div>
    </div>
    <div id="loading_feedback"><img src="<?= base_url().'assets/images/loader-white.gif';?>" /></div>
    <div id="feedback_success"></div>
</div>
</main>

	<div id="footer">
        <div class="fixed_width">
		<div id="copyright">

            <?php
            if (isset($user) && !empty($user)) {
                ?>
                <?php echo anchor('discover', 'Discover'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('write', 'Write'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor($user['username'], 'Profile'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('bugs-and-reporting', 'Bugs &amp; Reporting'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('contact', 'Contact'); ?>
                <br />
                <br />
                <?php echo anchor('terms-and-conditions', 'Terms &amp; Conditions'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('privacy-policy', 'Privacy Policy'); ?>
            <?php
            } else {
                ?>
                <?php echo anchor('discover', 'Discover'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('signup', 'Sign Up'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('signin', 'Sign In'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('bugs-and-reporting', 'Bugs &amp; Reporting'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('contact', 'Contact'); ?>

                <br />
                <br />

                <?php echo anchor('terms-and-conditions', 'Terms &amp; Conditions'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo anchor('privacy-policy', 'Privacy Policy'); ?>
            <?php
            } ?>



            <br />
            <br />
            Copyright &copy; <?php echo date('Y')?> Travelled Writers,  All Rights Reserved.

        </div>
        <div id="social-connect">
            <a href="http://www.pinterest.com/writerstravel/" target="_blank" title="Pinterest"><div class="social_icon pinterest"></div></a>
            <a href="http://www.tumblr.com/blog/travelledwriters" target="_blank" title="Tumblr"><div class="social_icon tumblr"></div></a>
            <a href="http://www.linkedin.com/company/travelled-writers" target="_blank" title="LinkedIn"><div class="social_icon linkedin"></div></a>
            <a href="https://plus.google.com/u/0/communities/116547279752393433966" target="_blank" title="Google Plus"><div class="social_icon googleplus"></div></a>
            <a href="http://instagram.com/travelledwriters/" target="_blank" title="Instagram"><div class="social_icon instagram"></div></a>
            <a href="https://twitter.com/writerstravel" target="_blank" title="Twitter"><div class="social_icon twitter"></div></a>
            <a href="https://www.facebook.com/travelledwriters" target="_blank" title="Facebook"><div class="social_icon facebook"></div></a>
        </div>
        </div>
	</div>

</div>
<!-- Place this asynchronous JavaScript just before your </body> tag -->


<script type="text/javascript">
        var first_run = true;

        var helper = (function() {
            var BASE_API_PATH = 'plus/v1/';

            return {
                /**
                 * Hides the sign in button and starts the post-authorization operations.
                 *
                 * @param {Object} authResult An Object which contains the access token and
                 *   other authentication information.
                 */

                onSignInCallback: function(authResult) {

                    gapi.client.load('plus','v1', function(){

                        if (authResult['access_token']) {
                            $('#authOps').show('slow');
                            $('#gConnect').hide();
                            helper.profile();
                            helper.people();
                        } else if (authResult['error']) {
                            // There was an error, which means the user is not signed in.
                            // As an example, you can handle by writing to the console:
                            console.log('There was an error: ' + authResult['error']);
                            $('#authResult').append('Logged out');
                            $('#authOps').hide('slow');
                            $('#gConnect').show();
                        }
                        console.log('authResult', authResult);
                    });
                },

                /**
                 * Calls the OAuth2 endpoint to disconnect the app for the user.
                 */
                disconnect: function() {
                    // Revoke the access token.
                    $.ajax({
                        type: 'GET',
                        url: 'https://accounts.google.com/o/oauth2/revoke?token=' +
                            gapi.auth.getToken().access_token,
                        async: false,
                        contentType: 'application/json',
                        dataType: 'jsonp',
                        success: function(result) {
                            console.log('revoke response: ' + result);
                            $('#authOps').hide();
                            $('#profile').empty();
                            $('#visiblePeople').empty();
                            $('#authResult').empty();
                            $('#gConnect').show();
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                },


                /**
                 * Gets and renders the list of people visible to this app.
                 */
                people: function() {
                    var request = gapi.client.plus.people.list({
                        'userId': 'me',
                        'collection': 'visible'
                    });
                    request.execute(function(people) {
                        $('#visiblePeople').empty();
                        $('#visiblePeople').append('Number of people visible to this app: ' +
                            people.totalItems + '<br/>');
                        for (var personIndex in people.items) {
                            person = people.items[personIndex];
                            $('#visiblePeople').append('<img src="' + person.image.url + '">');
                        }
                    });
                },
                /**
                 * Gets and renders the currently signed in user's profile data.
                 */
                profile: function(){
                    gapi.client.load('oauth2', 'v2', function() {
                        gapi.client.oauth2.userinfo.get().execute(function(resp) {

                            var request = gapi.client.plus.people.get( {'userId' : 'me'} );
                            request.execute( function(profile) {
                                //alert('username='+ encodeURIComponent(profile.displayName) + '&fullname=' + encodeURIComponent(profile.displayName) + '&email=' + resp.email + '&google_id=' + profile.id + '&google_link=' + profile.url);

                                $.ajax({	//create an ajax request to load_page.php
                                    type: "POST",
                                    url: "connectgoogleplus",
                                    data: 'username='+ profile.displayName + '&fullname=' + profile.displayName + '&email=' + resp.email + '&google_id=' + profile.id + '&google_link=' + profile.url,	//with the page number as a parameter
                                    dataType: "html",	//expect html to be returned
                                    success: function(msg){

                                        if(parseInt(msg)!=0)	//if no errors
                                        {
                                            if (msg === false) {
                                            } else {
                                                window.location = '/' + msg;
                                            }
                                        }
                                    }

                                });

                                /*  if (profile.error) {
                                 $('#profile').append(profile.error);
                                 return;
                                 }
                                 $('#profile').append(
                                 $('<p><img src=\"' + profile.image.url + '\"></p>'));

                                 $('#profile').append(
                                 $('<p>Hello ' + profile.displayName + '!<br />Tagline: ' +
                                 profile.tagline + '<br />About: ' + profile.aboutMe + '<br />ID: ' + profile.id + '<br />NickName: ' + profile.displayName + '</p>'));
                                 if (profile.cover && profile.coverPhoto) {
                                 $('#profile').append(
                                 $('<p><img src=\"' + profile.cover.coverPhoto.url + '\"></p>'));
                                 }*/
                            });
                        })
                    });
                }
            };
        })();
    /**
     * jQuery initialization
     */
    $(window).resize(function() {
        size_stories();
    });
    $(document).ready(function() {

        size_stories();
        $('#disconnect').click(helper.disconnect);
        $('#loaderror').hide();
        if ($('[data-clientid="YOUR_CLIENT_ID"]').length > 0) {
            alert('This sample requires your OAuth credentials (client ID) ' +
                'from the Google APIs console:\n' +
                '    https://code.google.com/apis/console/#:access\n\n' +
                'Find and replace YOUR_CLIENT_ID with your client ID.'
            );
        }


        // hide #back-top first
        $("#back-top").hide();

        // fade in #back-top
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 500) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }

            });

            // scroll body to 0px on click
            $('#back-top a').click(function () {
                $('#feedback-container').removeClass('opened');
                $('#feedback').removeClass('selected');
                $('#profile-link-box.opened-box').removeClass('opened-box');
                $('#profile-link-box.open').removeClass('open');
                $('#profile-link').removeClass('open');
                $('#notifications-link-box.opened-box').removeClass('opened-box');
                $('#notifications-link-box.open').removeClass('open');
                $('#notifications-link').removeClass('open');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
        function isScrolledIntoView(elem)
        {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }


    });

    /**
     * Calls the helper method that handles the authentication flow.
     *
     * @param {Object} authResult An Object which contains the access token and
     *   other authentication information.
     */
    function onSignInCallback(authResult) {
        if(!first_run) {
            helper.onSignInCallback(authResult);
        }
        first_run = false;
    }

        function size_stories() {
            var $new_width = (Math.floor(($(window).width()-270) / 270)) * 270;
            if ($new_width < 270) {
                $new_width= 270;
            } else if ($new_width < 540) {
                $new_width= 540;
            } else if ($new_width < 810) {
                $new_width= 810;
            }
            if ($new_width < 670) {
                $('.fixed_width').width($(window).width() - 40);
                $('#footer .fixed_width').width($(window).width() - 40);
                $('#header_container').width($(window).width() - 40);
                $('#stories').width($new_width);
                $('#search_errors').width($new_width);
            } else if ($new_width < 960) {

                $('#large_fixed .fixed_width').width($(window).width() - 40);

                $('#footer .fixed_width').width($(window).width() - 40);
                $('#header_container').width($(window).width() - 40);
                $('#stories').width($new_width);
                $('#search_errors').width($new_width);
            } else if ($new_width < 1200) {
                $('#footer .fixed_width').width($(window).width() - 40);
                $('#header_container').width($(window).width() - 40);
                $('#stories').width($new_width);
                $('#search_errors').width($new_width);
            } else {
                $('#footer .fixed_width').width($new_width - 20);
                $('#header_container').width($new_width - 20);
                $('#stories').width($new_width);
                $('#search_errors').width($new_width);
            }


            <?php if (isset($user) && !isset($user_viewed)) { ?>
            $('#options').width($('#reset_filters div').width() + 3 + $('#continent-options').width() + 3 + $('#only_favourites').width() + $('#tag-field').width() + $('#tag-options').width());
            <?php } else { ?>
            $('#options').width($('#reset_filters div').width() + 3 + $('#continent-options').width() + 3 + $('#tag-field').width() + $('#tag-options').width());
            <?php } ?>
        }
</script>
<div class="clear"></div>
<?php
if ($_SERVER['HTTP_HOST'] != 'applocal.travelledwriters.com') {
    ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-44759825-1', 'travelledwriters.com');
        ga('send', 'pageview');

    </script>
<?php
    }
?>


</body>
</html>