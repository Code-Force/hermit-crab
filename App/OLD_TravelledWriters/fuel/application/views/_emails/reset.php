
<table width="600" align="center"> 
    <tr>
        <td>
            Hey <?php echo $email_variables['username']; ?>,<br><br>
            You have requested to have your password reset. Simply click the link below to reset your password!
            <br><br
            <a href="<?php echo $email_variables['reset_link']; ?>"><?php echo $email_variables['reset_link']; ?></a>
        </td>
    </tr>
</table>

