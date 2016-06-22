<?php fuel_set_var('layout', '_layouts/fixed_width_small');?>
<div class="title edit-profile-d">Delete</div>
<div class="text top20">Time to delete your story? Be careful! if you delete it, you won't be able to retrieve it. It's gone for ever and ever!</div>

<?php
$error_message = '';
if (validation_errors() || (isset($errors))) {
    if ($errors == 1) {
        $error_message = '
        <div class="successful">
            <p>Story deleted</p>
        </div>';
    } else {
        $error_message = '
        <div class="errors">'.$errors.'</div>';
    }

}
    if ($error_message != '') {
        echo $error_message;
    } else {

    ?>
    <div class="delete_holder">
        <div class="delete_this_holder">
            <?= $the_story; ?>

            <form method="post" action="delete/<?= $story_edit['story_id'] ?>">

                <button name="delete-story" id="delete-story" class="cancel-link">Delete Story</button>
            </form>
        </div>
    </div>
    <?php
    }





















