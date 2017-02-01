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
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Nama</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Sewa</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="rent_price">
                        </div>
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Jual</label>-->
<!--                        <div class="col-sm-2">-->
<!--                            <input type="number" class="form-control" name="sale_price">-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Partner</label>
                        <div class="col-sm-3">
                            <select name="partner" class="form-control">
                                <option value="0">Pilih</option>
                                <?php foreach($partner as $row): ?>
                                    <option value="<?=$row->id?>"><?=$row->name?></option>
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