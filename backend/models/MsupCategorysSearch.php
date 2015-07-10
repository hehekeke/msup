<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupCategorys;

/**
 * MsupCategorysSearch represents the model behind the search form about `backend\models\MsupCategorys`.
 */
class MsupCategorysSearch extends MsupCategorys
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catName', 'level', 'parentId', 'childrenId'], 'integer'],
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
        $query = MsupCategorys::find();
        if (Yii::$app->request->get('pid'))
        {
            $query = $query->where(['parentId' => Yii::$app->request->get('pid')]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('listOrder desc')->andWhere('parentId > 0'),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'catName' => $this->catName,
            'level' => $this->level,
            'parentId' => $this->parentId,
            'childrenId' => $this->childrenId,
        ]);

        return $dataProvider;
    }
}
