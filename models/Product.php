<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $content
 * @property double $price
 * @property string $keywords
 * @property string $description
 * @property string $img
 * @property string $hit
 * @property string $new
 * @property string $sale
 */
class Product extends \yii\db\ActiveRecord
{

    //public $product_params;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
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
            [['category_id', 'name', 'content', 'keywords', 'description', 'img'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price'], 'number'],
            [['product_params'], 'safe'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'content' => 'Content',
            'price' => 'Price',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'img' => 'Img',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
            'product_params' => 'Color/Size',
        ];
    }

    public function getAll(){
        $query = Product::find()->all();

        return $query;
    }

    /*public function getImage()
    {
       // $er = $this->image;
       // return $er;
       //return 'uploads/no-image.png';
        return ($this->img) ? Url::to('@web/template/images/products/') . $this->img : Url::to('@web/template/images/products/no-image.png');
    }*/

    public function colorSize($includeParams)
    {
        $dirtyParams = explode(';', $includeParams);

        foreach ($dirtyParams as $key => $value) {

            //Get color
            $color = stristr($value, '(', TRUE);

            //Get size in ()
            $text = $value;
            preg_match('#\((.*?)\)#', $text, $match);
            //$size = explode(',', $match[1]);

            yii\helpers\ArrayHelper::setValue($resultArray, $match[1], $color);
            //yii\helpers\ArrayHelper::setValue($resultArray, $key.'.size', $size);
        }

        

        

        //
        //print $match[1];



        return $resultArray;
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }
}
