<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_attachment".
 *
 * @property integer $id
 * @property integer $modelId
 * @property string  $modelPk
 * @property string  $attachment
 * @property integer $status
 * @property integer $hash
 * @property string  $field
 */
class MsupAttachment extends \backend\models\MsupBase
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelId', 'status'], 'integer'],
            [['hash', 'field'], 'string'],
            [['modelPk'], 'string', 'max' => 11],
            [['attachment'], 'string']
        ];
    }


    public function afterSave($insert, $changedAttributes) {
        
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'modelId' => Yii::t('app', '模型'),
            'modelPk' => Yii::t('app', '对应的模型记录主键值'),
            'attachment' => Yii::t('app', '附件信息'),
            'status' => Yii::t('app', '附件地址'),
            'hash' => Yii::t('app', '验证字符'),
            'field' => Yii::t('app', '对应模型中使用附件的字段名'),
        ];
    }
    /**
     * 通过图片显示文件
     * @param  string $file 文件路径
     * @return [type] [description]
     */
    public function showFileByImg($file) {
        $globalFunc = new \backend\components\GlobalFunc();
        $fileext = $globalFunc->fileext($file);
        // 判断文件类型输出合适的缩略图
        $html = '';
        if ( in_array($fileext, array('jpg', 'jpeg', 'png', 'gif')) ){
            $html .= '<a href="'.$file.'" class="thumbnail nmb" target="_blank"><img style="width:80px;height:80px;" src="'.$file.'" /></a>';
        } else {
            $html .= '<img style="width:80px;height:80px;" src="'.Yii::getAlias("@imagesPath").'/FileExt/'.$fileext.'.png';
        }
        return $html;
    }
    /*
     * 获取该模型相关的附件
     * @param  integer $modelId 主键ID
     * @param  integer $modelPk 模型主键
     * @param  string $field    附件字段名
     * @return array            返回结果集
    */
    public function getAttachmentByPk($modelId, $modelPk, $field) {

        return $this->findAll(['modelId' => $modelId, 'modelPk' => $modelPk, 'field' => $field]);
    }
}
