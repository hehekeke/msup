<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('components', dirname(dirname(__DIR__)) . '/components');
Yii::setAlias('baseUrl', 'http://'.$_SERVER['SERVER_NAME']);
Yii::setAlias('jsPath', 'http://'.$_SERVER['SERVER_NAME'].'/Public/Admin/js');
Yii::setAlias('cssPath','http://'.$_SERVER['SERVER_NAME'].'/Public/Admin/css');
Yii::setAlias('imagesPath','http://'.$_SERVER['SERVER_NAME'].'/Public/Admin/images');
Yii::setAlias('adminStatics', 'http://'.$_SERVER['SERVER_NAME'] . '/Public/Admin');
