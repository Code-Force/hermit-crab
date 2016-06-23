

$(function(){

    $('.show_reply_comment').on('click', function() {
        var $this_comment = $('#'+$(this).attr('id')+'_show_comment');
        if ($this_comment.hasClass('selected')) {
            $this_comment.removeClass('selected');
        } else {
            $('.show_comment').removeClass('selected');
            $this_comment.addClass('selected');
        }
    });
    $('#feedback').on('click', function(e){
        $('#feedback-container').addClass('opened');
        $('#feedback').addClass('selected');
        $('.opened-box').removeClass('opened-box');
        $('.open').removeClass('open');
        e.stopPropagation();

        return false;
    });
    $('html').click(function() {

        if(!$(event.target).parents("#feedback-container").is("#feedback-container") && !$(event.target).is("#feedback-container"))
        {
            $('#feedback-container').removeClass('opened');
            $('#feedback').removeClass('selected');

        }
        if(!$(event.target).parents("#profile-link-box").is("#profile-link-box") && !$(event.target).is("#profile-link-box") && !$(event.target).is(".has-popup"))
        {
            $('#profile-link-box.opened-box').removeClass('opened-box');
            $('#profile-link-box.open').removeClass('open');
            $('#profile-link').removeClass('open');

        }
        if(!$(event.target).parents("#notifications-link-box").is("#notifications-link-box") && !$(event.target).is("#notifications-link-box") && !$(event.target).is(".has-popup"))
        {
            $('#notifications-link-box.opened-box').removeClass('opened-box');
            $('#notifications-link-box.open').removeClass('open');
            $('#notifications-link').removeClass('open');

        }
    });

    $('.notification').on('click', function () {
        window.location.href = $(this).attr('data-link-value');
    });
    $('#notifications-link').on('click', function(){
        $('#update_number').hide();
        $.ajax({
            type: "POST",
            url: "checknotifications",
            data: 'last='+$('#last_notifications').val(),	//with the page number as a parameter
            dataType: "html",	//expect html to be returned
            success: function(data){
            }
        });
    });

    $('#feedback_submit').on('click', function(){
        $('#loading_feedback').show();
        $('#feedback_form').hide();

        $.ajax({
            type: "POST",
            url: "submitfeedback",
            data: 'name='+$('#feedback_name').val()+'&email='+$('#feedback_email').val()+'&feedback='+$('#feedback_text').val(),	//with the page number as a parameter
            dataType: "html",	//expect html to be returned
            success: function(data){
                if (data == 1) {
                    $('#feedback_success').html('Thanks for your feedback! If this was in regards to a fix or a bug, we may need to contact you for further details.');
                    $('#feedback_success').show();
                    $('#loading_feedback').hide();

                } else {
                    $('#loading_feedback').hide();
                    $('#feedback_form').show();
                    $('#feedback_errors').html(data);
                    $('#feedback_errors').show();

                }
            }
        });

        e.preventDefault();
        return false;
    });
    $('#close-feedback').on('click', function(){
        $('#feedback-container').removeClass('opened');
        $('#feedback').removeClass('selected');
        $('.opened-box').removeClass('opened-box');
        $('.open').removeClass('open');
    });

    $('.has-popup').on('click', function(e) {

        $this_box = $('#' + $(this).attr('id') + '-box');
        $('#feedback-container').removeClass('opened');
        $('#feedback').removeClass('selected');
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $('.header-content-box').removeClass('opened-box');
            $this_box.removeClass('opened-box');

        } else {
            $('#logged_in_nav a').removeClass('open');
            $(this).addClass('open');
            $('.header-content-box').removeClass('opened-box');
            $this_box.addClass('opened-box');

        }
        e.preventDefault();
        return false;
    })
    $('.follow-user').on('click', function(){
        if ($(this).hasClass('followed')) {
            $(this).removeClass('followed');
            $(this).attr('title', 'Follow');
            $(this).html('Follow');

            $.ajax({	//create an ajax request to load_page.php
                type: "POST",
                url: "follow",
                data: 'action=unfollow&blogger_id='+$(this).attr('data-clientId'),	//with the page number as a parameter
                dataType: "html",	//expect html to be returned
                success: function(data){
                    if (data === 'unfollowed') {

                    } else if (data === 'followed') {
                        $(this).addClass('followed');
                    }
                }
            });
        } else {
            $(this).addClass('followed');
            $(this).attr('title', 'Unfollow');
            $(this).html('Unfollow');

            $.ajax({	//create an ajax request to load_page.php
                type: "POST",
                url: "follow",
                data: 'action=follow&blogger_id='+$(this).attr('data-clientId'),	//with the page number as a parameter
                dataType: "html",	//expect html to be returned
                success: function(data){
                    if (data === 'followed') {

                    } else if (data === 'unfollowed') {
                        $(this).removeClass('followed');
                    }
                }
            });
        }
        return false;
    });

    $('.reply_comment').on('click', function() {
        $this_button = $(this);
        $this_id = $this_button.attr('id');
        if ($this_button.hasClass('selected')) {
            $this_button.removeClass('selected');
            $('#'+$this_id+'_reply_box').removeClass('selected');
        } else {
            $('.reply_comment').removeClass('selected');
            $('.reply_box').removeClass('selected');
            $('.reply_box textarea').val('');
            var $error_boxes = $('.reply_box .commenting_error_box');
            $error_boxes.removeClass('error');
            $error_boxes.removeClass('success');
            $error_boxes.hide();
            $this_button.addClass('selected');
            $('#'+$this_id+'_reply_box').addClass('selected');

        }
    });
    $('.facebook-connect').on('click', function() {
        $(this).addClass('loading');
        login();
    });

    (function() {
        var po = document.createElement('script');
        po.type = 'text/javascript'; po.async = true;
        po.src = 'https://plus.google.com/js/client:plusone.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
    })();







    $('#twitter-connect').on('click', function() {
        $('#twitter-connect .twitter-connect').addClass('loading');
    });
    $('#google-connect').on('click', function() {
        $('#google-connect .google-connect').addClass('loading');
    });
    $('.comment_textarea').autosize({append: "\n"});

    $('.submit_comment').on('click', function(e) {

        var $this = $(this).attr('id');
        var $the_error = $('#' + $this + '_error');
        var $the_comment = $('#' + $this + '_text');
        var $the_comment_box = $('#' + $this + '_box');
        var $loader = $('#' + $this + '_loader');

        $the_comment_box.fadeOut('fast', function(e){
            $the_error.removeClass('error');
            $the_error.removeClass('success');
            $the_error.fadeOut('fast');

            $loader.fadeIn('fast', function(e){
                var $reply = $('#'+$this+'_id').val();

                var $pathArray = window.location.pathname.split( '/' );

                $.ajax({
                    type: "POST",
                    url: "comment",
                    data: 'action=newpost&blogger=' + $pathArray[1] + '&reply=' + $reply + '&story_slug=' + $pathArray[2] + '&comment='+encodeURIComponent($the_comment.val()),
                    dataType: "html",
                    success: function(data){
                        var success = false;


                        if (data == 8) {
                            $the_error.html('There is a 3000 character limit');
                            $the_error.addClass('error');

                        } else if (data == 7) {
                            $the_error.html('There was an error. Please contact staff.');
                            $the_error.addClass('error');

                        } else if (data == 6) {
                            $the_error.html('Failed to comment.');
                            $the_error.addClass('error');

                        } else if (data == 5) {
                            $the_error.html('Story doesn\'t exist.');
                            $the_error.addClass('error');

                        } else if (data == 4) {
                            $the_error.html('Please don\'t blow up our website with odd invasive comments!');
                            $the_error.addClass('error');

                        } else if (data == 3) {
                            $the_error.html('You aren\'t signed in.');
                            $the_error.addClass('error');

                        } else if (data == 2) {
                            $the_error.html('There was no comment posted.');
                            $the_error.addClass('error');


                        } else {
                            $the_error.html('Comment posted successfully.');
                            $the_error.addClass('success');
                            $the_comment.val('');
                            $the_comment.height('58px');

                            $(data).hide().prependTo("#"+$this+"_all_comments").fadeIn("fast");
                            success = true;
                        }
                        if (success == true) {
                            $('.reply_comment').removeClass('selected');
                            $('.reply_box').removeClass('selected');
                            $('.reply_box textarea').val('');
                            $loader.fadeOut('fast', function(e){
                                $the_comment_box.fadeIn('fast', function(e){
                                });
                            });
                        } else {
                            $loader.fadeOut('fast', function(e){
                                $the_comment_box.fadeIn('fast', function(e){
                                    $the_error.fadeIn('fast');
                                });
                            });
                        }

                    }
                });

            });
        });

    });

});

function getFacebookCommentCount(url, callback) {
    $.getJSON('https://graph.facebook.com/?ids='+url, function(data) {
        if(url && url != '#' && url != '') {
            if(!data['error']) {
                callback(data[url]['comments']);
            }
        }
    });
}


function disconnect_social(action) {
    $('#'+action+'-connect .'+action+'-connect').addClass('loading');
    $.ajax({	//create an ajax request to load_page.php
        type: "POST",
        url: "disconnectsocial",
        data: 'action='+action,	//with the page number as a parameter
        dataType: "html",	//expect html to be returned
        success: function(data){
            window.location.href = 'settings';
        }
    });
    return false;
};