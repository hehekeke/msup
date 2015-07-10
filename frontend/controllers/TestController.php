<?php

namespace frontend\controllers;

use yii\web\Controller;
class TestController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}
// http://www.msup.com/index.php/test/index