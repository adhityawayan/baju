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
                    <table id="myTable" class="table table-actions-wrapper">
                        <thead>
                        <tr>
                            <th class="col-xs-1">No</th>
                            <th>Nama</th>
                            <th>Harga Sewa</th>
                            <th>HPP Awal</th>
                            <th>Disewa</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($baju as $row):?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td><?=$row->name?></td>
                                <td>Rp. <?=rupiah($row->rent_price)?></td>
                                <td>Rp. <?=rupiah($row->hpp_first)?></td>
                                <td><?=$row->disewa?></td>
                                <td>
                                    <a href="<?=$linkinvoice.$row->id?>" class="btn btn-success"><i class="glyphicon glyphicon-th-list"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <!-- ajax -->
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <div class="form-group">
                            <label class="col-md-5 control-label bold"> Total Balance: </label>
                            <div class="col-md-7 bold">
                                <div class="text-right" id="total-debit">Rp. <?=rupiah($total)?></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- END EXAMPLE TABLE PORTLET-->

    </div>



</div>

<input type="hidden" id="urlcetak" value="<?=base_url('laporan/aruskas/print_aruskas/')?>">

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
            $.ajax({
                url : $url+'/'+id,
                type: 'get',
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

    function loadOtherPage() {
        var urlcetak = $("#urlcetak").val();
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", urlcetak) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }
</script>