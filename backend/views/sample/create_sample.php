<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Sample */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Sample Dus';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="ion ion-social-buffer-outline"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">
                    Sample Dus tanggal <br/>
                    <strong><?php echo date("d F Y");?></strong>
                </span>
                <span class="info-box-number"><?= $count_sample?></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="box box-warning">
    <?php $form = ActiveForm::begin();?>
    <div class="box-body">
        <?= $form->field($model, 'id_kemas')->textInput(['maxlength' => true, 'id' => 'kemas'])->label('Scan Kode QR Dus')?>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'frm-submit', 'style' => 'display: none;']);?>
        </div>
    </div>
    <?php ActiveForm::end();?>
</div>
</div>
</div>

<?php
$js = <<<JS
    $('#kemas').val('');
    $('#kemas').focus();
    $('#kemas').keypress(function(e){
        var key = e.which || e.ctrlKey;
        if (key == 13) {
            $('#frm-input').click();
        }
    });
JS;
$this->registerJs($js, yii\web\View::POS_READY);
?>