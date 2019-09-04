<?php

use yii\helpers\Url;

?>
<table class="table table-bordered" style="border: 5px solid black;">
    <tbody>
        <tr>
            <?php
            $length = strlen($produk['nama_produk']);
            if ($length < 15) :;?>
            <td class="fontHeader" colspan="4" style="text-align: center; border-bottom: 0px; padding-top: 20px;">
                <strong><?php echo $produk['nama_produk'];?></strong>
            </td>
            <?php elseif ($length > 14 && $length < 23):?>
            <td colspan="4" style="text-align: center; border-bottom: 0px; padding-top: 20px; font-size: 45px; height: 109px">
                <strong><?php echo $produk['nama_produk'];?></strong>
            </td>
            <?php else :?>
            <td colspan="4" style="text-align: center; border-bottom: 0px; padding-top: 32px; font-size: 32px; height: 109px">
                <strong> <?php echo $produk['nama_produk'];?></strong>
            </td>
            <?php endif;?>
            <td rowspan="2" style="border: 1px solid black;">
                
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-size: 8px; padding: 0px; padding-left: 20px; padding-bottom: 5px; border: 0px">
                <?php echo $produk['kd_produk'].' '.$produk['nama_produk'];?>
            </td>
        </tr>
        <tr>
            <td rowspan="3" style="width: 20%; padding-top: 10px; border: 1px solid black;" class="text-center">
                BPOM RI<br>
                <img src="<?= Url::to(['agregasiheader/qrcode2', 'id' => $karton->id])?>">
            </td>
            <td colspan="2" class="text-center" style="font-size: 14px; padding: 1px; border: 1px solid black;">
                Isi : <?php echo $data_dus.' '.$produk['kemasan'];?>
            </td>
            <td style="font-size: 12px; width: 18%; padding: 1px; padding-left: 5px; border: 1px solid black;">
                No. Karton : 
            </td>
            <td style="width: 20%; font-size: 12px; padding: 1px; padding-left: 5px; border: 1px solid black;">
                Berat: 
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center" style="font-size: 8px; padding: 1px; border: 1px solid black;">
                <b>PERHATIAN :</b><br>
                HARAP DITIMBANG TERLEBIH DAHULU<br>
                JIKA TERDAPAT PERBEDAAAN YANG SIGNIFIKAN, SEGERA<br>
                INFORMASI KEPADA KAMI<br>
                PENGADUAN DITERIMA JIKA KARTON BELUM DIBUKA<br>
            </td>
            <td colspan="2" style="font-size: 24px; padding-top: 12px; padding-left: 5px; border: 1px solid black;">
                No. Batch : <?php echo $karton->no_batch;?>
            </td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 12px; padding: 1px; padding-left: 5px; padding-right: 5px; border: 1px solid black;">
                <b>
                    SIMPAN PADA SUHU DI BAWAH <?php echo $suhu['DERAJAT'];?>&deg;C DAN HINDARKAN DARI CAHAYA MATAHARI.
                </b>
            </td>
            <td class="text-center" style="width: 10%; font-size: 24px; border: 1px solid black;">
                <strong><?php echo $suhu['ANGKA_RELEASE'];?></strong>
            </td>
            <td colspan="2" style="font-size: 24px; padding-top: 10px; padding-left: 5px; border: 1px solid black;">
                <?php
                // $time = strtotime($karton->expired_date);
                // $date = date('m Y', $time);
                
                $date = $karton->expired_date;
                $day = substr($date, 4,2);
                $month = substr($date, 2, 2);
                $year = substr($date, 0, 2);

                $newDate = $month.' 20'.$year;
                ?>
                Exp. Date : <?php echo $newDate;?>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="3" style="border-bottom: 10px solid black; padding: 2px; border-top: 1px solid black; border-right: 1px solid black;">
                <img src="images/ifars.jpg" width="30" />
                <strong>
                     PT IFARS PHARMACEUTICAL LABORATORIES
                </strong>
            </td>
            <td style="border-bottom: 10px solid black; padding: 1px; text-align: center; font-size: 10px; border-right: 1px solid black;">
                Diperiksa oleh<br>
                .....................
            </td>
            <td style="border-bottom: 10px solid black; padding: 1px; text-align: center; font-size: 10px; border-right: 1px solid black;">
                Tanggal<br>
                .....................
            </td>
        </tr>
    </tbody>
</table>