<?php
// login.php
//  Ce fichier contient l'affichage et le traitement
// du formulaire de login.
//  GET /login.php   - affichage du formulaire
//  POST /login.php  - traitement du formulaire

require_once('../lib/session.php');
require_once('../lib/db.php');

function do_get() {
?>
<form method="POST" action="">
    <input type="text" name="email"><br>
    <input type="password" name="password"><br>
    <button>Go !</button><br>
<?php
    $error_message = Session::getErrorMessage();
    Session::flushErrorMessage();
    if($error_message) {
?>
    <p class="error"><?= $error_message ?></p>
<?php
    }
?>
</form>
<p>Pas encore de compte ? Vous pouvez vous inscrire <a href="register.php">ici</a> !</p>
<?php
}

function do_post() {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if($email) {
        $db = DB::getInstance();

        $user = $db->validateUserCredentials($email, $password);
        if($user) {
            Session::login($user);
            Session::flushErrorMessage();
            header('Location: index.php');
        } else {
            Session::setErrorMessage('Email ou mot de passe invalide');
            header('Location: login.php');
        }
    } else {
        Session::setErrorMessage('Veuillez saisir un e-mail valide !');
        header('Location: login.php');
    }
}

Session::open();

$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case 'GET' :
        do_get();
        break;
    case 'POST' :
        do_post();
        break;
    default :
        http_response_code(405);
        die("Method not allowed");
        break;
}
