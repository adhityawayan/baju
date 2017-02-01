<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 07/11/2016
 * Time: 10:33
 */
?>
<div class="row">

    <div class="col-md-12">

        <div class="well well-lg">

            <form id="formpromo" class="form-horizontal" action="" method="post" role="form">
                <input type="hidden" name="id" value="<?=$d->id?>">

                <div class="form-group">

                    <label for="customer_nama" class="col-md-4 control-label">Pilih Baju</label>

                    <div class="col-md-8">
                            <select name="baju_id" class="select2">
                                <option value="">Pilih Baju</option>
                                <?php foreach($baju as $row): ?>
                                    <option value="<?=$row->id?>" <?=$row->id==$d->baju_id?'selected':''?> ><?=$row->name?> - <?=$row->colour?></option>
                                <?php endforeach; ?>
                            </select>
                    </div>

                </div>

                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Fitting</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="date-fittingfp" name="fitting_date" class="form-control" size="16" type="text" value="<?=$d->fitting_date?>">

                        </div>

                    </div>

                </div>
                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Pinjam</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="daterentfp" name="rent_date" class="form-control" size="16" type="text" value="<?=$d->rent_date?>">

                        </div>

                    </div>

                </div>
                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Kembali</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="datebackfp" name="back_date" class="form-control" size="16" type="text" value="<?=$d->back_date?>">

                        </div>

                    </div>

                </div>
                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Deposit</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input name="depositpromo" id="despoitpromo" class="form-control" size="16" type="text" value="<?=$d->deposit?>">

                        </div>

                    </div>

                </div>

                <hr>



                <div class="form-group">

                    <div class="col-md-12">

                        <button type="button" onclick="updatetrpromo()" class="pull-right btn blue">Simpan</button>

                    </div>

                </div>



            </form>

        </div>

    </div>

</div>
<script type="text/javascript">


    $('.select2').select2();
    Date.prototype.yyyymmdd = function() {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear(),
            (mm>9 ? '-' : '0') + mm,
            (dd>9 ? '-' : '0') + dd
        ].join('');
    };

    var date = new Date();

    $( "#date-fittingfp" ).datepicker({
        format :	'yyyy-mm-dd',
        autoclose : true,
        startDate: date.yyyymmdd(),
    }).on('changeDate', function(e) {
        $('#daterentfp').datepicker({
            format :	'yyyy-mm-dd',
            autoclose : true,
            startDate: $("#date-fittingfp").val(),
        }).on('changeDate', function(e){
            $('#datebackfp').datepicker({
                format :	'yyyy-mm-dd',
                autoclose : true,
                startDate: $("#daterentfp").val(),
            });
        });
    });


</script>
