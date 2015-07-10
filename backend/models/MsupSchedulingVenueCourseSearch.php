<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupSchedulingVenueCourse;

/**
 * MsupSchedulingVenueCourseSearch represents the model behind the search form about `backend\models\MsupSchedulingVenueCourse`.
 */
class MsupSchedulingVenueCourseSearch extends MsupSchedulingVenueCourse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sid', 'snid', 'courseid', 'startTime', 'endTime', 'date'], 'integer'],
            [['hash'], 'safe'],
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
        $query = MsupSchedulingVenueCourse::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sid' => $this->sid,
            'snid' => $this->snid,
            'courseid' => $this->courseid,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'hash', $this->hash]);

        return $dataProvider;
    }
}
