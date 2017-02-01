<div class="row ">

    <?=$this->session->flashdata('pesan')?>

    <div class="col-md-12">


        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">

            <div class="portlet-title">

                <div class="caption font-dark">

                    <a href="<?=$link_add?>" class="btn sbold blue"><i class="fa fa-plus"></i> Tambah Data</a>
                    <a href="<?=$link_import?>" class="btn sbold blue"><i class="fa fa-plus"></i> Import</a>

                </div>

                <div class="tools"> </div>

            </div>

            <div class="portlet-body">
                    <table id="myTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID CARD</th>
                            <th>Nama</th>
                            <th>TL</th>
                            <th>Handphone</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($data as $row):?>
                            <tr>
                                <td><?=$row->id?></td>
                                <td><a id="<?=$row->id?>" href="javascript:void(0);" onclick="showHistory(this.id)"><?=$row->card?></a></td>
                                <td><?=$row->name?></td>
                                <td><?=tgl_indo($row->born_date)?></td>
                                <td><?=$row->phone?></td>
                                <td><?=$row->email?></td>
                                <td><?=$row->address?></td>
                                <td>
                                    <a href="<?=$link_edit.$row->id?>" class="btn btn-success">Edit</a>
                                    <button type="button" href="#" class="btn btn-danger del" href="javascript:void(0);" id="<?=$row->id?>">Del</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="mymodal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">

                        <div class="modal-body">

                            <p> Anda yakin ingin menghapus data? </p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" data-dismiss="modal" class="btn btn-outline red">Cancel</button>

                            <button id="delete_all_trigger" type="submit" class="btn btn-outline dark danger act_del">Hapus</button>

                        </div>

                    </div>
                <!-- ajax -->

                <div id="ajax-modal" class="modal fade" tabindex="-1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">History Appointment Customer</h4>
                    </div>
                    <div id="history-list" class="modal-body">

                    </div>
                </div>

            </div>



        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- END EXAMPLE TABLE PORTLET-->

    </div>



</div>

<input type="hidden" id="iddel">
<input type="hidden" id="url" value="<?=$link_delete?>">
<input type="hidden" id="urlcustomer" value="<?=$link_appointment?>">

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

    function showHistory(id)
    {
        var $urlcus = $('#urlcustomer').val();
        $.ajax({
            url : $urlcus+'/'+id,
            type: 'get',
            cache: false,
            dataType: 'html',
        })
            .success(function(data){
                $('#history-list').html(data);
                $('#ajax-modal').modal('show');
            });

    }
</script>