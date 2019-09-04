<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Remove Karton';
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
                'action' => ['remove'],
                'method' => 'get',
            ]);?>
            
            <div class="box-body">
                <?= $form->field($searchModel, 'kode_karton')->textInput(['id' => 'karton'])?>
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
            <h4>Kode QR karton</h4>
        </div>
        <div class="box-body">
            <div class="table table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        
                        [
                            'header' => 'Kode Karton',
                            'value' => function($data) {
                                return $data->kode_karton.$data->rand_char;
                            }
                        ],
                        [
                            'header' => 'Nama Produk',
                            'value' => function($data) {
                                return $data->produk->nama_produk;
                            }
                        ],
                        [
                            'header' => 'No Batch',
                            'value' => 'no_batch'
                        ],
                        [
                            'header' => 'Expired Date',
                            'value' => function($data) {
                                $data = Yii::$app->runAction('agregasiheader/ed',['id' => $data->expired_date]);
                                return $data;
                            }
                        ],
                                
                        [
                            'header' => 'Remove',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function($url) {
                                    return Html::a('hapus', $url, [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Apakah anda ingin menghapus item ini?'),
                                        'data-method' => 'post', 'data-pjax' => '0',
                                        'class' => 'btn btn-danger btn-xs'
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]);?>
            </div>
        </div>
    </div>
</div>
</div>

<?php
$js = <<<JS
    $('#karton').val('');
    $('#karton').focus();
    $('#karton').keypress(function(e){
        var key = e.which || e.ctrlKey;
        if (key == 13) {
            $('#frm-input').click();
        }
    });
JS;
$this->registerJs($js, yii\web\View::POS_READY);
?>