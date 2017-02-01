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
                <form class="form-horizontal" method="post" action="<?= $link_act ?>" role="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Customer</label>

                        <div class="col-sm-5">
                            <select onchange="history_customer(this.value)" id="customer-list" class="form-control select2" name="customer_id">
                                <option value="">Pilih Customer</option>
                                <?php foreach ($customer as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="help-block">
                                <button type="button" class="btn btn-info btn-xs add-customer"><i
                                        class="fa fa-plus"></i> Customer
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <textarea rows="4" placeholder="History..." id="history-text" class="form-control"
                                      disabled></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Tanggal</label>

                        <div class="col-sm-3">
                            <input id="dateappointment" type="text" class="form-control" name="date"
                                   placeholder="Tanggal Waktu">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Keterangan</label>

                        <div class="col-sm-5">
                            <textarea name="note" class="form-control" rows="4"
                                      placeholder="Keterangan Appointment"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-1">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                        <div class="col-sm-1">
                            <a href="<?= $link_back ?>" class="btn sbold yellow"> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ajax-modal" class="modal fade modal-overflow in" tabindex="-1" aria-hidden="true">
    <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

        <div class="portlet-title">

            <div class="caption">

                <i class="icon-plus font-red-sunglo"></i>

                <span class="caption-subject font-red-sunglo bold uppercase">Tambah Data</span>

            </div>

        </div>

    </div>

    <div class="modal-body" id="form-customer">

    </div>
</div>
<input type="hidden" id="urlcustomer" value="<?= $link_cus ?>">
<input type="hidden" id="urlcustomerid" value="<?= $link_cus_id ?>">

<script type="text/javascript">


    //    $(".form_datetime").datetimepicker({
    //
    //        autoclose: true,
    //
    //        isRTL: App.isRTL(),
    //
    //        format: "yyyy-mm-dd hh:ii",
    //
    //        pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
    //
    //    });

    jQuery(document).ready(function () {

        var dateTime = new Date();
        dateTime = moment(dateTime).format("YYYY-MM-DD HH:mm");

        $("#dateappointment").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            startDate: dateTime,
        });

        $('.add-customer').click(function () {
            var urlcus = $('#urlcustomer').val();
            $.ajax({
                url: urlcus,
                type: 'get',
                cache: false,
            })
                .success(function (data) {
                    $('#form-customer').html(data);
                    $('#ajax-modal').modal('show');
                });
        });

    });

    function history_customer(idcus) {
        var urlcusid = $('#urlcustomerid').val();
        $.ajax({
            url: urlcusid + '/' + idcus,
            type: 'get',
            cache: false,
            dataType: 'json',
        })
            .success(function (data) {
                if(data.length!=0)
                {
                    $('#history-text').val(data[0].cancel);
                }
                else
                {
                    $('#history-text').val('');
                }
            });
    }

</script>