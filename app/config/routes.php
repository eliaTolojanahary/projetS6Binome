<?php
use app\controllers\HelloController;
use app\controllers\frontOffice\ArticleController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/**
 * @var Router $router
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

	
$HelloController = new HelloController();
$router -> get('/hello', [$HelloController, 'testHello']);
$ArticleController = new ArticleController();
$router->get('/', [$ArticleController, 'index']);

?>
