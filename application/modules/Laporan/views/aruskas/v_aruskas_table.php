<div class="row ">

    <?=$this->session->flashdata('pesan')?>

    <div class="col-md-12">

        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">

            <div class="portlet-title">

                <div class="caption font-dark">
                    <button onclick="loadOtherPage()" class="btn sbold blue"><i class="fa fa-print"></i> Print</button>
                </div>
                <div class="tools"> </div>

            </div>

            <div class="portlet-body">
                    <table id="myTable" class="table table-actions-wrapper">
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
                        </tbody>
                    </table>
                <!-- ajax -->

                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <hr>
                <div class="row">

                    <div class="col-md-4 col-md-offset-8">

                        <div class="form-group">

                            <label class="col-md-5 control-label bold"> Total Debit: </label>

                            <div class="col-md-7 bold">

                                <div class="text-right" id="total-debit">Rp. <?=$total_debit?></div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                        <div class="form-group">

                            <label class="col-md-5 control-label bold"> Total Kredit: </label>

                            <div class="col-md-7 bold">

                                <div class="text-right" id="total-kredit">Rp. <?=$total_kredit?></div>

                            </div>

                        </div>



                        <div class="clearfix"></div>



                        <div class="form-group">

                            <label class="col-md-5 control-label bold"> Total Piutang: </label>

                            <div class="col-md-7 bold">

                                <div class="text-right" id="total-piutang">Rp. <?=$total_piutang?></div>

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

<input type="hidden" id="urlcetak" value="<?=base_url('laporan/aruskas/print_aruskas/'.$from.'/'.$to)?>">

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