<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Solds';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-6">
<div class="box box-primary sold-index">
    <div class="box-header">
        <h3>Karton</h3>
    </div>
    <?php $form = ActiveForm::begin();?>
    <div class="box-body">
        
        <?= $form->field($model, 'sell')->textInput(['maxlength' => true, 'value' => '1', 'readOnly' => true]);?>
        
    </div>
    <div class="box-footer form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit', 'onClick' => 'myFunction()'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
</div>