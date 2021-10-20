<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_nature".
 *
 * @property string $activity_id
 * @property int $activity_nature_id
 * @property string $nature_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Activity $activity
 * @property Nature $nature
 */
class ActivityNature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_nature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'nature_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['activity_id', 'nature_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['nature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nature::className(), 'targetAttribute' => ['nature_id' => 'nature_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'กิจกรรม',
            'activity_nature_id' => 'Activity Nature ID',
            'nature_id' => 'สถานที่ธรรมชาติ',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['activity_id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNature()
    {
        return $this->hasOne(Nature::className(), ['nature_id' => 'nature_id']);
    }
}
