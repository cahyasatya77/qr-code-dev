<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\jui\JuiAsset;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
/* @var $modelsAddress app\modules\yii2extensions\models\Address */

$this->title = 'Sample Dus';
$this->params['breadcrumbs'][] = $this->title;

$data_produk = ArrayHelper::map($model_produk, 'kd_produk', 'nama_produk');
?>

<div class="row">
<div class="col-md-12">
<div class="box box-default">
<div class="sample-form">
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'id' => 'dynamic-form'
        ]);?>
        <div class="row">
        <div class="col-md-6">
            <?= $form->field($model_statis, 'kd_produk')->widget(Select2::className(),[
                'data' => $data_produk,
                'options' => [
                    'placeholder' => '- Pilih Nama Produk Sample -',
                    'id' => 'testCode',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])?>
            
            <?= $form->field($model_statis, 'no_batch', [
                'inputOptions' => [
                    'placeholder' => 'Isikan Nomor Batch',
                    'id' => 'batch',
                ],
            ])->textInput(['maxlength' => true])?>
            
            <?= $form->field($model_statis, 'no_nie', [
                'inputOptions' => [
                    'placeholder' => 'Isikan Nomor NIE',
                ],
            ])->textInput(['maxlength' => true])?>
            
        </div>
        <div class="col-md-6">
            
            <?= $form->field($model_statis, 'kemasan', [
                'inputOptions' => [
                    'placeholder' => 'Isikan Jenis Kemasan'
                ],
            ])->textInput(['maxlength' => true])?>
            
            <?= $form->field($model_statis, 'tanggal_ed', [
                'inputOptions' => [
                    'placeholder' => 'Isikan Tanggal ED'
                ],
            ])->widget(DatePicker::className(),[
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ],
            ]);?>
            
            <?= $form->field($model_statis, 'deskripsi', [
                'inputOptions' => [
                    'placeholder' => 'Isikan Deskripsi Produk',
                ],
            ])->textarea()?>
            
            <?= $form->field($model_statis, 'nama_produk')->hiddenInput()->label(false)?>
        </div>
        </div>
        
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-qrcode"></i> Input Code Kemas</h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-items',
                    'widgetItem' => '.item',
                    'min' => 1,
                    'insertButton' => '.add-item',
                    'deleteButton' => '.remove-item',
                    'model' => $model[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'id_kemas'
                    ],
                ]);?>
                
                <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($model as $i => $kemas): ?>
                    <div class="item "><!-- widgetBody -->
                        <div class="row">
                            <?php
                                // necessary for update action.
                                if (! $kemas->isNewRecord) {
                                    echo Html::activeHiddenInput($kemas, "[{$i}]id");
                                }
                            ?>
                                <div class="col-sm-11">
                                    <?= $form->field($kemas, "[{$i}]id_kemas")->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                                <div class="col-sm-1 text-center">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
            
            <div class="box-footer form-group text-center">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        
        <?php ActiveForm::end();?>
    </div>
</div>
</div>
</div>
</div>
    
    
<?php 
$script = "
$('#testCode').change(function(){
    var zipId = $(this).val();
        
    $.get('".Yii::$app->urlManager->baseUrl."/karton/get-city-province',{ zipId : zipId }, function(data){
        var data = $.parseJSON(data);
        //alert(data[0].kemasan);
        $('#sample-kemasan').attr('value',data[0].kemasan);
        $('#sample-no_nie').attr('value',data[0].nomor_nie);
        $('#sample-deskripsi').val(data[0].deskripsi);
        $('#sample-nama_produk').attr('value',data[0].nama_produk);
    });
    
    $.post('".Yii::$app->urlManager->baseUrl."/karton/batch',{ zipId : zipId }, function(data){
        //var data = $.parseJSON(data);
        //alert(data[0].kemasan);
        $( 'select#batch' ).html( data );
        $( 'select#batch' ).val('');
    });
});
        
$('#batch').change(function(){
    var noBatch = $(this).val();
    var kdProduk = $('#testCode').val();
    
    $.get('".Yii::$app->urlManager->baseUrl."/karton/expired', { noBatch : noBatch, kdProduk : kdProduk }, function(data){
        var data = $.parseJSON(data);

        $('#sample-tanggal_ed').attr('value',data[0].EXPIRATION_DATE);
    })
});

";
$this->registerJs($script);
?>
