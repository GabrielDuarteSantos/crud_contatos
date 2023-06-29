<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'Database.php';
require_once 'controllers/contacts.php';
require_once 'controllers/emails.php';

$appOptions = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($appOptions);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer('views/');

$app->get('/', function (Request $request, Response $response) {

    $response = $this->view->render($response, 'contacts.php');

    return $response;

});

$app->post('/contact', function (Request $request, Response $response) {

    $reqBody = $request->getParsedBody();

    $contact = ContactsController::create($reqBody['contact']);

    EmailsController::createMultiple($reqBody['contact']['emails'], $contact['id']);

    return $response;

});

$app->get('/contacts', function (Request $request, Response $response) {

    $contacts = ContactsController::getAll();
    $response = $response->withJson($contacts);

    return $response;

});

$app->run();