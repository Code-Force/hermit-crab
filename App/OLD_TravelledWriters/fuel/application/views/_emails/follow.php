
<table width="600" align="center"> 
    <tr>
        <td>
            Heya <?php echo $email_variables['followed']['fullname']; ?>,<br><br>
            You are now being followed by <a href="<?php echo base_url().$email_variables['follower']['username']; ?>"><?php echo $email_variables['follower']['username']; ?></a>
            <br><br>
            If you want to stop receiving these email notifications, please sign in and change the options on your settings page.
        </td>
    </tr>
</table>

