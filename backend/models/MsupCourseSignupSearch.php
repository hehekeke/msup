<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupCourseSignup;

/**
 * MsupCourseSignupSearch represents the model behind the search form about `\backend\models\MsupCourseSignup`.
 */
class MsupCourseSignupSearch extends MsupCourseSignup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appId', 'sid'], 'integer'],
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
        $query = MsupCourseSignup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'appId' => $this->appId,
            'sid' => $this->sid,
        ]);

        return $dataProvider;
    }
}
