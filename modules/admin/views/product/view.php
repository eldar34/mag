<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php $form = ActiveForm::begin(['action'=>['delete'], 'method'=>'POST']); ?>

            <?= Html::input('hidden', 'productId', $model->id) ?>
            <?= Html::submitButton('Delete', ['class' => 'btn btn-danger']) ?>
            
        <?php ActiveForm::end(); ?>
        
    </p>

    <?php
         $img = $model->getImage(); 
         $rightPath = explode('/', $img->getUrl('268x249'));
         $rightPath[1] = 'yii2images';
         $rightPath2 = implode('/', $rightPath);
         
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
            [
                'attribute' => 'image',
                'value' => "<img src='{$rightPath2}'>",
                'format' => 'html',
            ],
            'product_params',
            'hit',
            'new',
            'sale',
        ],
    ]) ?>

</div>
