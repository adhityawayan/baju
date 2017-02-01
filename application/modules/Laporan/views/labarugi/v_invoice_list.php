<div class="row ">

    <?=$this->session->flashdata('pesan')?>

    <div class="col-md-12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">

            <div class="portlet-title">
                <div class="caption font-dark">
                    <a href="<?=$linkback?>" class="btn btn-warning">Kembali</a>
                </div>
                <div class="tools"> </div>
            </div>

            <div class="portlet-body">
                <table id="myTable" class="table table-actions-wrapper">
                    <thead>
                    <tr>
                        <th class="col-xs-1">No</th>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Note</th>
                        <th>Order</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach($rowdata->appointment as $row):?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><a href="javascript:void(0);" onclick="invoice(<?=$row->id?>)"><?=$row->code?></a></td>
                            <td><?=tgl_indo_waktu($row->date)?></td>
                            <td><a href="javascript:void(0)" onclick="showCustomer(<?=$row->mcustomer->id?>)"><?=$row->mcustomer->name?></a></td>
                            <td><?=$row->note?></td>
                            <td><?=proses()[$row->mdeal->process]?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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

<div id="showdetail" class="modal fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail Customer</h4>
    </div>
    <div id="customer-detail" class="modal-body">

    </div>
</div>

<input type="hidden" id="urlinvoice" value="<?=site_url('bisnis/history/invoice')?>">
<input type="hidden" id="urlcustomer" value="<?=site_url('master/customer/show')?>">

<!-- END PAGE CONTENT-->

<script>
    $(document).ready(function(){
        $('#myTable').DataTable();
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

    function showCustomer(id)
    {
        var $urlcus = $('#urlcustomer').val();
        $.ajax({
            url : $urlcus+'/'+id,
            type: 'get',
            cache: false,
            dataType: 'html',
        })
            .success(function(data){
                $('#customer-detail').html(data);
                $('#showdetail').modal('show');
            });

    }

</script>