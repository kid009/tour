<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_homestay".
 *
 * @property string $activity_id
 * @property int $activity_homestay_id
 * @property string $homestay_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Activity $activity
 * @property Homestay $homestay
 */
class ActivityHomestay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_homestay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'homestay_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['activity_id', 'homestay_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['homestay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Homestay::className(), 'targetAttribute' => ['homestay_id' => 'homestay_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'กิจกรรม',
            'activity_homestay_id' => 'Activity Homestay ID',
            'homestay_id' => 'โฮมสเตย์',
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
    public function getHomestay()
    {
        return $this->hasOne(Homestay::className(), ['homestay_id' => 'homestay_id']);
    }
}
