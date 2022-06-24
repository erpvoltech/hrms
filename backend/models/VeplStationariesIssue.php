<?php

namespace app\models;
//use app\models\VeplStationaries;
//use app\models\VeplStationariesIssueSub;
use Yii;

/**
 * This is the model class for table "vepl_stationaries_issue".
 *
 * @property int $id
 * @property string $issue_date
 * @property string $issue_to
 * @property string $remarks
 */
class VeplStationariesIssue extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
	public $doito; 
    public static function tableName() {
        return 'vepl_stationaries_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['issue_date', 'issued_to', 'division_name'], 'required'],
            [['issue_date', 'division_name', 'remarks', 'doito'], 'safe'],
            [['remarks', 'division_name'], 'string'],
            [['issued_to'], 'string', 'max' => 256],
			[['division_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'issue_date' => 'Issue Date',
            'issue_to' => 'Issue To',
            'remarks' => 'Remarks',
        ];
    }

    public function getIssuesub() {
        return $this->hasOne(VeplStationariesIssueSub::className(), ['issue_id' => 'id']);
    }
            
   
    
    /*public function getStationaries()
    {
        return $this->hasMany(VeplStationaries::className(), ['id' => 'stationaries_id'])
            ->via('Issuesub');
    }*/
}
