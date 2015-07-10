<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupContactNotes;

/**
 * MsupContactNotesSearch represents the model behind the search form about `backend\models\MsupContactNotes`.
 */
class MsupContactNotesSearch extends MsupContactNotes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'toId', 'userid', 'tomodel', 'created_at'], 'integer'],
            [['notes', 'remarks'], 'safe'],
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
        $query = MsupContactNotes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'toId' => $this->toId,
            'userid' => $this->userid,
            'tomodel' => $this->tomodel,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
