<?php

require_once('session.php');

abstract class Controller {
    abstract protected function do_get();
    abstract protected function do_post();

    public function __construct() {
        Session::open();
    }

    protected function do_error($code = 500, $message) {
?>
        <h1>Erreur !</h1>
        <p class="error"><?= $message ?></p>
<?php
        http_response_code($code);
    }

    final public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method) {
            case 'GET' :
                return $this->do_get();
            case 'POST' :
                return $this->do_post();
            default :
                return $this->do_error(405, 'Méthode HTTP invalide : ' . $method);
        }
    }
}
