<div class="row ">
    <?=$this->session->flashdata('pesan')?>
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post">
                    <input type="hidden" name="group_id" value="<?=$id?>">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th class="col-xs-1">NO</th>
                            <th>MODUL</th>
                            <th class="text-center">CREATE</th>
                            <th class="text-center">READ</th>
                            <th class="text-center">UPDATE</th>
                            <th class="text-center">DELETE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($role as $key=>$row): ?>
                            <input type="hidden" name="id[]" value="<?=$row->id?>">
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=modul()[$row->modul]?></td>
                                <td><input class="form-control" name="attr[<?=$row->id?>][c]" value="1" <?=$row->c==1?'checked':''?> type="checkbox"></td>
                                <td><input class="form-control" name="attr[<?=$row->id?>][r]" value="1" <?=$row->r==1?'checked':''?> type="checkbox"></td>
                                <td><input class="form-control" name="attr[<?=$row->id?>][u]" value="1" <?=$row->u==1?'checked':''?> type="checkbox"></td>
                                <td><input class="form-control" name="attr[<?=$row->id?>][d]" value="1" <?=$row->d==1?'checked':''?> type="checkbox"></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-1">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?=$link_back?>" class="btn sbold yellow"> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function() {

        ComponentsDateTimePickers.init();

    });

</script>