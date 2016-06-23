
<table width="600" align="center"> 
    <tr>
        <td>
            Heya <?php echo $email_variables['user']['fullname']; ?>,<br><br>
            <a href="<?php echo base_url().$email_variables['commenter']['username']; ?>"><?php echo $email_variables['commenter']['username']; ?></a> just commented on your story
            <a href="<?php echo base_url().$email_variables['user']['username'].'/'.$email_variables['story']['slug']; ?>"><?php echo $email_variables['story']['story_title']; ?></a>
            <br><br>
            If you want to stop receiving these email notifications, please sign in and change the options in your settings.
        </td>
    </tr>
</table>

