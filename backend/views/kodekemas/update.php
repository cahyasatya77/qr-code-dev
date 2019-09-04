<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Kodekemas */

$this->title = 'Update Kodekemas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kodekemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kodekemas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
