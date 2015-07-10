<?php

namespace backend\modules\Ticket\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Ticket\models\MsupSchedulingTicket;

/**
 * MsupSchedulingTicketSearch represents the model behind the search form about `backend\modules\Ticket\models\MsupSchedulingTicket`.
 */
class MsupSchedulingTicketSearch extends MsupSchedulingTicket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_admin', 'stid', 'isSelled', 'isActivation', 'sid'], 'integer'],
            [['bank', 'verifyPassword', 'purchase', 'owner'], 'safe'],
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
        $query = MsupSchedulingTicket::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$params['sort']) $query->orderBy('created_at desc');
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'sid' => $this->sid,
            'stid' => $this->stid,
            'isSelled' => $this->isSelled,
            'isActivation' => $this->isActivation,
            'create_admin' => $this->create_admin,
        ]);

        $query->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'verifyPassword', $this->verifyPassword])
            ->andFilterWhere(['like', 'purchase', $this->purchase])
            ->andFilterWhere(['like', 'owner', $this->owner]);

        return $dataProvider;
    }
}
