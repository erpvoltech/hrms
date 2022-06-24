<?php
namespace app\models;
use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "recruitment".
 *
 * @property int $id
 * @property string $Name
 * @property string $qualification
 * @property string $year_of_passing
 * @property string $selection_mode
 * @property string $position
 * @property string $contact_no
 * @property string $status
 * @property string $rejected_reason
 * @property string $resume
 */
class Recruitment extends \yii\db\ActiveRecord
{
    /**
    * @inheritdoc
    */
	public $offerletter;
	public $offerletter_type;
	#public $training_status;
    public static function tableName()
    {
        return 'recruitment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [			
            //[['batch_id'], 'required'],			
            [['name','register_no'], 'required'],
            [['year_of_passing','type'], 'safe'],
            [['selection_mode','other_selection_mode', 'status', 'rejected_reason'], 'string'],
            [['name', 'position', 'referred_by','other_selection_mode'], 'string', 'max' => 250],
            [['qualification'], 'string', 'max' => 150],
			[['specialization'], 'string', 'max' => 255],
            [['contact_no'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['community'], 'string', 'max' => 30],            
            [['caste'], 'string', 'max' => 50],            
			[['batch_id'], 'integer'],
			[['resume'], 'file', 'skipOnEmpty' => true, 'extensions' => 'docx, doc, pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'register_no' => 'Register No',
            'type' => 'Type',
            'batch_id' => 'Batch',
			'name' => 'Name',
            'qualification' => 'Qual',
            'specialization' => 'Specify',
            'year_of_passing' => 'YOP',
            'selection_mode' => 'Source',
			'referred_by' => 'Referred By',
			'other_selection_mode' => 'Other Selection Mode',
            'position' => 'Pos',
            'contact_no' => 'Contact No',			
            'email' => 'Mail Id',			
            'community' => 'Community',			
            'status' => 'Status',
            'process_status' => 'Process Status',
            'callletter_status' => 'Callletter',
            'rejected_reason' => 'Reason',
            'resume' => 'Resume',
            'mail_option' => '',
			];
    }
	
	public function upload()
    {
		
        if ($this->validate()) {
            $this->resume->saveAs('employee/' . $this->resume->baseName . '.' . $this->resume->extension);
            return true;
        } else {
            return false;
        }
    }
}