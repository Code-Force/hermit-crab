<?php fuel_set_var('layout', '_layouts/fixed_width');?>
    <div class="story-title"><?= $story_viewed['story_title'] ?></div>
<?php
?>

    <div class="story_holder <?= $story_viewed['continent_name'] ?>">
        <div class="left_side">
            <div id="story-photo-title"><img src="<?= base_url().'assets/users/'.$story_viewed['folder'].'/stories/'.$story_viewed['album'].'/'.$story_viewed['story_cover']; ?>" /></div>

            <div class="author_level">
                <div class="author_img">
                    <?= anchor($story_viewed['username'], '<img src="'.base_url().'assets/users/'.$story_viewed['folder'].'/small/'.$story_viewed['profile_photo'].'"  />'); ?>
                </div>

                <div class="author_details">
                    <div class="story-author">
                        <?= anchor($story_viewed['username'], ($story_viewed['show_name'] == 'on' ? $story_viewed['fullname'] : $story_viewed['username'])); ?>
                    </div>
                    <?php
                    if (isset($user['blogger_id']) && $user_viewed['blogger_id'] != $user['blogger_id']) {
                        ?>
                        <div class="follow-user <?php if ($is_following == true) echo 'followed';  ?>" data-clientId="<?= $user_viewed['blogger_id'] ?>" title="<?php if ($is_following == true) { echo 'Unfollow'; } else { echo 'Follow'; } ?>">
                            <?php if ($is_following == true) { echo 'Unfollow'; } else { echo 'Follow'; } ?>
                        </div>

                    <?php
                    }
                    ?>
                    <?php
                    if (($story_viewed['website'] != '') || ($story_viewed['facebook_link'] != '') || ($story_viewed['google_link'] != '') || ($story_viewed['twitter_link'] != '')) {
                        ?>
                        <div class="social_links">
                            <?php

                            if (($story_viewed['twitter_link'] != '')) {
                                echo '<a href="'.$story_viewed['twitter_link'].'" target="_blank" title="Twitter"><div class="social_icon twitter"></div></a>';
                            }
                            if (($story_viewed['google_link'] != '')) {
                                echo '<a href="'.$story_viewed['google_link'].'" target="_blank" title="Google Plus"><div class="social_icon googleplus"></div></a>';
                            }
                            if (($story_viewed['facebook_link'] != '')) {
                                echo '<a href="'.$story_viewed['facebook_link'].'" target="_blank" title="Facebook"><div class="social_icon facebook"></div></a>';
                            }
                            if (($story_viewed['website'] != '')) {
                                echo '<a href="'.$story_viewed['website'].'" target="_blank" title="Personal Website"><div class="social_icon website"></div></a>';
                            }
                            ?>

                        </div>
                    <?php
                    }
                    ?>


                </div>
                <div class="location">
                    <div class="story-date">Written <?= $story_viewed['dated']; ?>&nbsp&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp&nbsp</div>
                    <div class="views dark"><?= $story_viewed['story_views'] ?></div>

                    <?php
                    if ($has_liked == true) {
                        ?>
                        <div class="likes selected dark"><?= $story_viewed['likes'] ?></div>
                    <?php
                    } else {
                    ?>
                        <div class="likes dark"><?= $story_viewed['likes'] ?></div>
                        <script>
                            $(function(){
                                $('.likes').on('click', function() {
                                    $(this).addClass('selected');
                                    $.ajax({	//create an ajax request to load_page.php
                                        type: "POST",
                                        url: "like",
                                        data: "story_id="+<?= $story_viewed['story_id'] ?>,	//with the page number as a parameter
                                        dataType: "html",	//expect html to be returned
                                        success: function(data){
                                            if (data == true){

                                                var $current_count = parseInt($('.location .likes').html());
                                                if ($current_count >= 0) {
                                                    $('.location .likes').html($current_count + 1);
                                                }
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    <?php
                    }
                    ?>


                    <div class="country"><?php echo '<img src="assets/images/msdropdown/icons/blank.gif" class="flag '.strtolower($story_viewed['iso']).' fnone" title="'.$story_viewed['nicename'].'" />'; ?>
                        <?= $story_viewed['nicename'] ?>, <?= $story_viewed['location'] ?></div>
                    <!--                        <div class="continent <?/*= $story_viewed['continent_name'] */?>"><?/*= '<img src="'.base_url().'assets/images/continents/'.$story_viewed['continent_name'].'.png" title="'.$story_viewed['continent_nicename'].'" />'; */?></div>
-->
                </div>
                <div class="addthis_box upper_addthis">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                        <div class="fb-share-button" data-href="<?= base_url().$story_viewed['username'].'/'.$story_viewed['slug'] ?>" data-type="button_count"></div>

                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <!-- AddThis Button END -->
                </div>
                <div class="upper-tags">
                    <div class="title tags-link">Tags</div>
                    <div class="clear"></div>
                    <?= $story_viewed['link_tags']; ?>
                </div>
            </div>

            <div class="the_story">
                <?php //'<img src="'.base_url().'assets/users/'.$story_viewed['folder'].'/stories/'.$story_viewed['album'].'/'.$story_viewed['story_cover'].'?'.rand(0,999999).'" height="250" />'; ?>


                <?= htmlspecialchars_decode($story_viewed['story']); ?>

                <?php
                /*if ($_SERVER['REMOTE_ADDR'] == '96.127.194.199') {
                    var_dump($likes_comments);
                }*/
                ?>
                <div class="addthis_box">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                        <div class="fb-share-button" data-href="<?= base_url().$story_viewed['username'].'/'.$story_viewed['slug'] ?>" data-type="button_count"></div>

                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <!-- AddThis Button END -->
                </div>


            </div>
            <div class="story-title">Comments (0)</div>
            <script>

                getFacebookCommentCount(<?= base_url().$story_viewed['username'].'/'.$story_viewed['slug']; ?>, function(count) {
                if (count > 0) {
                    $('#' + <?= $story_viewed['story_id']; ?> + '_comments_count').html('&nbsp;&nbsp;' + count + '&nbsp;&nbsp;');
                }
                });

            </script>

            <?php
           /* if (isset($user) && !empty($user)) {
                ?>
                <div class="comments_box" id="comments">
                    <div id="new_comment_loader" class="comment_loader"><img src="<?= base_url().'assets/images/load-stories.gif';?>" class="comments_loader_image" /></div>
                    <div class="comments_box_contain" id="new_comment_box">
                        <div class="commenter_pic">
                            <?= '<img src="'.base_url().'assets/users/'.$user['folder'].'/small/'.$user['profile_photo'].'"  />'; ?>
                        </div>
                        <div class="new_comment">
                            <textarea name="new_comment" class="comment_textarea" id="new_comment_text" placeholder="Post a new comment!"></textarea>
                        </div>

                        <div class="new_comment_submit">
                            <button name="submit_comment" id="new_comment" class="submit_comment comment-link">Post Comment</button>
                        </div>
                        <div  id="new_comment_error" class="commenting_error_box"></div>
                    </div>

                </div>
                <?php
            } else {
                ?>

            <div class="comments_box_sign_up">
            <span>To post a comment, either</span> <a href="/signin" class="sign-in-link signin-link" id="sign-in-link" target="_blank" title="Sign In">Sign In</a><span>or</span><a href="/signup" target="_blank" class="sign-up-link signup-link" id="sign-up-link" title="Sign Up">Sign Up</a>
            </div>

            <?php
            } */
            ?>

            <div id="comments" class="comments_box">
            <div class="fb-comments" id="facebook-comments-box" data-href="<?= base_url().$story_viewed['username'].'/'.$story_viewed['slug']; ?>" data-width="670" data-numposts="30" data-colorscheme="light"></div>
            </div>
        </div>
        <div class="right_side">

            <input type="hidden" id="story_id" value="<?= $story_viewed['story_id'] ?>" />
            <?php
            if (isset($user) && !empty($user) && ($story_viewed['blogger_id'] == $user['blogger_id'])) { ?>
                <a href="/edit/<?= $story_viewed['story_id'] ?>" class="edit-story edit-link" title="Edit My Story">Edit My Story</a>
                <a href="/delete/<?= $story_viewed['story_id'] ?>" class="delete-story cancel-link" title="Delete My Story">Delete My Story</a>
            <?php } ?>
            <div class="tags">
                <div class="title tags-link">Tags</div>
                <div class="clear"></div>
                <?= $story_viewed['link_tags']; ?>
            </div>
            <div class="facebook-like" id="facebook-like">
                <div class="fb-like-box" data-href="https://www.facebook.com/travelledwriters" data-width="250" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
            </div>

            <div class="related_stories" id="related_stories">
                <div class="title about-link">Other Stories</div>
                <?php
                    echo $stories;
                ?>
            </div>
        </div>
    </div>
<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
<script type="text/javascript">
    addthis.layers({
        'theme' : 'transparent',
        'share' : {
            'position' : 'left',
            'numPreferredServices' : 6
        }

    });
</script>
<!-- AddThis Smart Layers END -->