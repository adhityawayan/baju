<div class="row ">
    <?= $this->session->flashdata('pesan') ?>
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <a href="<?= $link_add ?>" class="btn sbold blue"><i class="fa fa-plus"></i> Tambah Data</a>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body table-responsive">
                <table id="myTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Order</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;
                    foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><a href="javascript:void(0);" onclick="invoice(<?=$row->id?>)"><?= $row->code ?></a></td>
                            <td><?= tgl_indo_waktu($row->date) ?></td>
                            <td><?= $row->mcustomer->name ?></td>
                            <td><?= $row->mdeal?proses()[$row->mdeal->process]:'' ?></td>
                            <td>
                                <button data-toggle="tooltip" data-placement="top" title="Delivery" id="<?= $row->id ?>" type="button" onclick="delivery(this.id)"
                                        class="btn btn-info btn-invoice">
                                    <span class="glyphicon glyphicon-send"></span></button>
                                <?php
                                if($row->mdeal):
                                if($row->mdeal->process == PROSES_RENT or $row->mdeal->process == PROSES_MADE_FOR_RENT):
                                    ?>
                                <button data-toggle="tooltip" data-placement="top" title="Return" id="<?= $row->id ?>" type="button" onclick="return_invoice(this.id)"
                                        class="btn btn-info btn-invoice">
                                    <span class="glyphicon glyphicon-share"></span></button>
                                <?php
                                endif;
                                endif; ?>
                            </td>
                            <td>
                                <a href="<?= $link_edit . $row->id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="Detail Appointment" href="<?= $link_deal . $row->id ?>" class="btn btn-success"><span
                                        class="glyphicon glyphicon-list"></span></a>
                                <button data-toggle="tooltip" data-placement="top" title="Cancel" type="button" href="#" class="btn btn-danger del" href="javascript:void(0);"
                                        id="<?= $row->id ?>"><span class="glyphicon glyphicon-trash"></span></button>
                                <a data-toggle="tooltip" data-placement="top" title="Detail Process" class="btn btn-default" href="<?= $link_process ?><?= $row->id ?>"><span class="glyphicon glyphicon-list-alt"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div id="mymodal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">

                    <div class="modal-body">

                        <p> Anda yakin ingin menghapus data? </p>
                        <textarea id="cancel-text" class="form-control" placeholder="Alasan Cancel..."></textarea>
                    </div>

                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline red">Batal</button>

                        <button id="delete_all_trigger" type="submit" class="btn btn-outline dark danger act_del">
                            Hapus
                        </button>

                    </div>

                </div>

                <div id="mymodalalertstatus" class="modal fade" tabindex="-1" data-backdrop="static"
                     data-keyboard="false">

                    <div class="modal-body">
                        <h3 id="remaining-pay"></h3>

                        <p> Anda yakin ingin merubah status ? </p>
                    </div>

                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline red">Batal</button>

                        <button id="delete_all_trigger" type="button" class="btn btn-outline dark danger btn-status">
                            Ganti
                        </button>

                    </div>

                </div>

                <div id="mymodalreturnstatus" class="modal fade" tabindex="-1" data-backdrop="static"
                     data-keyboard="false">

                    <div class="modal-body">
                        <h3 id="deposit-pay"></h3>
                        <input type="hidden" id="deposit-paying">
                        <input type="hidden" id="keepdeposit-paying">

                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control" id="status_return">
                                    <option value="0">Pilih Status</option>
                                    <?php foreach (status_return() as $key => $val): ?>
                                        <option value="<?= $key ?>"><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input placeholder="Telat Berapa Hari ..." type="number"
                                       onkeyup="dayminusdeposit(this.value)" id="daydeposit" class="form-control">

                                <p class="help-block">*Per Jumlah Hari x 100.000</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input placeholder="Dendan Sejumlah .. " onkeyup="minusdeposit(this.value)"
                                       type="number" id="pinalty_deposit" class="form-control">

                                <p class="help-block">*Denda kerusakan</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" id="return_note"
                                          placeholder="Keterangan Barang Yang dipinjam..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline red">Batal</button>

                        <button id="delete_all_trigger" type="button" class="btn btn-outline dark danger btn-status">
                            Ganti
                        </button>

                    </div>

                </div>
                <!-- ajax -->

                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>

<div id="invoice" class="modal container fade modal-overflow in" tabindex="-1" aria-hidden="true">

</div>

<div id="delivery" class="modal container fade modal-overflow in" tabindex="-1" aria-hidden="true">

</div>

<div id="returninvoice" class="modal container fade modal-overflow in" tabindex="-1" aria-hidden="true">

</div>

<input type="hidden" id="iddel">
<input type="hidden" id="url" value="<?= $link_delete ?>">
<input type="hidden" id="urlinvoice" value="<?= $link_invoice ?>">
<input type="hidden" id="urldelivery" value="<?= $link_delivery ?>">
<input type="hidden" id="urlreturninvoice" value="<?= $link_returninvoice ?>">
<input type="hidden" id="urlajaxkembali" value="<?= $link_ajaxkembali ?>">

<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();

        $('.del').click(function () {
            $('#mymodal').modal('show');
            $('#iddel').val(this.id);
        });
        $('.act_del').click(function () {
            var $url = $('#url').val();
            var id = $('#iddel').val();
            var canceltext = $('#cancel-text').val();

            $.ajax({
                url: $url + '/' + id,
                type: 'post',
                data: {cancel: canceltext},
                cache: false,
            })
                .success(function () {
                    /*optional stuff to do after success */
                    $('#mymodal').modal('hide');
                })
                .done(function () {
                    location.reload(true);
                });
        });
    });

    function invoice(id) {
        var urlinvoice = $('#urlinvoice').val();
        $.ajax({
            beforeSend: function () {
                $("#loading").modal('show');
            },
            url: urlinvoice + '/' + id,
            type: 'get',
            cache: false,
        })
            .success(function (data) {
                $('#invoice').html(data);
                $("#loading").modal('hide');
                $('#invoice').modal('show');
            });
    }

    function delivery(id) {
        var urldelivery = $('#urldelivery').val();
        $.ajax({
            beforeSend: function () {
                $("#loading").modal('show');
            },
            url: urldelivery + '/' + id,
            type: 'get',
            cache: false,
        })
            .success(function (data) {
                $('#delivery').html(data);
                $("#loading").modal('hide');
                $('#delivery').modal('show');
            });
    }

    function return_invoice(id) {
        var urlreturninvoice = $('#urlreturninvoice').val();
        $.ajax({
            beforeSend: function () {
                $("#loading").modal('show');
            },
            url: urlreturninvoice + '/' + id,
            type: 'get',
            cache: false,
        })
            .success(function (data) {
                $('#returninvoice').html(data);
                $("#loading").modal('hide');
                $('#returninvoice').modal('show');
            });
    }

    function confirmstatus(url, rp) {
        $('#mymodalalertstatus').modal('show');
        $('#remaining-pay').html('Biaya Remaining Payment : <span class="label-danger">' + toRp(rp) + '</span>');
        $('.btn-status').click(function () {
            window.location = url;
        });
        return false;
    }

    function confirmreturn(url, rp, id) {
        $('#mymodalreturnstatus').modal('show');
        $('#deposit-pay').html('Kembalikan Deposit : <span class="label-danger">' + toRp(rp) + '</span>');
        $('#deposit-paying').val(rp);
        $('#keepdeposit-paying').val(rp);
        var urlajax = $('#urlajaxkembali').val();

        $('.btn-status').click(function () {

            var pinalty_deposit = $('#pinalty_deposit').val();
            var back_deposit = $('#deposit-paying').val();
            var return_note = $('#return_note').val();
            var status_return = $('#status_return').val();
            var day = $('#daydeposit').val();

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    pinalty: pinalty_deposit,
                    return_note: return_note,
                    status_return: status_return,
                    day: day,
                    back_deposit: back_deposit
                },
                cache: false,
            })
                .success(function () {
                    $('#mymodalreturnstatus').modal('hide');
                    delivery(id)
                    $('#delivery').on('hide', function () {
                        location.reload();
                    });
                });
        });
    }

    function dayminusdeposit(num) {
        if (num != 0) {
            var depo = $('#deposit-paying').val();
            var result = parseInt(depo) - (parseInt(num) * 100000);
            $('#deposit-pay').html('Kembalikan Deposit : <span class="label-danger">' + toRp(result) + '</span>');
            console.log(result);
            $('#keepdeposit-paying').val(result);
        }
    }

    function minusdeposit(num) {
        if (num != 0) {
            var depo = $('#keepdeposit-paying').val();
            var result = parseInt(depo) - parseInt(num);
            $('#deposit-pay').html('Kembalikan Deposit : <span class="label-danger">' + toRp(result) + '</span>');
            console.log(result);
            $('#deposit-paying').val(result);
        }
        else {
            var keepdepo = $('#keepdeposit-paying').val();
            $('#deposit-paying').val(keepdepo);
        }
    }
</script>