<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-md-6">
<div class="search-form">
    
    <?php $form = ActiveForm::begin([
        'action' => ['kemas'],
        'method' => 'get',
    ]);?>
    
    <?= $form->field($model, 'id_kemas')?>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
    </div>
    
    <?php ActiveForm::end();?>
    
</div>
</div>

