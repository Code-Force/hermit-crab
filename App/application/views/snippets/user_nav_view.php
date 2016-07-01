<ul>
    <li>
        <a href="/">Go to Home Page</a>
    </li>
    <?
    var_dump($user);
    if(isset($user) && $user) { ?>
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
            <a href="/login" class="modok" data-url="/login/ajax">login</a>
        </li>
        <li>
            <a href="/register">register</a>
        </li>
    <? } ?>
</ul>