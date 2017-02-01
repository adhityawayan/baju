<div class="row ">
    <div class="col-xs-8">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$d->id?>">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Nama</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" name="name" value="<?=$d->name?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Warna / Kategori</label>
                        <div class="col-xs-2">
                            <input name="colour" class="form-control" type="text" value="<?=$d->colour?>"/>
                        </div>
                        <div class="col-xs-3">
                            <select name="kategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php foreach($kategori as $row): ?>
                                    <option value="<?=$row->id?>" <?=$d->kategori==$row->id?'selected':''?> ><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select name="type" class="form-control" required>
                                <option value="">Pilih Type</option>
                                <?php foreach($type as $row): ?>
                                    <option value="<?=$row->id?>" <?=$d->type==$row->id?'selected':''?> ><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">HPP / Harga Sewa</label>
                        <div class="col-xs-3">
                            <input name="hpp_first" class="form-control" type="number" value="<?=$d->hpp_first?>" />
                        </div>
                        <div class="col-xs-3">
                            <input name="rent_price" class="form-control" type="text" value="<?=$d->rent_price?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Harga Jual</label>
<!--                        <div class="col-sm-2">-->
<!--                            <input name="production_price" class="form-control" type="number" value=""/>-->
<!--                        </div>-->
                        <div class="col-xs-3">
                            <input name="sale_price" class="form-control" type="number" value="<?=$d->sale_price?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Qty</label>
                        <div class="col-xs-2">
                            <input name="qty" class="form-control" type="number" value="<?=$d->qty?$d->qty:0?>"/>
                        </div>
                        <div class="col-xs-3">
                            <input type="checkbox" value="1" name="new_item" <?=$d->new_item==1?'checked':''?>> Produk Baru
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Partner</label>
                        <div class="col-xs-3">
                            <select name="partner" class="form-control">
                                <option value="0">Titpan Partner</option>
                                <?php foreach($partner as $row): ?>
                                    <option value="<?=$row->id?>"><?=$row->name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Konsinyasi</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="number" name="konsinyasi" placeholder="Harga Konsinyasi" value="<?=$d->konsinyasi?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Note</label>
                        <div class="col-xs-4">
                            <textarea class="form-control" name="note" rows="3"><?=$d->note?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="setting_syarat_ketentuan" class="col-xs-4 control-label">Gambar</label>
                        <div class="col-xs-8">
                            <div class="fileinput fileinput-new">
                                <input type="file" id="setting_logo_invoice" name="image_file">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-2">
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
    <div class="col-md-4">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-white">
                    <label>Gambar</label>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <img src="<?=base_url('uploads/baju/'.$d->image)?>" alt="<?=$d->image?>" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>