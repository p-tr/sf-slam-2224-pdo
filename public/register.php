<?php
// register.php
//  Ce fichier contient l'affichage et le traitement
// du formulaire de création de compte.
//  GET /register.php   - affichage du formulaire
//  POST /register.php  - traitement du formulaire

require_once('../lib/db.php');
require_once('../lib/session.php');

function do_get() {
?>
<form method="post" action="">
    <input type="text" name="email"><br>
    <input type="password" name="password"><br>
    <input type="password" name="confirm"><br>
    <button>Je m'inscris !</button><br>
<?php
    $errors = Session::get('errors');
    Session::flush('errors');
    if(is_array($errors) && !empty($errors)):
?>
    <ul class="error">
<?php foreach($errors as $error): ?>
        <li><?= $error ?></li>
<?php endforeach; ?>
    </ul>
<?php endif; ?>
</form>
<?php
}

function do_post() {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : null;

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $errors = [];

    if(!$email) {
        $errors[] = "Votre e-mail doit être valide !";
    }

    if(empty($password) || empty($confirm)) {
        $errors[] = "Veuillez saisir un mot de passe !";
    }

    if($password != $confirm) {
        $errors[] = "Les deux mots de passe doivent être identiques !";
    }

    if(!empty($errors)) {
        Session::set('errors', $errors);
        header('Location: register.php');
    } else {
        // TOUT VA BIEN ICI !
        // On fait le traitement du formulaire d'enregistrement !
        $db = DB::getInstance();

        $ok = $db->createUser($email, $password);

        if(!$ok) {
            $errors[] = "Erreur d'insertion en base de données !";
            Session::set('errors', $errors);
            header('Location: register.php');
        } else {
            // Ici, il faudrait un message pour informer l'utilisateur
            // de la bonne création de son compte.
            header('Location: login.php');
        }
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