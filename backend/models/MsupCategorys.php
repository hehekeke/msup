<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "msup_categorys".
 *
 * @property integer $id
 * @property string  $catName
 * @property integer $level
 * @property integer $parentId
 * @property string  $childrenId
 * @property integer $isRequired
 * @proprety integer $listOrder
 * @property integer $type
 */
class MsupCategorys extends \backend\models\MsupBase
{
    public $isRequiredLabels = [ 1 => '是', 0 => '否'];
    public $typeLabels = [ 1 => '多选', 2 => '单选'];
    const DELIMITER = ',';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_categorys';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'parentId', 'isRequired', 'listOrder', 'type'], 'integer'],
            [['catName', 'childrenId'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '栏目ID'),
            'catName' => Yii::t('app', '栏目名称'),
            'level' => Yii::t('app', '等级'),
            'parentId' => Yii::t('app', '父栏目'),
            'childrenId' => Yii::t('app', '子栏目ID'),
            'isRequired' => Yii::t('app', '是否必选'),
            'listOrder' => Yii::t('app', '排序（由大到小）'),
            'type' => Yii::t('app', '单选还是多选'),

        ];
    }

    // 功能待测试
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (empty($this->childrenId)) {
            $this->childrenId = trim($this->childrenId.self::DELIMITER.$this->id, self::DELIMITER);
            $this->update();
        }

        if ($this->parentId) {
            $row = $this->findOne(["id" => $this->parentId]);
           if (!$row) return true;
            $row->childrenId = $this->trimChildFromChilds($row->childrenId, $this->id);
            $row->childrenId .= self::DELIMITER.$this->id;
            $row->update();
        }

        return true;
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (!$this->isNewRecord) {
               $this->removeChildFromParent($this->id);
            }
        }
        return true;
    }

    public function removeChildFromParent() {
        $row = $this->findOne(['id' => $this->id]);
        $this->trimParentsChild($row, $this->id);
    }
    private function trimParentsChild(MsupCategorys $categoryModel, $childId){

       if (!$categoryModel->parentId) {
            return false;
       }
       if (!$childId) $childId = $categoryModel->id;

       $model = new MsupCategorys;
       $row = $model->find()->select('childrenId,id')->where(['id' => $categoryModel->parentId])->one();
       $row->updateAll(['childrenId' => $this->trimChildFromChilds($row['childrenId'], $childId)], ['id'=>$row['id']]);

       if (isset($row['parentId'])) $this->trimParentsChild($row, $childId);
    }

    private function trimChildFromChilds($childrenIds, $child) {
        $childrenIds = (strpos($childrenIds, self::DELIMITER)) ? explode(self::DELIMITER, $childrenIds) : [$childrenIds];
        foreach ($childrenIds as $k => $v) {
            if ($v == $child)  {
                unset($childrenIds[$k]);
            }
        }
        return implode(self::DELIMITER, $childrenIds);
    }

    public function categoryList($parentId = 0) {
        if ($parentId) {
            $condition['parentId'] = $parentId;
        } else {
            $condition = '';
        }
        return ArrayHelper::map($this->find()->where($condition)->all(), 'id', 'catName');
    }
    public function getTags() {
        return $this->hasMany(MsupTags::className(), ['catid' => 'id']);
    }

    public function getChildIds($catId){

        if (!strpos($catId, self::DELIMITER)) {
            $catids = [$catId];
        } else {
            $catids = explode(self::DELIMITER, $catId);
        }
        $allChildrenIds = [];
        foreach($catids as $v ) {
            $childrenIds = $this->find()->select("childrenId")->where(["id" => $v])->one();
            $allChildrenIds = array_merge($allChildrenIds, explode(self::DELIMITER, $childrenIds['childrenId']));
        }
        return implode(self::DELIMITER, $allChildrenIds);
    }   
}
