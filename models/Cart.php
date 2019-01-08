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
class Cart extends \yii\db\ActiveRecord
{

	public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

	public function addToCart($product, $qty = 1){
		$mainImg = $product->getImage();
			$rightPath = explode('/', $mainImg->getUrl('x50'));
            $rightPath[3] = 'yii2images';
            $rightPath2 = implode('/', $rightPath); 
		if(isset($_SESSION['cart'][$product->id])){
			$_SESSION['cart'][$product->id]['qty'] += $qty;
		}else{
			$_SESSION['cart'][$product->id] = [
				'qty' => $qty,
				'name' => $product->name,
				'price' => $product->price,
				'img' => $rightPath2

			];
		}

		$_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
		$_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + 
		$qty * $product->price : $qty * $product->price;
	}

	public function recalc($id){
		if(!isset($_SESSION['cart'][$id])) return false;
		$qtyMinus = $_SESSION['cart'][$id]['qty'];
		$sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
		$_SESSION['cart.qty'] -= $qtyMinus;
		$_SESSION['cart.sum'] -= $sumMinus;
		unset($_SESSION['cart'][$id]);
	}

}

?>