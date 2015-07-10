<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupTags;

/**
 * MsupTagsSearch represents the model behind the search form about `backend\models\MsupTags`.
 */
class MsupTagsSearch extends MsupTags
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'catid', 'hits'], 'integer'],
            [['tagName'], 'safe'],
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
        $query = MsupTags::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
            'catid' => $this->catid,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'tagName', $this->tagName]);

        return $dataProvider;
    }
}
