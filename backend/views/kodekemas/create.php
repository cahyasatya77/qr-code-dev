<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Kodekemas */

$this->title = 'Create Kodekemas';
$this->params['breadcrumbs'][] = ['label' => 'Kodekemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">
<div class="kodekemas-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_nie' => $model_nie,
    ]) ?>

</div>
</div>
