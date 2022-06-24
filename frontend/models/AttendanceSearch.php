<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EngineerAttendance;
use common\models\EmpDetails;

/**
 * ProjectDetailsSearch represents the model behind the search form of `common\models\ProjectDetails`.
 */
class AttendanceSearch extends EngineerAttendance
{
    public $attdate;
	public $uid;
	public $did;
    public function rules()
    {
        return [
            [['attdate','uid','did'], 'safe'],
			];
    }

    /**
     * {@inheritdoc}
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
        $query = EngineerAttendance::find();	
        $query->joinWith(['emps']);
		
		

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
		

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([            
				'date' => Yii::$app->formatter->asDate($this->attdate, "yyyy-MM-dd"),
				'unit_id'=> $this->uid,
				'division_id'=> $this->did,
        ]); 
		
        return $dataProvider;
		#print_r($dataProvider);
    }
}
