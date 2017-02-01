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

            <form id="formitem" class="form-horizontal" action="" method="post" role="form">
                <input type="hidden" name="id" value="<?= $d->id ?>">

                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Fitting</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="date-fittingf" name="fitting_date" class="form-control" size="16" type="text"
                                   value="<?= $d->fitting_date ?>">

                        </div>

                    </div>

                </div>
                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Pinjam</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="daterentf" name="rent_date" class="form-control" size="16" type="text"
                                   value="<?= $d->rent_date ?>">

                        </div>

                    </div>

                </div>
                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Kembali</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input id="datebackf" name="back_date" class="form-control" size="16" type="text"
                                   value="<?= $d->back_date ?>">

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Deposit</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <input name="depositff" id="depositff" class="form-control" size="16" type="text" value="<?= $d->deposit ?>">

                        </div>

                    </div>

                </div>

                <hr>


                <div class="form-group">

                    <div class="col-md-12">

                        <button type="button" onclick="updatetritem()" class="pull-right btn blue">Simpan</button>

                    </div>

                </div>


            </form>

        </div>

    </div>

</div>

<script type="text/javascript">

    //        ComponentsDateTimePickers.init();
    //        var dateToday = new Date();
    //        console.log(dateToday);
    Date.prototype.yyyymmdd = function ()
    {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear(),
            (mm > 9 ? '-' : '0') + mm,
            (dd > 9 ? '-' : '0') + dd
        ].join('');
    };

    var date = new Date();
    $("#date-fittingf").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: date.yyyymmdd(),
    }).on('changeDate', function (e) {
        console.log('changedate');
        $('#daterentf').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: $("#date-fittingf").val(),
        }).on('changeDate', function (e) {
            $('#datebackf').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: $("#daterentf").val(),
            });
        });
    });
    $('.select2').select2();

</script>
