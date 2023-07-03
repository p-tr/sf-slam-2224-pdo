<?php

require_once('../lib/session.php');

Session::open();
$user = Session::get('user');
if($user) {
    $email = $user['email'];
    echo "<p>Bonjour $email !</p>";
    echo "<p><a href='logout.php'>Déconnexion</a></p>";
} else {
    echo "<p>Bonjour ! Veuillez vous authentifier <a href='login.php'>ici</a></p>";
}
