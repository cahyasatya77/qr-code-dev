<?php foreach ($model as $data):?>
<?php
    $data = nl2br($data['kode']."\r\n");
    echo str_replace("<br />", "", $data);
?>
<?php endforeach;?>
$$