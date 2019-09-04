<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">
    
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
    <?= $form->field($model, 'kd_dept')->textInput(['maxlength' => true ,'value'=>$model->generateKd_dept()]) ?>

    <?= $form->field($model, 'nm_dept')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

