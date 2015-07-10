<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupAppointLecturer;

/**
 * MsupAppointLecturerSearch represents the model behind the search form about `\backend\models\MsupAppointLecturer`.
 */
class MsupAppointLecturerSearch extends MsupAppointLecturer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appId', 'lid'], 'integer'],
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
        $query = MsupAppointLecturer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'appId' => $this->appId,
            'lid' => $this->lid,
        ]);

        return $dataProvider;
    }
}
