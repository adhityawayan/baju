<div class="row ">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <?php if($jenis!='made'){?>
                    <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post">
                        <input type="hidden" name="id" value="<?=$rowdata->id?>">
                        <input type="hidden" name="jenis" value="<?=$jenis?>">
                        <input type="hidden" name="appointment_id" value="<?=$rowdata->appointment_id?>">

                        <input type="hidden" id="deposit" name="deposit" value="<?=$rowdata->deposit?>">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Status Return</label>
                            <div class="col-sm-5">
                                <select id="status_return" class="form-control" name="status_return">
                                    <option value="0">Pilih Status</option>
                                    <?php foreach(status_return() as $key=>$row){ ?>
                                        <option value="<?=$key?>" <?=$rowdata->status_return==$key?'selected':''?> ><?=$row?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="form-telathari" style="display: none;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Telat Hari</label>
                                <div class="col-sm-1">
                                    <input type="number" id="hari_telat" class="form-control" name="hari_telat" value="<?=$rowdata->hari_telat?>">
                                </div>
                            </div>
                        </div>
                        <div id="form-denda" style="display: none;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Denda</label>
                                <div class="col-sm-3">
                                    <input type="number" id="denda" class="form-control" name="denda" value="<?=$rowdata->denda?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Keterangan</label>
                            <div class="col-sm-5">
                                <textarea name="keterangan" rows="4" class="form-control"><?=$rowdata->keterangan?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-1">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                            <div class="col-sm-1">
                                <a href="<?=$link_back.$rowdata->appointment_id?>" class="btn sbold yellow"> Kembali</a>
                            </div>
                        </div>
                    </form>
                <?php } else {?>
                    <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post">
                        <input type="hidden" name="id" value="<?=$rowdata->mdeal->id?>">
                        <input type="hidden" name="jenis" value="<?=$jenis?>">
                        <input type="hidden" name="appointment_id" value="<?=$rowdata->id?>">

                        <input type="hidden" id="deposit" name="deposit" value="<?=$rowdata->mdeal->deposit?>">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Status Return</label>
                            <div class="col-sm-5">
                                <select id="status_return" class="form-control" name="status_return">
                                    <option value="0">Pilih Status</option>
                                    <?php foreach(status_return() as $key=>$row){ ?>
                                        <option value="<?=$key?>" <?=$rowdata->mdeal->returned==$key?'selected':''?> ><?=$row?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="form-telathari" style="display: none;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Telat Hari</label>
                                <div class="col-sm-1">
                                    <input type="number" id="hari_telat" class="form-control" name="hari_telat" value="<?=$rowdata->mdeal->hari_telat?>">
                                </div>
                            </div>
                        </div>
                        <div id="form-denda" style="display: none;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Denda</label>
                                <div class="col-sm-3">
                                    <input type="number" id="denda" class="form-control" name="denda" value="<?=$rowdata->mdeal->pinalty?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Keterangan</label>
                            <div class="col-sm-5">
                                <textarea name="keterangan" rows="4" class="form-control"><?=$rowdata->mdeal->return_note?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-1">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                            <div class="col-sm-1">
                                <a href="<?=$link_back.$rowdata->id?>" class="btn sbold yellow"> Kembali</a>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var status = $('#status_return').val();
    ajax_status(status);

    function ajax_status(status)
    {
        if(status==0)
        {
            $('#form-telathari,#form-denda').hide();
        }
        if(status==1)
        {
            $('#form-telathari,#form-denda').hide();
        }
        if(status==2)
        {
            $('#form-telathari').hide();
            $('#form-denda').show();
        }
        if(status==3)
        {
            $('#form-telathari').show();
            $('#form-denda').hide();
        }
    }

    jQuery(document).ready(function() {

        $('#status_return').change(function(){
            var status = this.value;
//            console.log('deye');
            ajax_status(status);

        });
    });

</script>