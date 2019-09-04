<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * Form Validation QR Karton dengan menyimpan data pada ModelStatis.
 * dan membandingkna dengan model Agregasiheader.
 */

$this->title = 'Validation QR Code Karton';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <?php $form = ActiveForm::begin();?>
            <div class="box-body">
                <?= $form->field($model, 'code_karton')
                    ->textInput(['maxlength' => true, 'id' => 'karton']);?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Search', ['id' => 'frm-input', 'style' => 'display: none;']);?>
            </div>
            <?php ActiveForm::end();?>
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
$this->registerJs($js, \yii\web\View::POS_READY);
?>
