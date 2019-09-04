<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
     
    /* @var $this yii\web\View */
    /* @var $model frontend\models\ChangePasswordForm */
    /* @var $form ActiveForm */
     
$this->title = 'Change Password';
?>
<div class="col-lg-6">
<div class="box box-primary">
    <?php $form = ActiveForm::begin([
        'id'=>'change-password',
        'type'=> ActiveForm::TYPE_VERTICAL
    ]); ?>
        <div class="col-lg-12">
        <?= $form->field($model, 'password',
                ['options'=>[
                    'class'=>'form-group']])
            ->passwordInput() ?>
            
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        </div>
        <div class="form-group">
        <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class'=>'btn btn-default'])?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
</div>