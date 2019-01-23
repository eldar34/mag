<?php

namespace app\models;
use yii\db\ActiveRecord;
use Yii;

class Order1Items extends ActiveRecord {
    
    public static function tableName() {
        return 'order1_items';
    }

    public function getOrder() {
        return $this->hasOne(Order1::className(), ['id' => 'order_id']);
    }
    
    public function rules() {
        return [
            [['order_id', 'product_id', 'name', 'price', 'qty_item', 'sum_item'], 'required'],
            [['order_id', 'product_id', 'qty_item'], 'integer'],
            [['price', 'sum_item'], 'number'],
            [['name', 'color', 'size'], 'string', 'max' => 255],
        ];
    }
}
