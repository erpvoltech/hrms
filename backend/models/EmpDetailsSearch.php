<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmpDetails;

class EmpDetailsSearch extends EmpDetails {

   public $ecode;

   public function rules() {
      return [
          [['ecode'], 'safe'],
      ];
   }

    public function scenarios() {
      return Model::scenarios();
    }

	public function search($params) {
      $query = EmpDetails::find();
      echo "<pre>";print_r($params);echo "</pre>";	
	  $ecode	=	$params['empModel']['empcode'];
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);
	  
	  $query->andFilterWhere([
          'empcode' => $ecode	  
      ]);
	  
      if (!($this->load($params))) {
         return $dataProvider;
      }
		/*$dataProvider = new ActiveDataProvider([
           'query' => $query,
        ]);

        if(!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['LIKE', 'empcode', $this->empcode]);
        */

	  
      return $dataProvider;
   }
}