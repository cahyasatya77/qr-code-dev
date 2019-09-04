<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\KemasSearch */
/* @var $form yii\widgets\ActiveForm */

if ($model->is_sample == 'TRUE'){
    $model->is_sample = true;
}

$this->title = 'Kemas';
$this->params['breadcrumbs'][] = $this->title;

kartik\switchinput\SwitchInputAsset::register($this);
?>

<div class="row">
<div class="col-md-12">
<div class="box box-success">
<div class="kemas-search">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="col-md-4">
        <?= $form->field($model, 'is_sample')->widget(SwitchInput::className(),[
            'pluginOptions' => [
                'onText' => 'Yes',
                'offText' => 'No',
            ],
        ]);?>
        </div>
    </div>
    <div class="box-footer">
    <div class="form-group text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>