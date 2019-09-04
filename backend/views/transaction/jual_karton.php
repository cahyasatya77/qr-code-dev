<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dataKarton = ArrayHelper::map($karton, 'id', 'kode_karton');

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-8">
<div class="box box-primary">
    <div class="box-header">
        <h4>Jual Karton</h4>
    </div>
    <?php $form = ActiveForm::begin();?>
    
    <div class="box-body">
        <?= $form->field($model, 'code_karton')->widget(Select2::className(),[
            'data' => $dataKarton,
            'options' => [
                'placeholder' => '- Scan Your QR Code Karton -',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])?>
    </div>
    <div class="box-footer text-right">
        <?= Html::submitButton('Jual', ['class' => 'btn btn-success'])?>
    </div>
    
    <?php ActiveForm::end();?>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="box box-success">
    <div class="box-header">
        <h4>List Karton terjual</h4>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $soldKarton,
            'filterModel' => $searchKarton,
            'summary' => false,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                
                [
                    'attribute' => 'nama_produk',
                    'value' => 'produk.nama_produk'
                ],
                'kode_karton',
                
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ])?>
    </div>
</div>
</div>
</div>