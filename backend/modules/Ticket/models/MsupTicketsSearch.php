<?php

namespace backend\modules\Ticket\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Ticket\models\MsupTickets;

/**
 * MsupTicketsSearch represents the model behind the search form about `\backend\modules\Ticket\models\MsupTickets`.
 */
class MsupTicketsSearch extends MsupTickets
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isUsed', 'create_admin', 'update_admin', 'isCanChanged'], 'integer'],
            [['title', 'description', 'price', 'prefix', 'createdat', 'updatedat'], 'safe'],
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
        $query = MsupTickets::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'isUsed' => $this->isUsed,
            'create_admin' => $this->create_admin,
            'update_admin' => $this->update_admin,
            'isCanChanged' => $this->isCanChanged,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'createdat', $this->createdat])
            ->andFilterWhere(['like', 'updatedat', $this->updatedat]);

        return $dataProvider;
    }
}
