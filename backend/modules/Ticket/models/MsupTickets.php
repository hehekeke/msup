<?php

namespace backend\modules\Ticket\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "msup_tickets".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property string $prefix
 * @property integer $isUsed
 * @property integer $create_admin
 * @property string $createdat
 * @property integer $update_admin
 * @property string $updatedat
 * @property integer $isCanChanged
 */
class MsupTickets extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['isUsed', 'create_admin', 'update_admin', 'isCanChanged'], 'integer'],
            [['title', 'description'], 'string', 'max' => 300],
            [['price'], 'string', 'max' => 10],
            [['prefix'], 'string', 'max' => 5],
            [['createdat', 'updatedat'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '门票的标题'),
            'description' => Yii::t('app', '门票说明'),
            'price' => Yii::t('app', '门票价格'),
            'prefix' => Yii::t('app', '门票票号前缀'),
            'isUsed' => Yii::t('app', '是否可以使用'),
            'create_admin' => Yii::t('app', '创建人'),
            'createdat' => Yii::t('app', '添加时间'),
            'update_admin' => Yii::t('app', '最后更新人'),
            'updatedat' => Yii::t('app', '最后更新时间'),
            'isCanChanged' => Yii::t('app', '是否可被人更改'),
        ];
    }


}
