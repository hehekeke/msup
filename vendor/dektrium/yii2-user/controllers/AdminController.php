<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user\controllers;

use dektrium\user\models\UserSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use \backend\models\MsupAuthItem;
use \backend\models\MsupAuthAssignment;
/**
 * AdminController allows you to administrate users.
 *
 * @property \dektrium\user\Module $module
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends Controller
{
    // /** @inheritdoc */
    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['post'],
                    'confirm' => ['post'],
                    'block'   => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'block', 'confirm'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return in_array(\Yii::$app->user->identity->username, $this->module->admins);
                        }
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = $this->module->manager->createUserSearch();
        $dataProvider = $searchModel->search($_GET);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->module->manager->createUser(['scenario' => 'create']);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {

            $auth = \Yii::$app->authManager;
            $role = $auth->createRole($model->role);
            $auth->updateAssign($role, $model->id);

            \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been created'));
            return $this->redirect(['index']);
        } else {

            $authItem = new MsupAuthItem;
            $authItems = $authItem->findAll(["type"=>1]);
            $ArrayHelper = new ArrayHelper;
            // $authItems = $ArrayHelper->map($authItems, 'name', 'name');
            $default['0'] = '请选择';
            $items =  $ArrayHelper->map($authItems, 'name', 'name');
            $authItems = array_merge($default,$items);

        }

        return $this->render('create', [
            'model' => $model,
            'authItems'=>$authItems
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        $authItem = new MsupAuthItem;
        $assigenMent = new MsupAuthAssignment;
        $userItem = $assigenMent->findOne(["user_id"=>$id]);
        $authItems = $authItem->findAll(["type"=>1]);
        $assigenMent->item_name = $userItem->item_name;

        $ArrayHelper = new ArrayHelper;
        $authItems = $ArrayHelper->map($authItems, 'name', 'name');
        $model->role = $userItem->item_name;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {

            $auth = \Yii::$app->authManager;
            $role = $auth->createRole($model->role);
            $auth->updateAssign($role, $model->id);

            \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been updated'));
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'authItems' =>$authItems,
            'authItem' => $assigenMent,
        ]);
    }

    /**
     * Confirms the User.
     * @param $id
     * @return \yii\web\Response
     */
    public function actionConfirm($id)
    {
        $this->findModel($id)->confirm();
        \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been confirmed'));

        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Blocks the user.
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionBlock($id)
    {
        $user = $this->findModel($id);
        if ($user->getIsBlocked()) {
            $user->unblock();
            \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been unblocked'));
        } else {
            $user->block();
            \Yii::$app->getSession()->setFlash('user.success', \Yii::t('user', 'User has been blocked'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer                    $id
     * @return \dektrium\user\models\User the loaded model
     * @throws NotFoundHttpException      if the model cannot be found
     */
    protected function findModel($id)
    {
        $user = $this->module->manager->findUserById($id);

        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }
}
