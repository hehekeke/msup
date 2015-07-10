<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_address".
 *
 * @property integer $id
 * @property integer $lecturer_id
 * @property string $address
 * @property integer $status
 * @property string  $detail
 */
class MsupAddress extends  \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturer_id'], 'integer'],
            [['address'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecturer_id' => 'Lecturer ID',
            'address' => '所在省市',
            'detail' => '街道地址',
            'status' =>'收件地址',
        ];
    }

    /**
     * @param address 详细地址  必须有
     * @param [type] $value [description]
     */
    public function lecturerAdd($value) {


        if (!$value['address'] || !$value) {

        } else {
            $address = explode(',', $value['address']);
            $this->address = $address[0];
            $this->detail  = $address[1];
            if ($value['status'])  {
                $this->status  = $value['status'];
                $this->updateAll(['status'=>0], 'lecturer_id='.$value['model']->primaryKey);
                $Lecturer = new \backend\models\MsupLecturer;
                $Lecturer->id = $value['model']->primaryKey;

            } else {
                $this->status  = 0;
            }
            $this->lecturer_id = $value['model']->primaryKey;
            $this->save();

        }
    }

    public function lecturerUpdate($value) {
        if ( !$value['address'] ) {
            
            $this->deleteAll('id='.$value['id']);

        } else {

            $row = $this->findOne([$value['id']]);

            $address = explode(',', $value['address']);
            $detail = $address[1];
            $address = $address[0];

            if ($row) {
                $row->status = ($value['status']) ? 0 : $value['status'];
                $row->address = $address;
                $row->detail = $detail;
                $row->update();
                if ($value['status']) {
                    $this->setStatusOnly('id='.$value['id'], 'lecturer_id = '.$value['model']->primaryKey);
                }
            }
        }

    }


    

}
