<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_directory".
 *
 * @property integer $id
 * @property integer $lecturer_id
 * @property string $phone
 * @property integer $status
 */

/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */ 
class MsupDirectory extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_directory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturer_id', 'status'], 'integer'],
            [['phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lecturer_id' => Yii::t('app', '教练ID'),
            'phone' => Yii::t('app', '手机号/座机'),
            'status' => Yii::t('app', '是否正在使用'),
        ];
    }

    //讲师添加联系方式
    public function lecturerAdd($value)
    {   

        if (!$value || !$value['phone'] ) {

        } else {

            $this->phone = $value['phone'];
            if ($value['status'])  {

                // 如果设置为默认则更新该教练的手机号
                $value['model']->updateAll(['phone' => $value['phone']], [$value['model']->primaryKey()[0] => $value['model']->primaryKey]);

                $this->status  = $value['status'];
                $this->updateAll(['status'=>0], 'lecturer_id='.$value['model']->primaryKey);
            } else {
                $this->status  = 0;
            }
            $this->lecturer_id = $value['model']->primaryKey;
            $this->save();

            return 1;
        }
    }

    // 讲师更新联系方式
    public function lecturerUpdate($value) {

        $this->lecturer_id = $value['lecturer_id'];
        if ( !$value['phone'] ) {
            
            $this->deleteAll('id='.$value['id']);

        } else {
            $row = $this->findOne([$value['id']]);
            $row->status = isset($value['status']) ? $value['status'] : 0;
            $row->phone = $value['phone'];
            $row->update();
            if ($value['status']) {

                // 如果设置为默认联系好吗则更新该教练的手机号
                $value['model']->updateAll(['phone' => $value['phone']], [$value['model']->primaryKey()[0] => $value['model']->primaryKey]);
                
                $this->setStatusOnly('id='.$value['id'], 'lecturer_id = '.$value['model']->primaryKey);
            }
        }


    }


    public function getLecturer($value='')
    {
        return $this->hasOne(MsupLecturer::className(),['id' => 'lecturer_id']);
    }

}
