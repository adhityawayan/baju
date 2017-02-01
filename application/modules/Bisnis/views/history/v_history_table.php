<div class="row ">
    <?=$this->session->flashdata('pesan')?>
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">

                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                    <table id="myTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Order</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($data as $row):?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td><a href="javascript:void(0);" onclick="invoice(<?=$row->id?>)"><?=$row->code?></a></td>
                                <td><?=$row->mcustomer->name?></td>
                                <td><?=proses()[$row->mdeal->process]?></td>
                                <td>
                                    <button id="<?=$row->id?>" type="button" onclick="delivery(this.id)" class="btn btn-info btn-invoice" <?=empty($row->pickuped)?'disabled':''?>>Delivery</button>
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

                            <button id="delete_all_trigger" type="submit" class="btn btn-outline dark danger act_del">Hapus</button>

                        </div>

                    </div>

                <div id="mymodalalertstatus" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">

                    <div class="modal-body">

                        <p> Anda yakin ingin merubah status ? </p>
                    </div>

                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline red">Batal</button>

                        <button id="delete_all_trigger" type="button" class="btn btn-outline dark danger btn-status">Ganti</button>

                    </div>

                </div>
                <!-- ajax -->

                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
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

<input type="hidden" id="iddel">
<input type="hidden" id="urlinvoice" value="<?=$link_invoice?>">
<input type="hidden" id="urldelivery" value="<?=$link_delivery?>">
<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function(){
        $('#myTable').DataTable();

        $('.del').click(function(){
            $('#mymodal').modal('show');
            $('#iddel').val(this.id);
        });
        $('.act_del').click(function(){
            var $url = $('#url').val();
            var id = $('#iddel').val();
            var canceltext = $('#cancel-text').val();

            $.ajax({
                url : $url+'/'+id,
                type: 'post',
                data: {cancel:canceltext},
                cache: false,
            })
                .success(function(){
                    /*optional stuff to do after success */
                    $('#mymodal').modal('hide');
                })
                .done(function(){
                    location.reload(true);
                });
        });
    });
    function invoice(id)
    {
        var urlinvoice = $('#urlinvoice').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlinvoice+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#invoice').html(data);
                $("#loading").modal('hide');
                $('#invoice').modal('show');
            });
    }

    function delivery(id)
    {
        var urldelivery = $('#urldelivery').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urldelivery+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#delivery').html(data);
                $("#loading").modal('hide');
                $('#delivery').modal('show');
            });
    }

    function confirmstatus(url)
    {
        $('#mymodalalertstatus').modal('show');
        $('.btn-status').click(function(){
            window.location = url;
        });
        return false;
    }
</script>