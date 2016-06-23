<?php fuel_set_var('layout', '_layouts/fixed_width_small');?>
<div class="title edit-profile-d">Edit</div>
<div class="text top20">Share your stories and experiences! We want to hear all about it. It's quick and easy to get started. Just fill in the simple form below, post it, and then share!</div>
<?php
if (validation_errors() || (isset($errors))) {
    if ((isset($errors)) && ($errors == 1)) {
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
<script>
    $(function(){
        var siteTags = [<?= $tags_preload; ?>];

        //-------------------------------
        // Minimal
        //-------------------------------
        $('#myTags').tagit();

        //-------------------------------
        // Single field
        //-------------------------------
        $('#story_tags').tagit({
            availableTags: siteTags,
            singleField: true,
            singleFieldNode: $('#story_tags'),
            allowSpaces: true
        });

        //-------------------------------
        // Tag events
        //-------------------------------
        var eventTags = $('#eventTags');

        var addEvent = function(text) {
            $('#events_container').append(text + '<br>');
        };

        eventTags.tagit({
            availableTags: siteTags,
            beforeTagAdded: function(evt, ui) {
                if (!ui.duringInitialization) {
                    addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                }
            },
            afterTagAdded: function(evt, ui) {
                if (!ui.duringInitialization) {
                    addEvent('afterTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                }
            },
            beforeTagRemoved: function(evt, ui) {
                addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            afterTagRemoved: function(evt, ui) {
                addEvent('afterTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            onTagClicked: function(evt, ui) {
                addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            onTagExists: function(evt, ui) {
                addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
            }
        });



    });
    $(document).ready(function() {
        $('.ui-widget-content.ui-autocomplete-input').attr('placeholder', 'Add Tags');
        $('.ui-widget-content.ui-autocomplete-input').attr('id', 'tag_maker');
        $('.ui-widget-content.ui-autocomplete-input').attr('name', 'tag_maker');
    });
</script>
<div class="write_holder">

    <form method="post" action="edit/<?= $story_edit['story_id'] ?>">
        <div class="input-group half left-story">

            <div class="mini-title">Title &amp; Description</div>
            <div class="mini-form-class">
                <div class="input-group">
                    <input type="text" name="story_title" id="story_title" class="story_title" value="<?= $story_edit['story_title']; ?>" placeholder="Title">
                    <label for="story_title" class="hide-label">Title</label>
                </div>
                <div class="input-group">
                    <input type="text" name="description" id="description" class="description" value="<?= $story_edit['description']; ?>" placeholder="Description">
                    <label for="description" class="hide-label">Description</label>
                </div>

                <div class="input-group">
                    <div class="text note">Try to make your title and description as relevant and interesting as possible to catch the attention of more people!</div>
                </div>
            </div>
            <div class="mini-title">Location</div>

            <div class="mini-form-class">
                <div class="input-group half">

                    <div class="input-group">
                        <?php

                        $selected = ' selected="selected"';

                        echo "<select name=\"country\" id=\"country\" style=\"width: 223px\">";
                        echo "<option value='' data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag none\" data-title=\"Country\">Country</option>";
                        foreach ( $countries as $country ) {
                            echo "<option value=\"$country->country_id\" data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag ".strtolower($country->iso)."\" data-title=\"".ucwords($country->nicename)."\"";
                            if ($story_edit['country_id'] == $country->country_id) {
                                echo $selected;
                            }
                            echo ">".ucwords($country->nicename)."</option>\n";
                        }
                        echo "</select>";
                        ?>

                        <label for="country" class="hide-label">Country</label>

                        <script>
                            $(document).ready(function() {
                                $("#country").msDropdown();
                            })
                        </script>
                    </div>
                    <div class="input-group">
                        <div class="text note">Select the country where your adventure took place!</div>
                    </div>
                </div>
                <div class="input-group second half">

                    <div class="input-group">
                        <input type="text" name="location" id="location" class="location" value="<?= $story_edit['location']; ?>" placeholder="City, town, region or area">
                        <label for="location" class="hide-label">City, town, region or area</label>
                    </div>

                    <div class="input-group">
                        <div class="text note">Give a little more detail to the location like city, town, region or area!</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="input-group second half cover-photo">

            <div class="mini-title">Cover Photo</div>
            <div class="mini-form-class">
                <div class="profile_left">
                    <div class="photo_holder">
                        <img src="<?= base_url().'assets/users/'.$story_edit['folder'].'/stories/'.$story_edit['album'].'/'.$story_edit['story_cover']; ?>" width="162" class="img">
                        <input type="hidden" value="<?= $story_edit['story_cover']; ?>" id="story_photo" name="story_photo">
                    </div>
                    <div class="blue-box"><a href="#photo_uploader" class= "inline edit-link">Edit Cover Photo</a></div>
                    <div class="clear"></div>

                </div>
                <script>
                    $(".inline").colorbox({inline:true, opacity: 0.8, transition:"none", onClosed:function(){ $('.imgSelect-upload').html('" />'); $('.imgSelect-container, .imgSelect-upload, .imgSelect-actions').hide(); $( ".imgareaselect-outer" ).remove(); $( ".imgareaselect-selection" ).remove(); $( ".imgareaselect-border1" ).remove(); $( ".imgareaselect-border2" ).remove(); }});
                </script>
                <input type="hidden" id="photo_upload_action" value="story">

                <script src="<?php echo base_url().'assets/js/imgSelect.js'; ?>"></script>
                <link href='<?php echo base_url().'assets/css/imgSelect.css'; ?>' rel='stylesheet' type='text/css'>

                <div id="photo_hider">
                    <div id="photo_uploader">
                        <div class="profile_left">
                            <div class="photo_holder">
                                <img src="<?= base_url().'assets/users/'.$story_edit['folder'].'/stories/'.$story_edit['album'].'/'.$story_edit['story_cover']; ?>" width="200" class="img">
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
            </div>


        </div>
<div class="clear"></div>
        <div class="mini-title">Tags</div>
        <div class="mini-form-class">

<!--            <div class="input-group half country-drop">
                <div class="input-group">
                    <?php
/*
                    echo "<select name=\"category\" id=\"category\" style=\"width: 233px\">";
                    echo "<option value='' data-image=\"assets/images/msdropdown/icons/blank.gif\" data-imagecss=\"flag none\" data-title=\"Category\">Category</option>";
                    foreach ( $categories as $category ) {
                        echo "<option value=\"$category->category_id\" data-title=\"".ucwords($country->category_name)."\"";
                        if ($story_edit['category_id'] == $category->category_id) {
                            echo 'selected="selected"';
                        }
                        echo ">".ucwords($category->category_name)."</option>\n";
                    }
                    echo "</select>";
                    */?>

                    <label for="category" class="hide-label">Category</label>

                    <script>
                        $(document).ready(function() {
                            $("#category").msDropdown();
                        })
                    </script>
                </div>
                <div class="input-group">
                    <div class="text note">The category will set the main grouping for you story. Choose wisely.</div>
                </div>
            </div>-->
            <div class="input-group tags-box">
                <div class="input-group">
                    <input type="hidden" name="story_tags" id="story_tags" value="<?= $tags_preselected; ?>">
                    <label for="tag_maker" class="hide-label">Add tags</label>

                    <ul id="story_tags"></ul>
                </div>
                <div class="input-group">
                    <div class="text note">Tags allow other users to easily find stories that matter to them. Make your tags relevant.</div>
                </div>
            </div>

        </div>
        <div class="mini-title">My Story</div>
        <div class="mini-form-class">
            <div class="input-group">
                <textarea name="story" id="story" class="story" placeholder="Story"><?= $story_edit['story']; ?></textarea>
                <label for="story" class="hide-label">Story</label>
            </div>
            <div class="input-group">
                <div class="text note">Be creative, interesting and fun! Go crazy and tell everyone about your favourite adventures or your worst experiences on the road!</div>
            </div>
        </div>
        <div class="input-group top20">
            <button name="submit-story" id="submit-story" class="sign-in finish-link">Edit Story</button>
        </div>
    </form>

</div>





<script type="text/javascript" src="<?php echo base_url()."assets/js/tinymce/tinymce.min.js" ?>"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "#story",

        plugins: [
            "advlist autolink image lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",

        relative_urls: false

    });
</script>






















