<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dataKemasan = ArrayHelper::map($kemasan, 'id', 'kode_kemas');
?>

<div class="row">
<div class="col-md-12">
<!--<div class="box box-primary">-->
    <label>
        <h4>Sample Dus</h4>
    </label>
    <?php $form = ActiveForm::begin();?>
    <!--<div class="box-body">-->
        <?= $form->field($model, 'code_kemas')->widget(Select2::className(),[
            'data' => $dataKemasan,
            'options' => [
                'placeholder' => '- Scan Your QR Code kemasan dus -',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])?>
    <!--</div>-->
    <!--<div class="box-footer text-right">-->
        <?= Html::submitButton('<span class="fa fa-send"></span> Sample', ['class' => 'btn btn-success'])?>
    <!--</div>-->
    <?php ActiveForm::end();?>
<!--</div>-->
</div>
</div>
