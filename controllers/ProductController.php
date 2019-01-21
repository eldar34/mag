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

    public function actionSizepi()
    {

        $data = "ttt";
        if(Yii::$app->request->isAjax){
            $dirtySizes = Yii::$app->request->post('id');
            $sizes = explode(',', $dirtySizes);

            //$data = $id;
            $myProducts = "<option value='0'>" . "Select size" . "</option>";;
            //$this->option = "<option value='0'>" . AirlinesModule::t('module', 'AIRLINES_PROMPT_FORM') . "</option>";

            /*$products = \app\models\Product::find()

                ->Where('referenceId=:id',[':id' => $id])
                ->orderBy('referenceId')
                ->all();*/
            foreach ($sizes as $size){
                $myProducts .= '<option value="' . $size . '">' . $size . '</option>';
            }



            $data = $myProducts;

        }
        //return $this->option;
        return $data;
        
                
        /*if (!empty($posts)) {
            foreach($posts as $post) {
                echo "<option value='".$post->id."'>".$post->title."</option>";
            }
        } else {
            echo "<option>-</option>";
        }*/
        
    }
}
