
</main>
<!-- Place this asynchronous JavaScript just before your </body> tag -->
<script type="text/javascript">
    (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/client:plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
</script>

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
    $(document).ready(function() {
        $('#disconnect').click(helper.disconnect);
        $('#loaderror').hide();
        if ($('[data-clientid="YOUR_CLIENT_ID"]').length > 0) {
            alert('This sample requires your OAuth credentials (client ID) ' +
                'from the Google APIs console:\n' +
                '    https://code.google.com/apis/console/#:access\n\n' +
                'Find and replace YOUR_CLIENT_ID with your client ID.'
            );
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


</script>
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