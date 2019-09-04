<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Kodekemas */

$data_nie = ArrayHelper::map($model_nie, 'nie', 'description');

$this->title = 'Create New 07 Mei 2019';
$this->params['breadcrumbs'][] = ['label' => 'Kodekemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-success">
<div class="kodekemas-create">
    <?php $form = ActiveForm::begin();?>
    
    <div class="box-body">
        <?= $form->field($model, 'nomor_nie')->widget(Select2::className(),[
            'data' => $data_nie,
            'options' => [
                'placeholder' => '- Pilih Produk -',
                'id' => 'nie',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])?>
        
        <?= $form->field($model, 'nomor_batch')->widget(Select2::className(),[
            'data' => ['' => ''],
            'options' => [
                'placeholder' => '- Pilih Nomor Batch -',
                'id' => 'batch',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])?>
        
        <?= $form->field($model, 'expired_date')->textInput(['maxlength' => true, 'id' => 'ed', 'readonly' => true])?>
        
        <?= $form->field($model, 'jumlah')->textInput()?>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success'])?>
            <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['createnew'], ['class' => 'btn btn-default'])?>
        </div>
    </div>
    
    <?php ActiveForm::end();?>
</div>
</div>

<?php
$script = "
    $('#nie').change(function(){
        var nie = $(this).val();
        
        $.get('batch', {nie:nie}, function(data){
            $('select#batch').html(data);
            $('select#batch').val('');
        });
    });
    $('#batch').change(function(){
        var nie = $('#nie').val();
        var batch = $(this).val();
        
        $.get('get-expired-date', {nie:nie, batch:batch}, function(data){
            var data = $.parseJSON(data);
            
            $('#ed').attr('value', data[0].EXPIRATION_DATE);
        });
    });
";
$this->registerJs($script);
?>