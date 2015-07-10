<?php

namespace backend\models;

use Yii;
use backend\models\MsupModel;

/**
 * This is the model class for table "msup_review".
 *
 * @property integer $id
 * @property string $model
 * @property integer $status
 * @property string $data
 * @property integer $created_admin
 * @property integer $review_admin
 * @property integer $created_at
 * @property integer $reviewed_at
 * @property string $comment
 * @property string $title
 * @property string $commit
 */
class MsupReview extends \backend\models\MsupBase
{
    // 审核状态
    public $statusLabel = ['1'=>'等待审核', '2'=>'审核通过', '-1'=>'审核不通过'];
    // 是否使用审核
    protected $isUseReview = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['status', 'created_admin', 'review_admin', 'created_at', 'reviewed_at'], 'integer'],
            [['data'], 'string'],
            [['model'], 'integer'],
            [['comment', 'title'], 'string', 'max' => 500],
            [['commit'], 'string', 'max' => 30]
        ];
    }

    /**
     * 添加数据到审核表中
     * @param string   $title   标题
     * @param interger $modelId 模型ID
     * @param array    $data    表内容
     */
    public function addReview($title, $modelId, $data = null) {
        $model = new MsupReview;
        $model->title = $title;
        $model->data  = empty($data) ? serialize(Yii::$app->request->post()) : serialize($data); 
        $model->status = 1;
        $model->model = $modelId;   
        Yii::$app->request->setBodyParams('');
        return $model->save();
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', '模型'),
            'status' => Yii::t('app', '状态'),
            'data' => Yii::t('app', '详细数据'),
            'created_admin' => Yii::t('app', '添加提交人'),
            'review_admin' => Yii::t('app', '审核人'),
            'created_at' => Yii::t('app', '添加时间'),
            'reviewed_at' => Yii::t('app', '审核时间'),
            'comment' => Yii::t('app', '审核备注'),
            'title' => Yii::t('app', '标题'),
            'commit' => Yii::t('app', '提交版本号'),
        ];
    }

    public function statusLabel($status) 
    {

        return $this->statusLabel[$status];
    }

    public function isInDb($modelClass) {

        $row = MsupModel::findOne( [ 'modelClass' => $modelClass] );

        if ($row->id) {
            return $row->id;
        } else {
            throw new \yii\web\ForbiddenHttpException("您的模型暂不允许使用审核功能，请联系管理员");
        }
    }

    

    /**
     * 根据记录id返回实际对应的模型
     * @param  interger $id        [description]
     * @return object   $tempModel 该条记录相关的model信息
     */
    public static function getModel($id)
    {
        $row = self::findOne($id);
        //获取当前所查看审核内容的model
        $model = \backend\models\MsupModel::findOne(['id'=>$row->model]);
        $modelName = $model->modelClass;
        $tempModel = new $modelName;
        $modelData = unserialize(  $row->data );

        Yii::$app->request->setBodyParams( $modelData );
        $pkName = $tempModel->primaryKey()[0];

        // 设置返回的model
        if ($pkName) {
            $pkValue = $modelData[$tempModel->getClassName()][$pkName];
        }

        if (   $pkValue ) {
            $tempModel = $tempModel->findOne($pkValue);
        }
        $tempModel->attributes = $modelData[$tempModel->getClassName()];

        return $tempModel;

    }
}
