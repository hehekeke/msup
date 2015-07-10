<?php

namespace backend\models;

use Yii;
use backend\models\MsupCategorys;
use backend\models\MsupTags;
use backend\models\MsupLecturer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "msup_tag_relation".
 *
 * @property integer $id
 * @property integer $modelId
 * @property integer $pkId
 * @property integer $tagId
 */
class MsupTagRelation extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_tag_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelId', 'pkId', 'tagId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'modelId' => Yii::t('app', '模型'),
            'pkId' => Yii::t('app', '主键'),
            'tagId' => Yii::t('app', '标签'),
        ];
    }

    public function lecturerAdd($attributes) {
        $this->tagRelationAdd($attributes, MsupLecturer::className());
    }

    public function tagRelationAdd($model, $attributes) {
        if (empty($attributes['tagId'])) return;
        // 循环查询
        $tagModel = new MsupTags;
        foreach ( (Array)$attributes['tagId'] as $key => $v) {
            // 检查是否已存在该标签记录
            $row = $this->findOne(['tagId' => $v, 'modelId' => $model->modelId, 'pkId' => $model->primaryKey]);
            if ( !$row->id ) {

                $tagRelationModel = new MsupTagRelation;

                $tagRelationModel->tagId = $v;
                $tagRelationModel->pkId  = $model->primaryKey;
                $tagRelationModel->modelId = $model->modelId;

                $tagRelationModel->insert();
                $tagModel->updateAllCounters(['citations' => 1], 'id='.$v);
                
            }

        }
        $this->checkUpdate($attributes['tagId'], $model->modelId, $model->primaryKey); 

        
          
    }
    /**
     * 添加教练标签
     * @param  [type]  $attributes      [description]
     * @param  boolean $modelClass      [description]
     * @return [type]                   [description]
     */
    public function tagRelationAddByPost($model)
    {

        if (!$model->modelId) {
            throw new \yii\web\NotFoundHttpException("该模型尚未添加到模型管理中");
        }

        $attributes = Yii::$app->request->post()['MsupTagRelation'];
        // 过滤掉post中的MsupTagRelation
        $bodyParams = Yii::$app->request->getBodyParams();
        unset($bodyParams['MsupTagRelation']);
        Yii::$app->request->setBodyParams($bodyParams);
        $this->tagRelationAdd($model, $attributes);

    }


    /**
     * 检查编辑情况，如果传入的数组中与查询到的结果
     * 有差异则删除掉没有出现在传入的数组中的标签
     * @param $postTagIds   更新时传入的tagId 数组
     * @param $modelID      需要搜索的模型ID
     * @param $pkId         需要搜索的实际记录ID
     * @return boolean;
     */
    public function checkUpdate($postTagIds, $modelId, $pkId) {
        $row = $this->find()->where(['modelId' => $modelId, 'pkId' => $pkId ])->asArray()->all();

        $inDbRows = ArrayHelper::map($row, 'id', 'tagId');

        $notInDb = array_diff($inDbRows, (Array)$postTagIds);
        $notInDb = implode(',', $notInDb);

        // 如果有修改时
        if ($notInDb) {

            // $this->deleteAll(' tagId in (:notInDb) AND pkId=:pkId AND modelId=:modelId', [':notInDb'=> $notInDb, ':pkId' => $pkId, ':modelId' => $modelId]);
            $tagModel = new MsupTags;
            $tagModel->updateAllCounters(['citations' => '-1'], 'id in ('.$notInDb.') AND citations >1 ');
            
        }
    }

    /**
     * 管理员和角色对照
     * @return [type] [description]
     */
    public function autoRelationRoleTag(MsupBase $model){
        $row = $model->find()->all();
        $adminRole = Yii::$app->params['adminRoleWithTag'];
        $tagIds = implode(',', array_keys($adminRole));

        if (!empty($row)) {
            echo '程序开始执行'.'<br />';
            foreach($row as $v) {
                // 检查该记录创建者是否是6个角色的管理员
                if (in_array($v->create_admin, array_keys($adminRole))) {
                    $tagId = $adminRole[$v['create_admin']];
                    // 检查该记录是否有角色标签
                    $tagRelationRow = $this->find()->where( ['modelId' => $model->modelId, 'pkId' => $v->primaryKey] )->andWhere('tagId in ('.$tagIds.')')->one();
                    // 记录没有角色标签时，插入记录 到数据库中
                    if (!$tagRelationRow->primaryKey) {
                        $tagRelationModel = clone($this);
                        $tagRelationModel->modelId = $model->modelId;
                        $tagRelationModel->pkId = $v->primaryKey;
                        $tagRelationModel->tagId = $tagId;
                        if ($tagRelationModel->save()) {
                            $tagModel = new MsupTags;
                            $tagModel->updateAllCounters( ['citations' => '+1'], ['id' => $tagId]);
                        }

                    }
                }
            }
            echo '操作成功';
        }
    }

    public function getLecturer(){
        return $this->hasOne(MsupLecturer::className(), ['id' => 'pkId']);
    }
    public function getCourse(){
        return $this->hasOne(MsupCourse::className(), ['id' => 'pkId']);
    }
    // 获取对应的标签
    public function getTags(){
        return $this->hasOne(Msuptags::className(), ['id' => 'tagId']);
    }

}
