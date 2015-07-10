<?php

namespace backend\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('ticket-mail');
    }

}
