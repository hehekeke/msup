<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_publication".
 *
 * @property integer $id
 * @property string $name
 * @property string $time
 * @property string $price
 * @property string $url
 * @property integer $lecturer_id
 */
class MsupPublication extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_publication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['lecturer_id'], 'integer', 'min' => 1],
            [['name'], 'string', 'max' => 50],
            [['price'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 220]
        ];
    }

    public function lecturerAdd($value)
    {   
        if (empty($value) || empty($value['name'])){

        } else {

            $this->name = $value['name'];
            $this->time = $value['time'];
            $this->url  = $value['url'];
            $this->lecturer_id = $value['model']->primaryKey;
            $this->save();
            return 1;
        }
    }

    public function lecturerUpdate($value) {
        if ( !$value['name'] ) {
            
            $this->deleteAll('id='.$value['id']);

        } else {
            $row = $this->findOne([$value['id']]);
            $row->name = $value['name'];
            $row->update();
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '出版物名陈'),
            'time' => Yii::t('app', '出版时间'),
            'price' => Yii::t('app', '价格'),
            'url' => Yii::t('app', '商品链接'),
        ];
    }
}
