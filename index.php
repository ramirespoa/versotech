<?php

include 'menu.php';

$rotas = include 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rota = rtrim($url, '/');

if (array_key_exists($rota, $rotas)) {
    $controlador = $rotas[$rota]['controller'];
    $metodo      = $rotas[$rota]['method'];
    include 'controllers/' . $controlador . '.php';
    $controlador = new $controlador();
    $controlador->$metodo();
} elseif (empty($rota)) {
    include 'controllers/HomeController.php';   
    $controlador = new HomeController();
    $controlador->index();
} else {
    http_response_code(404);
    echo "404 - Rota não encontrada.";
}