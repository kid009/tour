<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "amphur".
 *
 * @property int $amphur_id
 * @property string $amphur_code
 * @property string $amphur_name
 * @property string $province_id
 * @property string $geo_id
 */
class Amphur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_amphur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amphur_code', 'amphur_name'], 'required'],
            [['province_id', 'geo_id'], 'default', 'value' => null],
            [['province_id', 'geo_id'], 'integer'],
            [['amphur_code'], 'string', 'max' => 4],
            [['amphur_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'amphur_id' => 'Amphur ID',
            'amphur_code' => 'Amphur Code',
            'amphur_name' => 'Amphur Name',
            'province_id' => 'Province ID',
            'geo_id' => 'Geo ID',
        ];
    }
}
