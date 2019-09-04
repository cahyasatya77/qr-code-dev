<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Agregasiheader */

?>

<table>
    <tr>
        <td><img src="<?= Url::to(['agregasiheader/qrcode', 'id' => $model->id])?>"></td>
    </tr>
</table>