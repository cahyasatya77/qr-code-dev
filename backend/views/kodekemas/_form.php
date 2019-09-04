<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Kodekemas */
/* @var $form yii\widgets\ActiveForm */
$data_nie = ArrayHelper::map($model_nie, 'nie', 'description');
?>

<div class="kodekemas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'nomor_nie')->widget(Select2::className(),[
            'data' => $data_nie,
            'options' => [
                'placeholder' => '- Pilih NIE -',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
        
        <?= $form->field($model, 'jumlah')->textInput()?>
    </div>

    <div class="box-footer">
    <div class="form-group">
        <?= Html::submitButton('Save', [
            'class' => 'btn btn-success'
        ]) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>