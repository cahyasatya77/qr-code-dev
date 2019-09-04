<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\KodekemasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kodekemas-search">
    <div class="box box-primary">
        <?php $form = ActiveForm::begin([
            'action' => ['penerbitan'],
            'method' => 'get',
        ]);?>
    
        <div class="box-body">
            <div class="col-md-6">
                <?= $form->field($model, 'no_nie') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'no_batch')?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'discharge_date', [
                    'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                    'options' => ['class' => 'drp-container form-group']
                ])->widget(DateRangePicker::classname(),[
                    'useWithAddon'=>true
                ])->label('Date Range Agregasi')?>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        
        <?php ActiveForm::end();?>
    </div>
</div>