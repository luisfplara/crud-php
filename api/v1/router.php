<?php

//this file implements the slim app and set the routes

require 'vendor/autoload.php';
include_once 'products.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

//get all products route
$app->get('/products', function (Request $request, Response $response, $args) {
    //get the query param "page"
    $page = $_GET['page'];
    //get the query param "pageSize"
    $pageSize = $_GET['pageSize'];

    $products = getAllProducts($page, $pageSize);
    $totalProducts = getAllProductsCount()['COUNT(*)'];
    $totalPages = $pageSize != 0 ? ceil($totalProducts / $pageSize) : 0;

    $responseArray = [
        "pagina_atual" => $page,
        "total_paginas" => $totalPages,
        "total_registros" => $totalProducts,
        "registros_por_pagina" => $pageSize,
        "registros" => $products
    ];

    $payload = json_encode($responseArray);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');

});

//get all products route
$app->get('/products/{id}', function (Request $request, Response $response, $args) {
    //get the Id in the URI
    $id = $args['id'];
    $product = getProductById($id);
    $payload = json_encode($product);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');

});

//get all products route
$app->post('/products', function (Request $request, Response $response, $args) {
    $body = $request->getParsedBody();
    $id = createProduct($body['nome'], $body['descricao'], $body['preco'], $body['quantidade']);
    $payload = json_encode(["id" => $id]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');

});

//get all products route
$app->put('/products/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $body = $request->getParsedBody();

    updateProduct($id, $body);

    $payload = json_encode(["id" => $id]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');

});

//get all products route
$app->delete('/products/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    deleteProduct($id);
    $payload = json_encode(["id" => $id]);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');

});

//get all products route
$app->get('/', function (Request $request, Response $response, $args) {
    $body = $response->getBody();
    $body->write("<h1>SPLIT PAY - CRUD PHP</h1><h2>Technical challenge</h2>");
    return $response
        ->withBody($body);
      
});

//run the slim app
$app->run();
?>