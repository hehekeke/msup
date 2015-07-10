<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupScheduling;

/**
 * MsupSchedulingSearch represents the model behind the search form about `backend\models\MsupScheduling`.
 */
class MsupSchedulingSearch extends MsupScheduling
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'catid'], 'integer'],
            [['startTime','endTime','title',  'video', 'address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MsupScheduling::find();

        if (Yii::$app->request->get('create_admin')) {
            $query = $query->andWhere( ['create_admin' => Yii::$app->request->get('create_admin')] );
        } 

        if (!Yii::$app->request->get('sort')) $query->orderBy('id desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'catid' => $this->catid,
            'create_admin' => $params['MsupSchedulingSearch']['create_admin'],
        ]);

        if ($this->startTime) {

            $query->andWhere('startTime >= '.strtotime($this->startTime));
        }
        if ($this->endTime) {

            $query->andWhere('endTime <= '.strtotime($this->endTime));
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'address', $this->address]);
        return $dataProvider;
    }
}
