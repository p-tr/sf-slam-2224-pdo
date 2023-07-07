<?php
// register.php
//  Ce fichier contient l'affichage et le traitement
// du formulaire de création de compte.
//  GET /register.php   - affichage du formulaire
//  POST /register.php  - traitement du formulaire

require_once('../lib/controllers/RegistrationController.php');

$controller = new RegistrationController();
$controller->run();