<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {
 
    public function actionView($id){
//        $id = Yii::$app->request->get('id');
        //Ленивая загрузка
        $product = Product::findOne($id);
        if(empty($product))
             throw new \yii\web\HttpException(404, 'Выбранной позиции не существует');
        
        //Вариант для жадной загрузки        
        //$product = Product::find()->with('category')->where(['id' => $id])->limit('1')->one();
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->layout = 'mainv'; 
        $this->setMeta('MaG Shop | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }
}
