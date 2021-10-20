<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourism_sub_route_activity".
 *
 * @property string $tourism_sub_route_id
 * @property int $tourism_sub_route_activity_id
 * @property string $activity_id
 * @property int $tourism_sub_route_activity_order
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $tourism_main_route_id
 *
 * @property Activity $activity
 * @property TourismMainRoute $tourismMainRoute
 * @property TourismSubRoute $tourismSubRoute
 */
class TourismSubRouteActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_sub_route_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_sub_route_id', 'activity_id'], 'required', 'message' => 'กรุณากรอกข้อมูล'],
            [['tourism_sub_route_id', 'activity_id', 'tourism_sub_route_activity_order', 'tourism_main_route_id'], 'default', 'value' => null],
            [['tourism_sub_route_id', 'activity_id', 'tourism_sub_route_activity_order', 'tourism_main_route_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['tourism_main_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismMainRoute::className(), 'targetAttribute' => ['tourism_main_route_id' => 'tourism_main_route_id']],
            [['tourism_sub_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismSubRoute::className(), 'targetAttribute' => ['tourism_sub_route_id' => 'tourism_sub_route_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_sub_route_id' => 'เส้นทางท่องเที่ยวย่อย',
            'tourism_sub_route_activity_id' => 'Tourism Sub Route Activity ID',
            'activity_id' => 'กิจกรรมท่องเที่ยว',
            'tourism_sub_route_activity_order' => 'ลำดับกิจกรรม',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'tourism_main_route_id' => 'เส้นทางท่องเที่ยวหลัก',
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
    public function getTourismMainRoute()
    {
        return $this->hasOne(TourismMainRoute::className(), ['tourism_main_route_id' => 'tourism_main_route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismSubRoute()
    {
        return $this->hasOne(TourismSubRoute::className(), ['tourism_sub_route_id' => 'tourism_sub_route_id']);
    }
}
