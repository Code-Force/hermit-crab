<ul>
    <li>
        <a href="/">Go to Home Page</a>
    </li>
    <?
    if($user) { ?>
        <li>
            <a href="/<?= $user['username']; ?>">My Profile</a>
        </li>
        <li>
            <a href="/account">My Account</a>
        </li>
        <li>
            <a href="/logout">logout</a>
        </li>
    <? } else { ?>
        <li>
            <a href="/login">login</a>
        </li>
    <? } ?>
</ul>