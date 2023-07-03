<?php

final class Config {
    private static $config = null;

    public static function load($filename = '../config.ini') {
        self::$config = parse_ini_file($filename, true);

        return self::$config;
    }

    public static function get($section, $var) {
        return self::$config[$section][$var];
    }
}

Config::load();
