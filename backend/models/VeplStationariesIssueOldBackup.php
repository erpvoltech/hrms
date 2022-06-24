<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vepl_stationaries_issue".
 *
 * @property int $id
 * @property string $issue_date
 * @property string $issue_to
 * @property string $remarks
 */
class VeplStationariesIssue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vepl_stationaries_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issue_date', 'issued_to', 'remarks'], 'required'],
            [['issue_date'], 'safe'],
            [['remarks'], 'string'],
            [['issued_to'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issue_date' => 'Issue Date',
            'issue_to' => 'Issue To',
            'remarks' => 'Remarks',
        ];
    }
}
