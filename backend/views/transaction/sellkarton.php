<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Jual Karton';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="ion ion-ios-cart-outline"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Karton terjual tanggal <br/> <strong><?= date("d F Y")?></strong></span>
                <span class="info-box-number"><?= $count_sold?></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary transaction-index">
            <?php $form = ActiveForm::begin();?>
            <div class="box-body">
                <?= $form->field($model, 'code_karton')->textInput(['maxlength' => true, 'id' => 'karton']);?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Jual', ['class' => 'btn btn-primary' ,'id' => 'frm-input', 'style' => "display: none;"])?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $('#karton').val('');
    $('#karton').focus();
    $('#karton').keypress(function(e){
        var key = e.which || e.ctrlKey;
        if (key == 13) {
            $('#frm-input').click();
        }
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>