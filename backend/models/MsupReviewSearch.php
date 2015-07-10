<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupReview;

/**
 * MsupReviewSearch represents the model behind the search form about `backend\models\MsupReview`.
 */
class MsupReviewSearch extends MsupReview
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_admin', 'reviewed_admin', 'created_at', 'reviewed_at'], 'integer'],
            [['model', 'data', 'comment', 'title'], 'safe'],
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
        $query = MsupReview::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ( !$this->load($params) ) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_admin' => $this->created_admin,
            'review_admin' => $this->review_admin,
            'created_at' => $this->created_at,
            'reviewed_at' => $this->reviewed_at,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
