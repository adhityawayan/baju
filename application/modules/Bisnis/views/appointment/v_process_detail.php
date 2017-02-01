<div class="row ">
    <?= $this->session->flashdata('pesan') ?>
    <div class="col-md-6">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <form class="form" method="post" action="<?=$link_act?>">
                <input type="hidden" name="appointment_id" value="<?=$appointment_id?>">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Signature <span class="caret"></span>
                        </button>
                        <a href="<?=site_url('bisnis/appointment/change_complete/'.$appointment_id)?>" class="btn btn-success">Complete</a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="tooltip" data-placement="top" title="TTD INVOICE" class="btn btn-default" href="<?= $link_ttd ?><?=$appointment_id?>">TTD Invoice</a></li>
                            <li><a data-toggle="tooltip" data-placement="top" title="TTD PICK UP" class="btn btn-default" href="<?= $link_ttdpickup ?><?=$appointment_id?>">TTD Pickup</a></li>
                            <li><a data-toggle="tooltip" data-placement="top" title="TTD RETURN" class="btn btn-default" href="<?= $link_ttdreturn ?><?=$appointment_id?>">TTD Return</a></li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <a href="<?= $link_back ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                <div class="tools"></div>
            </div>
                <div class="portlet-body">
                    <h3>Fitting Baju</h3>
                    <table class="table table-actions-wrapper">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;
                        if ($tritem) {
                            foreach ($tritem as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->mbaju->name ?></td>
                                    <td><?= tgl_indo($row->fitting_date) ?></td>
                                    <td><input type="checkbox" name="item_fitting_status[]" value="<?=$row->id?>" <?= $row->fitting_status == 1 ? 'checked' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>

                        <?php if ($trmade) { ?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td>
                                    <ul>
                                    <?php foreach ($trmade as $row): ?>
                                        <li><?=$row->disc?> | <?=rupiah($row->price)?></li>
                                    <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <?=$mappointment->mdeal->date_fitting?>
                                </td>
                                <td>
                                    <input type="checkbox" name="appoitment_fitting_status" value="1" <?=$mappointment->mdeal->fitting==1?'checked':''?>>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if ($dpromo) {
                            foreach ($dpromo as $row):
                                foreach ($row->trpromo as $tr):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $tr->mbaju ? $tr->mbaju->name : 'Belum Dipilih' ?></td>
                                        <td><?= $tr->fitting_date?tgl_indo($tr->fitting_date):'' ?></td>
                                        <td>
                                            <?php if($tr->mbaju) {?>
                                            <input type="checkbox" name="promo_fitting_status[]" value="<?=$tr->id?>" <?= $tr->fitting_status == 1 ? 'checked' : '' ?>>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endforeach;
                        } ?>
                        </tbody>
                    </table>
                </div>

                <div class="portlet-body">
                    <h3>Pick Up Baju</h3>
                    <table class="table table-actions-wrapper">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;
                        if ($tritem) {
                            foreach ($tritem as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->mbaju->name ?></td>
                                    <td><?= tgl_indo($row->rent_date) ?></td>
                                    <td><input type="checkbox" name="item_rent_status[]" value="<?=$row->id?>" <?= $row->rent_status == 1 ? 'checked' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>

                        <?php if ($trmade) { ?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td>
                                    <ul>
                                        <?php foreach ($trmade as $row): ?>
                                            <li><?=$row->disc?> | <?=rupiah($row->price)?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <?=$mappointment->mdeal->date_borrow?>
                                </td>
                                <td>
                                    <input type="checkbox" name="appoitment_rent_status" value="1" <?=$mappointment->mdeal->pickup==1?'checked':''?>>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if ($dpromo) {
                            foreach ($dpromo as $row):
                                foreach ($row->trpromo as $tr):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $tr->mbaju ? $tr->mbaju->name : 'Belum Dipilih' ?></td>
                                        <td><?= $tr->rent_date?tgl_indo($tr->rent_date):'' ?></td>
                                        <td>
                                            <?php if($tr->mbaju){?>
                                            <input type="checkbox" name="promo_rent_status[]" value="<?=$tr->id?>" <?= $tr->rent_status == 1 ? 'checked' : '' ?>>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endforeach;
                        } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    Return Baju
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-actions-wrapper">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Minus</th>
                        <th>Deposit</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;
                    if($mappointment->mdeal):
                    if($mappointment->mdeal->process==PROSES_MADE_FOR_RENT or $mappointment->mdeal->process==PROSES_RENT):
                    if ($tritem) {
                        foreach ($tritem as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->mbaju->name ?></td>
                                <td><?= tgl_indo($row->back_date) ?></td>
                                <td class="text-right"><?=rupiah($row->minus)?></td>
                                <td class="text-right"><?=rupiah($row->deposit)?></td>
                                <td>
                                    <a href="<?=site_url('bisnis/appointment/return_sewa/'.$row->id.'/item')?>" class="btn <?=$row->back_status=='1'?'btn-success':'btn-danger'?>"><i class="glyphicon glyphicon-share-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;
                    }
                    endif;
                    endif;
                    ?>

                    <?php if ($trpromo) {
                            foreach ($trpromo as $tr):
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $tr->mbaju ? $tr->mbaju->name : 'Belum Dipilih' ?></td>
                                    <td><?= $tr->back_date?tgl_indo($tr->back_date):'' ?></td>
                                    <td class="text-right"><?=$tr->deposit?rupiah($tr->minus):''?></td>
                                    <td class="text-right"><?=$tr->deposit?rupiah($tr->deposit):''?></td>
                                    <td>
                                        <?php if($tr->mbaju){?>
                                        <a href="<?=site_url('bisnis/appointment/return_sewa/'.$tr->id.'/promo')?>" class="btn <?=$tr->back_status=='1'?'btn-success':'btn-danger'?>"><i class="glyphicon glyphicon-share-alt"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    Remaining Payment
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped">
                    <tr>
                        <td>Tanggal</td>
                        <td class="text-right">Jumlah</td>
                    </tr>
                    <tr>
                        <td><?=$mappointment->mdeal?tgl_indo($mappointment->mdeal->date_rp):''?></td>
                        <td class="text-right"><?=$mappointment->mdeal?rupiah($mappointment->mdeal->remaining_payment):''?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
    if($mappointment->mdeal):
    if($mappointment->mdeal->process==PROSES_MADE_FOR_SALE):
    ?>
    <div class="col-sm-6">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    Deposit
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped">
                    <tr>
                        <td>Status</td>
                        <td class="text-right">Jumlah</td>
                        <td class="text-right">Action</td>
                    </tr>
                    <tr>
                        <td><?=$mappointment->mdeal?$mappointment->mdeal->back_deposit==1?'Lunas':'Belum':''?></td>
                        <td class="text-right"><?=$mappointment->mdeal?rupiah($mappointment->mdeal->deposit):''?></td>
                        <td class="text-right">
                            <a href="<?=site_url('bisnis/appointment/back_deposit_for_sale/'.$mappointment->id)?>" class="btn <?=$mappointment->mdeal->back_deposit==1?'btn-success':'btn-danger'?>"><span class="glyphicon glyphicon-share-alt"></span></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php endif; endif; ?>
    <div class="col-sm-5" style="display: none;">
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    Deposit
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped">
                    <tr>
                        <td>Deposit</td>
                        <td>Minus</td>
                        <td>Total</td>
                        <td>Lunas</td>
                    </tr>
                    <?php foreach($trdeposit as $row): ?>
                        <tr>
                            <td><?=rupiah($row->deposit)?></td>
                            <td><?=rupiah($row->minus)?></td>
                            <td><?=rupiah($row->deposit - $row->minus)?></td>
                            <td><?=deposit_status()[$row->back_status]?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>