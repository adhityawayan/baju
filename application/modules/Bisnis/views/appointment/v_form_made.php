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
                <form id="formmaderent" class="form-horizontal">
                    <input type="hidden" name="appointment_id" value="<?=$app->id?>">
                    <input type="hidden" name="customer_id" value="<?=$app->customer_id?>">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Nama</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Warna / Kategori</label>
                        <div class="col-sm-2">
                            <input name="colour" class="form-control" type="text" required/>
                        </div>
                        <div class="col-sm-3">
                            <select name="kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($kategori as $row): ?>
                                    <option value="<?=$row->id?>"><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select name="type" class="form-control" required>
                                <option value="">Pilih Type</option>
                                <?php foreach($type as $row): ?>
                                    <option value="<?=$row->id?>"><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">HPP / Harga Sewa</label>
                        <div class="col-sm-2">
                            <input name="hpp_first" class="form-control" type="number" required />
                        </div>
                        <div class="col-sm-2">
                            <input name="rent_price" class="form-control" type="number" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Harga Jual</label>
                        <div class="col-sm-3">
                            <input name="sale_price" class="form-control" type="number" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Note</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" name="note" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-1">
                            <button type="button" onclick="bajumaderent()" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>