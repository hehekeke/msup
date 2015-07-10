<?php

namespace backend\modules\Ticket\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Ticket\models\MsupSchedulingTickets;

/**
 * MsupSchedulingTicketsSearch represents the model behind the search form about `backend\modules\Ticket\models\MsupSchedulingTickets`.
 */
class MsupSchedulingTicketsSearch extends MsupSchedulingTickets
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tid', 'sid', 'uper', 'create_admin', 'sold'], 'integer'],
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
        $query = MsupSchedulingTickets::find()->with('tickets');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tid' => $this->tid,
            'sid' => $this->sid,
            'uper' => $this->uper,
            'create_admin' => $this->create_admin,
            'sold' => $this->sold,
        ]);

        return $dataProvider;
    }
}
