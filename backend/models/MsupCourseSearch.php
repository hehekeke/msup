<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupCourse;

/**
 * MsupCourseSearch represents the model behind the search form about `backend\models\MsupCourse`.
 */
class MsupCourseSearch extends MsupCourse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'assignToMpd', 'assignToTop100', 'assignToSalon', 'assignToMsup', 'assignToOready', 'sponsor', 'lecturer_id', 'training', 'content', 'tag', 'desc', 'speech', 'character', 'profit', 'target', 'trainees', 'teacher', 'relation', 'appointment', 'priceDesc', 'file', 'media', 'thumbs', 'other', 'auditionvideo', 'auditiondesc', 'created_at', 'updated_at', 'appointmentTime', 'level', 'lead_source', 'courseNumber'], 'safe'],
            [['courseid', 'usedtimeid', 'num', 'type', 'create_admin', 'update_admin', 'praises', 'collects', 'comments', 'hits'], 'integer'],
            [['price'], 'number'],
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
        $query = MsupCourse::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'courseid' => $this->courseid,
            'usedtimeid' => $this->usedtimeid,
            'price' => $this->price,
            'num' => $this->num,
            'type' => $this->type,
            'create_admin' => $this->create_admin,
            'update_admin' => $this->update_admin,
            'praises' => $this->praises,
            'collects' => $this->collects,
            'comments' => $this->comments,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            // ->andFilterWhere(['like', 'assignTo', $this->assignTo])
            ->andFilterWhere(['like', 'sponsor', $this->sponsor])
            ->andFilterWhere(['like', 'lecturer_id', $this->lecturer_id])
            ->andFilterWhere(['like', 'training', $this->training])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'speech', $this->speech])
            ->andFilterWhere(['like', 'character', $this->character])
            ->andFilterWhere(['like', 'profit', $this->profit])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'trainees', $this->trainees])
            ->andFilterWhere(['like', 'teacher', $this->teacher])
            ->andFilterWhere(['like', 'relation', $this->relation])
            ->andFilterWhere(['like', 'appointment', $this->appointment])
            ->andFilterWhere(['like', 'priceDesc', $this->priceDesc])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'media', $this->media])
            ->andFilterWhere(['like', 'thumbs', $this->thumbs])
            ->andFilterWhere(['like', 'other', $this->other])
            ->andFilterWhere(['like', 'auditionvideo', $this->auditionvideo])
            ->andFilterWhere(['like', 'auditiondesc', $this->auditiondesc])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'appointmentTime', $this->appointmentTime])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'lead_source', $this->lead_source])
            ->andFilterWhere(['like', 'courseNumber', $this->courseNumber]);

        return $dataProvider;
    }
}