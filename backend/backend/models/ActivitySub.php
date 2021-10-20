<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_sub".
 *
 * @property string $activity_id
 * @property int $activity_sub_id
 * @property string $activity_sub_name
 * @property string $activity_sub_name_en
 * @property string $activity_sub_detail
 * @property string $activity_sub_detail_en
 * @property int $activity_sub_order
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Activity $activity
 */
class ActivitySub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'activity_sub_order'], 'default', 'value' => null],
            [['activity_id', 'activity_sub_order'], 'integer'],
            [['activity_sub_detail', 'activity_sub_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['activity_sub_name', 'activity_sub_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['activity_id','activity_sub_name' ], 'required', 'message' => '**กรุณากรอกข้อมูล'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'กิจกรรมหลัก',
            'activity_sub_id' => 'Activity Sub ID',
            'activity_sub_name' => 'ชื่อกิจกรรมย่อย',
            'activity_sub_name_en' => 'ชื่อภาษาอังกฤษ',
            'activity_sub_detail' => 'Activity Sub Detail',
            'activity_sub_detail_en' => 'Activity Sub Detail En',
            'activity_sub_order' => 'ลำดับ',
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
}
