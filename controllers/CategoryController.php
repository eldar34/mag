<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController{
    
    public function actionIndex() {
        
        $query = Product::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 6]);
        $hits = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        //$hits = Product::find()->where(['hit' => '1'])->limit(7)->all();
        
        $this->setMeta('MaG Shop');
        
        return $this->render('index', compact('hits', 'pages'));
    }
    
    public function actionView($id) {
//        $id = Yii::$app->request->get('id');
        
        $category = Category::findOne($id);
        if(empty($category))
             throw new \yii\web\HttpException(404, 'Выбранной категории не существует');
        
        
//        $products = Product::find()->where(['category_id' => $id])->all();
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(),
                                 'pageSize' => 3,
                                 'forcePageParam' => FALSE,
                                 'pageSizeParam' => FALSE]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        //$this->layout = 'mainv'; 
        $this->setMeta('MaG Shop | ' . $category->name, $category->keywords, $category->description);       
        return $this->render('view', compact('products', 'pages', 'category'));
    }
    
    public function actionSearch(){
        
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('MaG Shop | Поиск:' . $q);
        if(!$q)
            return $this->render('search');
        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(),
                                 'pageSize' => 3,
                                 'forcePageParam' => FALSE,
                                 'pageSizeParam' => FALSE]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        //$this->layout = 'mains';
        return $this->render('search', compact('products', 'pages', 'q'));
    }
}
