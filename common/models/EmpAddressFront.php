<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emp_address".
 *
 * @property int $id
 * @property int $empid
 * @property string $addfield1
 * @property string $addfield2
 * @property string $addfield3
 * @property string $addfield4
 * @property string $addfield5
 * @property string $district
 * @property string $state
 * @property string $pincode
 * @property string $addfieldtwo1
 * @property string $addfieldtwo2
 * @property string $addfieldtwo3
 * @property string $addfieldtwo4
 * @property string $addfieldtwo5
 * @property string $districttwo
 * @property string $statetwo
 * @property string $pincodetwo
 */
class EmpAddressFront extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_address_front';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empid','addfield1', 'addfield2', 'addfield3', 'addfield4', 'addfield5', 'district', 'state','pincode'], 'required'],
            [['empid'], 'integer'],
            [['addfield1', 'addfield2', 'addfield3', 'addfield4', 'addfield5', 'district', 'state', 'addfieldtwo1', 'addfieldtwo2', 'addfieldtwo3', 'addfieldtwo4', 'addfieldtwo5', 'districttwo', 'statetwo'], 'string', 'max' => 150],
            [['pincode', 'pincodetwo'], 'string', 'max' => 10],
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
            'addfield1' => 'Res. No',
            'addfield2' => 'Res. Name',
            'addfield3' => 'Road/Street',
            'addfield4' => 'Locality/Area',
            'addfield5' => 'City',
            'district' => 'District',
            'state' => 'State',
            'pincode' => 'Pincode',
            'addfieldtwo1' => 'Res. No',
            'addfieldtwo2' => 'Res. Name',
            'addfieldtwo3' => 'Road/Street',
            'addfieldtwo4' => 'Locality/Area',
            'addfieldtwo5' => 'City',
            'districttwo' => 'District',
            'statetwo' => 'State',
            'pincodetwo' => 'Pincode',
        ];
    }
}
