<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order1_items".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $name
 * @property double $price
 * @property int $qty_item
 * @property int $sum_item
 */
class Order1Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order1_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'name', 'price', 'qty_item', 'sum_item'], 'required'],
            [['id', 'order_id', 'product_id', 'qty_item', 'sum_item'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'price' => 'Price',
            'qty_item' => 'Qty Item',
            'sum_item' => 'Sum Item',
        ];
    }

    public function getOrder1()
    {
        return $this->hasOne(Order1::className(), ['id' => 'order_id']);
    }
}
