<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupSitesModelMap;

/**
 * MsupSitesModelMapSearch represents the model behind the search form about `backend\models\MsupSitesModelMap`.
 */
class MsupSitesModelMapSearch extends MsupSitesModelMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model', 'sitesId'], 'integer'],
            [['name', 'table'], 'safe'],
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
        $query = MsupSitesModelMap::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if (isset($_GET['siteID'])) {
            $this->sitesId = $_GET['siteID'];
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'model' => $this->model,
            'sitesId' => $this->sitesId,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'table', $this->table]);

        return $dataProvider;
    }
}
