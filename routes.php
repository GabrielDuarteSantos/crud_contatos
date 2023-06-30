<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'controllers/contacts.php';
require_once 'controllers/occupations.php';
require_once 'controllers/contactsOccupations.php';
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

$app->post('/api/contact', function (Request $request, Response $response) {

    $reqBody = $request->getParsedBody();

    $contact = ContactsController::create($reqBody['contact']);
    $occupations = OccupationsController::ensureMultiple($reqBody['contact']['occupations']);

    ContactsOccupationsController::createMultiple([$contact], $occupations);
    EmailsController::createMultiple($reqBody['contact']['emails'], $contact['id']);

    return $response;

});

$app->get('/api/contacts', function (Request $request, Response $response) {

    $contacts = ContactsController::getAll();
    $response = $response->withJson($contacts);

    return $response;

});

$app->run();