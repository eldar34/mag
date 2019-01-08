<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order1 */

$this->title = 'Create Order1';
$this->params['breadcrumbs'][] = ['label' => 'Order1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
