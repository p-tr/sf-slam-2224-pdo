<?php
// session.php
//  Ce fichier contient la classe Session permettant de
// gérer le conteneur de session de PHP.

class Session {
    public static function open() {
        session_start();
    }

    public static function login($user) {
        $_SESSION['user'] = $user;
    }

    public static function logout() {
        unset($_SESSION['user']);
    }

    public static function getUser() {
        if(!isset($_SESSION['user'])) {
            $_SESSION['user'] = null;
        }

        $user = $_SESSION['user'];
        return $user;
    }

    public static function setErrorMessage($message = '') {
        $_SESSION['error_message'] = $message;
    }

    public static function getErrorMessage() {
        return isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
    }

    public static function flushErrorMessage() {
        unset($_SESSION['error_message']);
    }

    public static function getErrors() {
        return isset($_SESSION['errors']) ? $_SESSION['errors'] : null;
    }

    public static function setErrors($errors) {
        $_SESSION['errors'] = $errors;
    }

    public static function flushErrors() {
        unset($_SESSION['errors']);
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function flush($key) {
        unset($_SESSION[$key]);
    }
}
