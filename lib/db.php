<?php
// db.php
//  Ce fichier centralise tout ce qui concerne la base
// de données de l'application web.

// DB est un singleton
//  Ceci implique :
//      - un constructeur privé
//      - une méthode statique pour récupérer la seule instance de la classe
//      - une propriété statique qui contient l'instance de la classe

require_once('config.php');

final class DB {
    private $pdo;
    private $initialized;

    private static $instance = null;
    
    private function __construct() {
        $dsn = Config::get('pdo', 'dsn');

        $this->initialized = false;
        $this->pdo = new PDO($dsn);
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new self();
            self::$instance->init();
        }

        return self::$instance;
    }

    public function init() {
        $sql = "CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, pass TEXT)";
        $res = $this->pdo->exec($sql); // exécution directe d'instructions SQL

        // Si on a plusieurs tables, ne pas oublier de sortir de l'exécution
        // en cas d'erreur ($pdo->exec renvoie false dans ce cas)
        //if($res === false) {
        //    return $res;
        //}

        $this->initialized = true;
    }


    // gestion des comptes utilisateur
    public function createUser($email, $pass) {
        $query = $this->pdo->prepare("INSERT INTO users(email,pass) VALUES (:email,:pass)");
        $ok = $query->execute([ 'email' => $email, 'pass' => $this->hashPassword($pass) ]);
        return $ok;
    }

    public function validateUserCredentials($email, $pass) {
        $user = null;
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email=:email AND pass=:pass");
        
        $ok = $query->execute([ 'email' => $email, 'pass' => $this->hashPassword($pass) ]);
        if($ok) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $user;
    }

    private function hashPassword($pass) {
        return hash("sha256", $pass);
    }
}
