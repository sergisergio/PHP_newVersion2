<?php

require_once __DIR__ ."/../vendor/autoload.php";

use Core\Request;
use Core\Response;
use Core\Application;

$request = Request::createFromGlobals();
$request->getSession()->sessionStart();
$application = new Application();
$response = $application->boot($request);
$response->send();

/*
- Création des globales et initialisation de la requête
- Démarrage de la session
- boot du routeur via Application
- récupération des paramètres, du chemin et du controller à exécuter
- envoi de la réponse
*/
