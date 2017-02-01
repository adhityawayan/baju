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
                    <table id="myTable" class="table table-actions-wrapper">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>TL</th>
                            <th>Telp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($partner as $row):?>
                            <tr>
                                <td><?=$row->id?></td>
                                <td><?=$row->code?></td>
                                <td><?=$row->name?></td>
                                <td><?=tgl_indo($row->born_date)?></td>
                                <td><?=$row->phone?></td>
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

                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>



            </div>



        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- END EXAMPLE TABLE PORTLET-->

    </div>



</div>

<input type="hidden" id="iddel">
<input type="hidden" id="url" value="<?=$link_delete?>">

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
</script>