<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/12/2016
 * Time: 10:26
 */
?>
<html>
<head>
    <title>Print Arus Kas | Sewa Baju</title>
    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/pinky/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.print()">
<div class="container">
    <div class="row">
        <div class="text-center">
            <img width="20%" src="<?=base_url('uploads/logo/'.$company->logo)?>" class="img-rounded">
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Piutang</th>
            </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($deal as $row):?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$row['invoice']?></td>
                    <td><?=$row['tanggal']?></td>
                    <td><?=$row['keterangan']?></td>
                    <td class="text-right"><?=$row['debit']?></td>
                    <td class="text-right"><?=$row['kredit']?></td>
                    <td class="text-right"><?=$row['piutang']?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th class="text-right" colspan="6">Total Debit</th>
                <td>Rp. <?=$total_debit?></td>
            </tr>
            <tr>
                <th class="text-right" colspan="6">Total Kredit</th>
                <td>Rp. <?=$total_kredit?></td>
            </tr>
            <tr>
                <th class="text-right" colspan="6">Total Piutang</th>
                <td>Rp. <?=$total_piutang?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
