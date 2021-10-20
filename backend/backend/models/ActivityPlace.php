<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_place".
 *
 * @property int $activity_place_id
 * @property string $activity_id
 * @property string $place_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Activity $activity
 * @property Place $place
 */
class ActivityPlace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'place_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['activity_id', 'place_id'], 'default', 'value' => null],
            [['activity_id', 'place_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'place_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_place_id' => 'Activity Place ID',
            'activity_id' => 'กิจกรรม',
            'place_id' => 'สถานที่',
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
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['place_id' => 'place_id']);
    }
}
