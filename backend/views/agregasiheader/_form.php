<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Agregasiheader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agregasiheader-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header">
        <?= $form->field($model, 'kode_karton')->textInput(['maxlength' => true, 'id' => 'karton', 'autofocus' => true])->label('QR Dus') ?>

        <?= $form->field($model, 'no_nie')->textInput(['maxlength' => true, 'id' => 'nie', 'readonly' => true]) ?>
        
        <?= $form->field($model, 'no_batch')->textInput(['maxlength' => true, 'id' => 'batch', 'readonly' => true])?>

        <?= $form->field($model, 'expired_date')->textInput(['maxlength' => true, 'id' => 'ed', 'readonly' => true]) ?>
        
        <?= $form->field($model, 'isi')->textInput(['maxlength' => true, 'id' => 'isi', 'readonly' => true])?>
    </div>

    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = "
    $('#karton').change(function(){
        var kode = $(this).val();
        
        $.get('get-nie', {kode:kode}, function(data){
            var data = $.parseJSON(data);
            
            $('#nie').attr('value', data.nie);
            $('#batch').attr('value', data.batch);
            $('#ed').attr('value', data.ed);
            
            var nie = data.nie;
            
            $.get('get-isi', {nie:nie}, function(data){
                var data = $.parseJSON(data);
                
                $('#isi').attr('value', data[0].CONVERSION_RATE + ' ' + data[0].PRIMARY_UNIT_OF_MEASURE + ' @ ' + data[0].KEMASAN)
            });
        });
    });
";
$this->registerJs($script);
?>