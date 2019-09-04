<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Kodecahya */
/* @var $form yii\widget\ActiveForm */

$this->title = 'Update in Table Oracle';
$this->params['breadcrumbs'][] = ['label' => 'Table Oracle'];
?>

<div class="row">
<div class="col-md-12">
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Create</h3>
    </div>
    <?php $form = ActiveForm::begin();?>
    <div class="box-body">
        
        <?= $form->field($model, 'CAHYA_ID')->textInput();?>
        
        <?= $form->field($model, 'KODE_KARTON')->textInput();?>
        
        <?= $form->field($model, 'NIE')->textInput();?>
        
        <?= $form->field($model, 'KODE_PRODUK')->textInput();?>
        
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
</div>
</div>
