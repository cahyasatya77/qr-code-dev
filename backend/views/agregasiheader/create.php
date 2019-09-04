<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Agregasiheader */

$this->title = 'Create Agregasi';
$this->params['breadcrumbs'][] = ['label' => 'Agregasiheaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
<div class="agregasiheader-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
