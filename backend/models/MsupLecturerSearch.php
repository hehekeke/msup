<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MsupLecturer;

/**
 * MsupLecturerSearch represents the model behind the search form about `backend\models\MsupLecturer`.
 */
class MsupLecturerSearch extends MsupLecturer
{
    /**
     * @inheritdoc
     */
   /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'create_admin', 'update_admin', 'status'], 'integer'],
            [['content'], 'string'],
            [['name', 'company', 'position', 'referee', 'penName', 'leadSource'], 'string', 'max' => 100],
            [['phone', 'qq'], 'string', 'max' => 20],
            [['email', 'wecat'], 'string', 'max' => 30],
            [['thumbs', 'description'], 'string', 'max' => 3000],
            [['signature'], 'string', 'max' => 1000],
            [['idNumber'], 'string', 'max' => 18]
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

        $aTableName = MsupLecturerAssignment::tableName();
        $uTableName = \dektrium\user\models\User::tableName();
        $query = MsupLecturer::find()->joinWith( 
                                'lecturerAssignment'
                               )->joinWith('lecturerAssignment.user');
        
        // 如果没有排序的话默认为id
        if (!$params['sort']) $query->orderBy('id desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])->andFilterWhere(['like', 'company', $this->company])->andFilterWhere(['like', 'penName', $this->penName])->andFilterWhere([ 'like', 'position', $this->position]);

        return $dataProvider;
    }
}
