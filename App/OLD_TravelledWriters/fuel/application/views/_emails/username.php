
<table width="600" align="center"> 
    <tr>
        <td>
            Hello there!<br><br>
            You have requested to have your username resent to you. Please see below.
            <br><br>
            username: <strong><?php echo $email_variables['username']; ?></strong>
            <br><br>
            You can now return to <?= anchor('forgot', 'this page'); ?> to reset your password using this email and username.
        </td>
    </tr>
</table>

