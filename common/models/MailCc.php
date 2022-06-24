<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mail_cc".
 *
 * @property int $id
 * @property int $division
 * @property string $cc
 * @property string $bcc
 */
class MailCc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_cc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division','unit'], 'required'],
            [['division'], 'integer'],
            [['cc', 'bcc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division' => 'Division',
			'unit' => 'Unit',
            'cc' => 'CC',
            'bcc' => 'BCC',
        ];
    }
}
