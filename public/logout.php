<?php

require_once('../lib/session.php');

Session::open();
Session::logout();

header('Location: index.php');
