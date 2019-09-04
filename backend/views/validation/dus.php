<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * Form Validasi Qr Dus dengan menyimpan pada ModelStatis.
 * dan membandingkan dengan model KodeKemas.
 */

$this->title = 'Validation QR Code Dus';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <?php $form = ActiveForm::begin([
                'id' => 'validation-form',
//                'action' => ['kaplet'],
//                'validationUrl' => 'validation-dus',
//                'enableAjaxValidation' => true,
//                'validateOnSubmit' => true,
            ]);?>
            <div class="box-body">
                <?= $form->field($model, 'code_kemas')
                    ->textInput([
                        'maxlength' => true,
                        'id' => 'kemas'
                    ])?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save', [
                    'class' => 'btn btn-primary', 
                    'id' => 'frm-input', 
                    'style' => "display: none;"
                ]);?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<?php
$this->registerJs($this->render('notif.js'), \yii\web\View::POS_READY);
?>