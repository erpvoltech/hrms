<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_bankdetails".
 *
 * @property int $id
 * @property int $empid
 * @property string $bankname
 * @property string $acnumber
 * @property string $branch
 * @property string $ifsc
 */
class EmpBankdetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_bankdetails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid'], 'required'],
            [['empid'], 'integer'],
            [['bankname', 'branch'], 'string', 'max' => 250],
            [['acnumber'], 'string', 'max' => 16],
            [['ifsc'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empid' => 'Empid',
            'bankname' => 'Bankname',
            'acnumber' => 'Acnumber',
            'branch' => 'Branch',
            'ifsc' => 'Ifsc',
        ];
    }
}
