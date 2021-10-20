<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $product_group_id
 * @property int $product_id
 * @property string $product_name
 * @property string $product_detail
 * @property string $product_image_cover
 * @property int $product_price
 * @property int $product_stock_total
 * @property string $product_code
 * @property string $product_unit
 * @property string $special_group_id
 * @property string $community_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property ProductGroup $productGroup
 * @property SpecialGroup $specialGroup
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_group_id', 'product_price', 'product_stock_total', 'special_group_id', 'community_id', 'knowhow_id'], 'default', 'value' => null],
            [['product_group_id', 'product_price', 'product_stock_total', 'special_group_id', 'community_id', 'knowhow_id'], 'integer'],
            [['product_detail', 'product_info', 'product_detail_en', 'product_promotion'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['product_name', 'product_code', 'product_unit', 'create_by', 'update_by', 'product_contact_name', 'product_line', 'product_facebook', 'product_name_en', 'product_link', 'product_vdo'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['product_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductGroup::className(), 'targetAttribute' => ['product_group_id' => 'product_group_id']],
            [['special_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialGroup::className(), 'targetAttribute' => ['special_group_id' => 'special_group_id']],
            [['product_group_id', 'special_group_id', 'community_id', 'product_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['product_price', 'product_stock_total', 'product_telephone'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข'],
            [
                ['product_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['product_image_contact',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_group_id' => 'กลุ่มสินค้า',
            'product_id' => 'Product ID',
            'product_name' => 'ชื่อสินค้า',
            'product_detail' => 'Product Detail',
            'product_image_cover' => 'Product Image Cover',
            'product_price' => 'ราคาสินค้า',
            'product_stock_total' => 'จำนวนคงเหลือ',
            'product_code' => 'รหัสสินค้า',
            'product_unit' => 'หน่วยสินค้า',
            'special_group_id' => 'กลุ่มอาชีพ',
            'community_id' => 'ชุมชน',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'product_contact_name' => 'ชื่อผู้ติดต่อ',
            'product_line' => 'Line',
            'product_facebook' => 'Facebook',
            'product_telephone' => 'เบอร์โทรศัพท์'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductGroup()
    {
        return $this->hasOne(ProductGroup::className(), ['product_group_id' => 'product_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialGroup()
    {
        return $this->hasOne(SpecialGroup::className(), ['special_group_id' => 'special_group_id']);
    }

    public function getBeststudys()
    {
        return $this->hasMany(Beststudy::className(), ['product_id' => 'product_id']);
    }
}
