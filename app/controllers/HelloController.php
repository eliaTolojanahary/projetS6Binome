<?php

namespace app\controllers;

use app\models\HelloModel;
use Flight;
class HelloController {

	public function __construct() {
	}
  public static function testHello()
  {
      $model = new HelloModel();
      $hello = $model->sayHello();
      Flight::render('hello' , ['hello' => $hello]);            
  }
}