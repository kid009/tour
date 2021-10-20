<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tambon".
 *
 * @property int $tambon_id
 * @property string $tambon_code
 * @property string $tamcon_name
 * @property int $amphur_id
 * @property int $province_id
 * @property int $geo_id
 */
class Tambon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_tambon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tambon_code', 'tambon_name', 'amphur_id', 'province_id', 'geo_id'], 'required'],
            [['amphur_id', 'province_id', 'geo_id'], 'default', 'value' => null],
            [['amphur_id', 'province_id', 'geo_id'], 'integer'],
            [['tambon_code'], 'string', 'max' => 6],
            [['tambon_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tambon_id' => 'Tambon ID',
            'tambon_code' => 'Tambon Code',
            'tambon_name' => 'Tamcon Name',
            'amphur_id' => 'Amphur ID',
            'province_id' => 'Province ID',
            'geo_id' => 'Geo ID',
        ];
    }
}
