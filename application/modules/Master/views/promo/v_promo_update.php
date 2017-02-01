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
                <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post">
                    <input type="hidden" name="id" value="<?=$d->id?>">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Nama</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?=$d->name?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Keterangan</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="note"><?=$d->note?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Diskon</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="disc" value="<?=$d->disc?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Jumlah / Kategori</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="qty" value="<?=$d->qty?>">
                        </div>
                        <div class="col-sm-3">
                            <select name="kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($kategori as $row): ?>
                                    <option value="<?=$row->id?>" <?=$d->kategori==$row->id?'selected':''?> ><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
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