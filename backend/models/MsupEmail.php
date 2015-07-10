<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_email".
 *
 * @property integer $id
 * @property integer $lecturer_id
 * @property string $email
 * @property integer $status
 */
class MsupEmail extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturer_id', 'status'], 'integer'],
            [['email'], 'string', 'max' => 50]
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
            'email' => Yii::t('app', '教练email'),
            'status' => Yii::t('app', '状态'),
        ];
    }

    // 教练添加邮箱信息
    public function lecturerAdd($value)
    {   


        if (!$value || !$value['email'] ) {

        } else {
            $this->email = $value['email'];
            $this->status = $value['status'];

            if ($value['status'])  {

                $this->updateAll(['status'=>0], 'lecturer_id='.$value['model']->primaryKey);

                // 更新教练邮箱
                $value['model']->updateAll(['email' => $value['email']], [$value['model']->primaryKey()[0] => $value['model']->primaryKey]);

            } else {
                $this->status  = 0;
            }

            $this->lecturer_id = $value['model']->primaryKey;
            $this->save();

            return true;
        }
    }

    //教练更新邮箱信息
    public function lecturerUpdate($value) {

        $this->lecturer_id = $value['model']->primaryKey;

        // 如果传过来的邮箱无值的时候就删掉这条记录
        if ( !$value['email'] ) {
            $this->deleteAll('id='.$value['id']);
        } else {

            $row = $this->findOne([$value['id']]);
            $row->status = $value['status'];
            $row->email = $value['email'];
            $row->update();

            if ($value['status']) {

                // 如果设置为默认邮箱则更新该教练的邮箱
                $value['model']->updateAll(['email' => $row->email], [$value['model']->primaryKey()[0] => $value['model']->primaryKey]);

                $this->setStatusOnly('id='.$value['id'], 'lecturer_id = '.$value['model']->primaryKey);
            }
        }

    }
}
