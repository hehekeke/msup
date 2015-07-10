<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupAuthItem;
use backend\models\MsupAuthRule;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use yii\helpers\ArrayHelper;
/**
 * AuthItemController implements the CRUD actions for MsupAuthItem model.
 */
class AuthItemController extends CommonController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all MsupAuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MsupAuthItem::find()->orderBy('type asc, created_at desc')->where('type=1'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupAuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建一个权限或者角色
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   

        $model = new MsupAuthItem();
        $ruleName = ArrayHelper::map(MsupAuthRule::find()->asArray()->all(), 'name', 'name');

        if ( $model->load(Yii::$app->request->post()) ) {
            $auth = Yii::$app->authManager;
            // type=1 角色 type=2 权限
            if ($model->type == 1) {

                $createPost = $auth->createRole($model->name);
                
            } else {

                $createPost = $auth->createPermission($model->name);

            }
            $createPost->ruleName = $model->rule_name;
            $createPost->description = $model->description;

            if (   $auth->add($createPost) ) {

                return $this->redirect(['view', 'id' => $model->name]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'ruleName' => $ruleName,
            ]);
        }

    }

    /**
     * Updates an existing MsupAuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ruleName = ArrayHelper::map(MsupAuthRule::find()->asArray()->all(), 'name', 'name');


        if ($model->load(Yii::$app->request->post()) && $model->updateItem()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'ruleName' => $ruleName,
            ]);
        }
    }

    /**
     * Deletes an existing MsupAuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteItem($id);

        return $this->redirect(['index']);
    }

    /**
     * 分配权限给角色
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function actionAssignment($name)
    {
        $model = new MsupAuthItem;

        $authItemChild = new \backend\models\MsupAuthItemChild;
        $authItemChild->parent = $model->findOne(['name'=>$name]);

        // 获取所拥有的子权限
        $model->name = $name;
        $children = $model->getAuthItemChildren()->select("child")->asArray()->all();
        foreach ($children as $key => $value) {
            $childrens[] = $value['child'];
        }
        if ( empty($childrens) ) {
            $childrens[] = '';
        }
        if ( $authItemChild->load( Yii::$app->request->post() ) && isset($_POST['child']) ) {

            $auth = Yii::$app->authManager;

            // 添加权限
            foreach ($_POST['child'] as $key => $value) {

                if ($value !== '' && $value !== $name && !in_array($value, $childrens) ) {
                    $parent = $auth->createRole($name);
                    $child =  $auth->createPermission($value);

                    // $child->name = addslashes($child->name);
                    $auth->addChild($parent, $child);
                }
            }

            // p($childrens);
            // 删除权限
            if (!empty($childrens)) {
                
                foreach ($childrens as $key => $value) {

                    if (!in_array($value, $_POST['child'])) {

                        $parent = $auth->createRole($name);
                        $child =  $auth->createPermission($value);

                        $auth->removeChild($parent,$child);
                    }
                }

            }


            $this->redirect(['index']);

        } else {

            $auth_items = $model->find()->where('type=2')->all();

            // 循环输出获取是否拥有此权限
            foreach ($auth_items as $key => $value) {

                if ($value->name != $name) {
                    $dropDownList[$key]['name'] = $value->name;
                    $dropDownList[$key]['description'] = $value->description;

                    if (!empty($childrens) && in_array($value->name, $childrens)) {
                        $dropDownList[$key]['checked'] = 'checked';
                    }
                }

            }

            $authItemChild->child = $childrens;
            return $this->render('assignment',
                    [
                        'dropDownList'=>$dropDownList,
                        'authItemChild'=>$authItemChild,
                        'name'=>$name,
                    ]
                );
        }

    }

    /**
     * Finds the MsupAuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsupAuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        if (($model = MsupAuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
