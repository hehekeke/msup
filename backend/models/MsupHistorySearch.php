<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupHistory;

/**
 * MsupHistorySearch represents the model behind the search form about `backend\models\MsupHistory`.
 */
class MsupHistorySearch extends MsupHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lastCommit', 'commit'], 'integer'],
            [['fieldName', 'fieldValue'], 'safe'],
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
        $query = MsupHistory::findBySql("SELECT * FROM ".MsupHistory::tableName()." AS history  GROUP BY history.fieldName, history.fieldValue ORDER BY history.id DESC")->with('title');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'lastCommit' => $this->lastCommit,
            'commit' => $this->commit,
        ]);

        $query->andFilterWhere(['like', 'fieldName', $this->fieldName])
            ->andFilterWhere(['like', 'fieldValue', $this->fieldValue]);

        return $dataProvider;
    }
}
