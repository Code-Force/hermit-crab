
<table width="600" align="center"> 
    <tr>
        <td>
            Hey <?php echo $email_variables['username']; ?>,<br><br>
            You have just successfully connected your <?php echo $email_variables['social']; ?> Account to Travelled Writers! You have been automatically logged in.
            <br><br>
            We have provided you with your new username and password.
            <br><br>
            Username: <?php echo $email_variables['username']; ?><br>
            Password: <?php echo $email_variables['password']; ?><br>
            <br>
            You may change either one in the <a href="<?php echo $email_variables['settings']; ?>">Settings</a> section.
        </td>
    </tr>
</table>

