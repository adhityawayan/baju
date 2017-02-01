<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 21/11/2016
 * Time: 13:30
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="row hidden-print all-button pull-right">

                <div class="col-xs-12">

                    <button type="button" class="btn red hidden-print uppercase print-btn" onclick="loadOtherPage()">

                        <i class="fa fa-print"></i> Print

                    </button>

                    <a href="<?=base_url('bisnis/appointment/add')?>" class="btn blue hidden-print uppercase print-btn">

                        <i class="fa fa-plus"></i> Baru

                    </a>

                    <a href="<?=base_url('bisnis/appointment')?>" class="btn green hidden-print uppercase print-btn">

                        <i class="fa fa-bars"></i> List

                    </a>

                </div>

            </div>
        </div>
        <div class="text-center">
            <img width="20%" src="<?=base_url('uploads/logo/'.$company->logo)?>" class="img-rounded">
        </div>
        <div class="col-xs-6">
            <div class="text-left">
                <p>NAME : <?=$deal?$deal->mcustomer->name:''?></p>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="text-right">
                <p>HP : <?=$deal?$deal->mcustomer->phone:''?></p>
            </div>
        </div>
        <div class="col-xs-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="col-xs-6 text-center">GOWN</th>
                    <th class="col-xs-6 text-center">ACCESSORIES</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <ol>
                            <?php foreach($tritem as $row): ?>
                                <li><input type="checkbox" <?=$row->rent_status==1?'checked':''?> disabled> <?=$row->mbaju->name?></li>
                            <?php endforeach; ?>
                            <?php foreach($dpromo as $row):
                                foreach($row->trpromo as $trp):
                                    ?>
                                    <li><input type="checkbox" <?=$trp->rent_status==1?'checked':''?> disabled> <?=$trp->mbaju?$trp->mbaju->name:'- Belum Dipilih -'?></li>
                                <?php endforeach;
                            endforeach; ?>
                            <?php foreach($trmade as $row): ?>
                                <li><?=$row->disc?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol>
                            <?php foreach($traccessories as $row): ?>
                                <li><?=$row->maccessories->name?></li>
                            <?php endforeach; ?>
                            <?php foreach($trjobs as $row): ?>
                                <li><?=$row->job?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12">
            <div class="text-left">
                <p><?=$appointment->title?> : <?=$appointment->date_delivery?tgl_indo($appointment->date_delivery):''?></p>
            </div>
        </div>
        <div class="col-xs-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="col-xs-6 text-center">PIC</th>
                    <th class="col-xs-6 text-center">CLIENT</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><div style="height: 100px;"></div></td>
                    <td>
                        <div style="padding-top: 70px;">
                            <img src="<?=$appointment->ttd_pickup?>" class="img-responsive" alt="">
                            <p style="font-size: 20px; margin-top: -20px;" class="text-center"><?=$appointment->receiver_pickup?></p>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12">
            <div class="text-center">
                <p>Mohon untuk memeriksa KONDISI DAN kelengkapan barang. Term and condition applied</p>
            </div>
        </div>
    </div>
</div>
<?php
$ids = $deal?$deal->appointment_id:0;
?>
<input type="hidden" id="urlcetakdelivery" value="<?=base_url('bisnis/appointment/delivery_print/'.$ids)?>">

<script>
    function loadOtherPage() {
        var urlcetakdelivery = $("#urlcetakdelivery").val();
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", urlcetakdelivery) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }
</script>

