<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupSchedulingVenue;

/**
 * MsupSchedulingVenueSearch represents the model behind the search form about `backend\models\MsupSchedulingVenue`.
 */
class MsupSchedulingVenueSearch extends MsupSchedulingVenue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sid'], 'integer'],
            [['venueName', 'hash'], 'safe'],
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
        $query = MsupSchedulingVenue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sid' => $this->sid,
        ]);

        $query->andFilterWhere(['like', 'venueName', $this->venueName])
            ->andFilterWhere(['like', 'hash', $this->hash]);

        return $dataProvider;
    }
}
