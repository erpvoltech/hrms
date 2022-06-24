<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statutory_esi".
 *
 * @property int $id
 * @property string $month
 * @property int $esi_list_no
 */
class StatutoryEsi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $file;
    public $unit;
    public $dept;
    public $division;
    public $category;
    public $pfesi;

    public static function tableName()
    {
        return 'statutory_esi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'esi_list_no', 'pfesi'], 'required'],
            [['month'], 'date', 'format' => 'php:m-Y'],
            [['esi_list_no'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
            [['pfesi'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'esi_list_no' => 'List No',
        ];
    }
}
