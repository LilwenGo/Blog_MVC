<?php

session_start();

require '../src/config/config.php';
require '../vendor/autoload.php';
require SRC . 'helper.php';

$router = new BlogMvc\Router($_SERVER["REQUEST_URI"]);
$router->get('/', "ArticleController@showAllArticles");
$router->get('/login/', "UserController@showLogin");
$router->get('/register/', "UserController@showRegister");
$router->get('/logout/', "UserController@logout");
$router->get('/insert/', "ArticleController@showInsert");
$router->get('/update/:id/', "ArticleController@showUpdate");
$router->get('/delete/:id/', "ArticleController@delete");

$router->post('/login/', "UserController@login");
$router->post('/register/', "UserController@register");
$router->post('/insert/', "ArticleController@create");
$router->post('/update/', "ArticleController@update");

$router->run();