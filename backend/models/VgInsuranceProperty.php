<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vg_insurance_property".
 *
 * @property int $id
 * @property string $property_type
 * @property string $property_name
 * @property string $property_no
 * @property string $location
 * @property string $user
 * @property string $user_division
 * @property string $equipment_service
 * @property string $remarks
 */
class VgInsuranceProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vg_insurance_property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_type', 'property_name', 'property_no'], 'required'],
            [['property_type'], 'string'],
            [['property_name'], 'string', 'max' => 250],
            [['property_no', 'location', 'user'], 'string', 'max' => 150],
            [['user_division'], 'string', 'max' => 100],
            [['equipment_service'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_type' => 'Property Type',
            'property_name' => 'Property Name',
            'property_no' => 'Property No',
            'location' => 'Location',
            'user' => 'User',
            'user_division' => 'User Division',
            'equipment_service' => 'Equipment Service',
            'remarks' => 'Remarks',
        ];
    }
}
