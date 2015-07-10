<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_tags".
 *
 * @property integer $id
 * @property string $tagName
 * @property integer $level
 * @property integer $catid
 * @property integer $hits
 * @property integer $citations
 */
class MsupTags extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'catid', 'hits', 'citations'], 'integer'],
            [['tagName'], 'string', 'max' => 50]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tagName' => Yii::t('app', '标签名字'),
            'level' => Yii::t('app', '等级'),
            'catid' => Yii::t('app', '分类ID'),
            'hits' => Yii::t('app', '点击数'),
            'citations' => Yii::t('app', '引用次数'),
        ];
    }

    // 通过栏目ID 获得所有的标签
    public function getTagsWidthCate($catId=1) {
        $cateModel = new MsupCategorys;
        $query = $cateModel->find()->with(['tags' => function($query){
            $query->orderBy('citations desc,hits desc');
        }]);
        $where = '';
        $catId = $cateModel->getChildIds($catId);
        if ($catId) {
            $where = 'id in ('.trim($catId, ',').')';   
        } 
        $row = $query->where($where)->orderBy('listOrder desc')->asArray()->all();

        return $row;
    }
}
