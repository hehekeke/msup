<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupSitesFieldMap;

/**
 * MsupSitesFieldMapSearch represents the model behind the search form about `backend\models\MsupSitesFieldMap`.
 */
class MsupSitesFieldMapSearch extends MsupSitesFieldMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mapId', 'coreFieldName'], 'integer'],
            [['siteField', 'coreField', 'siteFieldName'], 'safe'],
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
        $query = MsupSitesFieldMap::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mapId' => $this->mapId,
            'coreFieldName' => $this->coreFieldName,
        ]);

        $query->andFilterWhere(['like', 'siteField', $this->siteField])
            ->andFilterWhere(['like', 'coreField', $this->coreField])
            ->andFilterWhere(['like', 'siteFieldName', $this->siteFieldName]);

        return $dataProvider;
    }
}
