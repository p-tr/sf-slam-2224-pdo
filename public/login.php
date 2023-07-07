<?php
// login.php
//  Ce fichier contient l'affichage et le traitement
// du formulaire de login.
//  GET /login.php   - affichage du formulaire
//  POST /login.php  - traitement du formulaire

require_once('../lib/session.php');
require_once('../lib/db.php');
require_once('../lib/view.php');

function do_get() {
?>
<form method="POST" action="">
    <input type="text" name="email"><br>
    <input type="password" name="password"><br>
    <button>Go !</button><br>
<?php 
    displayMessages(); 
    Session::flushMessages();
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
            Session::flushMessages();

            $message = new Message(Type::Success, 'Authentification OK !');
            Session::addMessage($message);

            header('Location: index.php');
        } else {
            $message = new Message(Type::Error, 'Email ou mot de passe invalide');
            Session::addMessage($message);

            header('Location: login.php');
        }
    } else {
        $message = new Message(Type::Error, 'Veuillez saisir un e-mail valide !');
        Session::addMessage($message);

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
