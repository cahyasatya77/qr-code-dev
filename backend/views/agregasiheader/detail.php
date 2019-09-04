<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Input Code Kemasan';
$this->params['breadcrumbs'][] = ['label' => 'Agregasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin([
    'id' => 'progress-bar'
]);?>
<div>
    <h4>Data Dus Berhasil disimpan : <?php echo $total_input.'/'.$max;?></h4>
</div>

<?= Html::a('Progress', ['agregasiheader/create-detail', 'id' => $id], [
    'class' => 'btn btn-default',
    'id' => 'btn-progress',
    'style' => 'display: none;',
]);?>
<div class="progress active">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" 
         style="width: <?php echo $total.'%';?>">
        <span class="sr-only">Data <?php echo $total_input;?> Complate</span>
    </div>
</div>
<?php Pjax::end();?>


<div class="box box-info">
    <div class="box-header">
        <div class="row">
        <div class="col-md-6">
            <?= Html::a('Custom Label', ['custom-label', 'id' => $model_agregasi->id], ['class' => 'btn btn-danger', 'target' => '_blank'])?>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('<span class="fa fa-repeat"></span> Refresh', ['create-detail', 'id' => $model_agregasi->id], ['class' => 'btn btn-default'])?>
            <?= Html::a('Label Karton', ['cetak-karton', 'id' => $model_agregasi->id], ['class' => 'btn btn-success', 'target' => '_blank'])?>
            <?php // echo Html::a('Label QR Karton', ['cetak-label', 'id' => $model_agregasi->id], ['class' => 'btn btn-warning', 'target' => '_blank']);?>
        </div>
        </div>
    </div>
    <div class="box-body">
        <div class="table table-responsive">
            <?= DetailView::widget([
                'model' => $model_agregasi,
                'attributes' => [
                    [
                        'label' => 'Kode Karton',
                        'value' => $model_agregasi->kode_karton.$model_agregasi->rand_char
                    ],
                    [
                        'label' => 'Nama Produk',
                        'value' => $model_agregasi->produk->nama_produk,
                    ],
                    'no_nie',
                    'no_batch'
                ],
            ])?>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'id' => 'detail-form',
            'action' => ['create-detail', 'id' => $id],
            'validationUrl' => 'validation-detail',
            'enableAjaxValidation' => true,
            'validateOnSubmit' => true,
        ]);?>
        <div class="col-md-12">
            <div class="col-md-2 text-right">
                <label>Kode Dus</label>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'kode_kemas')
                    ->textInput(['id' => 'kode_kemas'])
                    ->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Save', [
                'class' => 'btn btn-success',
                'id' => 'frm-input',
                'style' => 'display: none;'
            ]);?>
        </div>
        <?php ActiveForm::end();?>
    </div>
</div>


<div class="box box-default">
    <div class="box-body">
        <div class="col-md-3 text-right">
            <label>Kode Input</label> :
        </div>
        <div class="col-md-6 text-center">
            <div id="notifikasi"></div>
        </div>
        <div class="col-md-3 text-right">
            <?= Html::a('Selesai', ['index'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('View Detail', ['viewdetail', 'id' => $model_agregasi->id], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
</div>

<?php
$this->registerJs($this->render('notif.js'), \yii\web\View::POS_READY);
?>