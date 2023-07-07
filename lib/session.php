<?php
// session.php
//  Ce fichier contient la classe Session permettant de
// gérer le conteneur de session de PHP.

require('message.php');

class Session {
    const CURRENT_USER = 'user';
    const MESSAGES = 'messages';

    public static function open() {
        session_start();
    }

    public static function login($user) {
        self::set(self::CURRENT_USER, $user);
    }

    public static function logout() {
        self::flush(self::CURRENT_USER);
    }

    public static function getUser() {
        return self::get(self::CURRENT_USER);
    }

    public static function addMessage(Message $message) {
        if(!is_array($_SESSION[self::MESSAGES])) {
            $_SESSION[self::MESSAGES] = [];
        }

        $_SESSION[self::MESSAGES][] = $message;
    }

    public static function getMessages(?Type $type = null) {
        $messages = self::get(self::MESSAGES);

        if(!is_null($type)) {
            $messages = array_filter($messages, function($m) use($type) {
                return $m->getType() == $type;
            });
        }

        return $messages;
    }

    public static function flushMessages() {
        self::flush(self::MESSAGES);
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
