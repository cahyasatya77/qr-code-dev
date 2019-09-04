<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= $form->field($model, 'kd_dept')->widget(Select2::className(),[
        'data' => ArrayHelper::map(\backend\models\Department::find()->all(), 'kd_dept', 'nm_dept'),
        'options' => [
            'placeholder' => '- Pilih Department -'
        ],
    ]);?>
    <?= $form->field($model, 'level_access')->widget(Select2::className(),[
        'data' => [
            'user' => 'User',
            'key_user' => 'Key User',
            'administrator' => 'Administrator',
        ],
        'options' => [
            'placeholder' => '- Pilih Level Akses User -',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>
    <?= $form->field($model, 'status')->widget(Select2::className(),[
        'data' => [
            '10' => 'Aktif',
            '20' => 'Non Aktif',
        ],
        'options' => [
            'placeholder' => 'Status User'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', ['/user/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
