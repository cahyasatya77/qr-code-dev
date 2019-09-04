<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Remove Dus dalam Karton';
$this->params['breadcrumbs'][] = ['label' => 'Remove Dus', 'url' => ['remove-dus']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-12">
    <div class="alert alert-warning alert-dismissible">
        <h4>
            <i class="icon fa fa-warning"></i>
            Peringatan !
        </h4>
        Peringatan pada halaman ini anda akan menghapus data secara permanen.
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <?php $form = ActiveForm::begin([
                'action' => ['remove-dus'],
                'method' => 'get',
            ]);?>
            <div class="box-body">
                <?= $form->field($searchModel, 'kode_kemas')->textInput(['id' => 'kemas'])?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-default', 'id' => 'frm-input', 'style' => 'display: none;'])?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
    <div class="box box-danger">
        <div class="box-header">
            <h4>Kode QR dus</h4>
        </div>
        <div class="box-body">
            <div class="table table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'header' => 'Kode Dus',
                        'attribute' => 'kode_kemas',
                        'value' => 'kode_kemas'
                    ],
                    [
                        'header' => 'Nama Produk',
                        'value' => function ($data) {
                            return $data->agregasi->produk->nama_produk;
                        }
                    ],
                    [
                        'header' => 'No Batch',
                        'value' => function($data) {
                            return $data->agregasi->no_batch;
                        }
                    ],
                    [
                        'header' => 'Remove',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{myButton}',
                        'buttons' => [
                            'myButton' => function($url) {
                                return Html::a('hapus', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Apakah kamu yakin untuk menghapus data ini ?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                    'class' => 'btn btn-danger btn-xs',
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model){
                            if ($action === 'myButton') {
                                $url = Url::to(['sample/deleteline', 'id' => $model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]);?>
            </div>
    </div>
    </div>
</div>
</div>

<?php
$script = <<<JS
    $('#kemas').val('');
    $('#kemas').focus();
    $('#kemas').keypress(function(e){
        var key = e.which || e.ctrlKey;
        if (key == 13) {
            $('#frm-input').click();
        }
    });
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>