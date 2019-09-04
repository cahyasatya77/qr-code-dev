<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Input Code Kemasan';
$this->params['breadcrumbs'][] = ['label' => 'Agregasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(['id' => 'alert']);?>
<?php if ($flash == 'gagal'):?>
<div class="alert alert-danger alert-dismissable">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-ban"></i>
    Maaf data yang dimasukan sudah ada, Silahkan cek kembali.
</div>
<?php endif;?>
<?php if ($karton_max == 'overcapasity'):?>
<div class="alert alert-warning alert-dismissable">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fa fa-warning"></i>
    Data yang diinput melebihi kapasitas karton.
</div>
<?php endif;?>
<div class="progress active">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" 
         style="width: <?php echo $total.'%';?>">
        <span class="sr-only">Data <?php echo $total_input;?> Complate</span>
    </div>
</div>
<?php Pjax::end();?>

<div class="box box-info">
    <div class="box-header"> 
        <div class="col-md-12 text-right">
            <?= Html::a('Label Karton', ['cetak-karton', 'id' => $model_agregasi->id], ['class' => 'btn btn-success', 'target' => '_blank'])?>
            <?php // echo Html::a('Label QR Karton', ['cetak-label', 'id' => $model_agregasi->id], ['class' => 'btn btn-warning', 'target' => '_blank']);?>
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
    <!--<? php Pjax::begin();?>-->
    <?php $form = ActiveForm::begin([
        'id' => 'form-kemas',
        'layout' => 'horizontal',
        //'options' => ['data-pjax' => true]
    ]);?>
    <div class="box-body">
        <?= $form->field($model, 'kode_kemas')->textInput(['maxlength' => true, 'id' => 'kemas'])?>
        
        <div class="form-group text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'frm-input', 'style' => "display: none"])?>
        </div>
    </div>
    <div class="box-footer text-right">
        <?= Html::a('Selesai', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('View Detail', ['data-line'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php ActiveForm::end();?>
    <!--<? php Pjax::end();?>-->
</div>
<div class="box box-success">
    <div class="box-body">
        <div class="table table-responsive">
            <?php Pjax::begin(['id' => 'hasil']);?>
            <?= GridView::widget([
                'dataProvider' => $dataLine,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'kode_kemas',

                    [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{myButton}',
                        'buttons' => [
                            'myButton' => function($url) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete ?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'myButton') {
                                $url = Url::to(['agregasiheader/deletedetail', 'id' => $model->id_agregasi, 'del' => $model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ])?>
            <?php Pjax::end();?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $('#kemas').val('');
    $('#kemas').focus();
    $('#kemas').keypress(function(e){
        var key = e.which || e.ctrlKey;
        if(key == 13) {
            $('#frm-input').click();
        }
    });
        
    $.pjax.reload({container: '#alert'}).done(function () {
        $.pjax.reload({container: '#hasil'});
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>

<script src="js/print.js"></script>