<div class="row ">

    <div class="col-md-offset-3 col-md-6">
        <!-- BEGIN SAMPLE FORM PORTLET-->

        <div class="portlet box red">

            <div class="portlet-title">

                <div class="caption">

                    <i class="fa fa-gears"></i> <small><strong>Laporan Kas</strong></small> </div>

            </div>

            <div class="portlet-body">

                <form class="form-horizontal" action="<?=base_url('laporan/aruskas/report')?>" method="post" role="form">

                    <div class="form-group">

                        <label for="diskon_custom" class="col-md-4 control-label"> Periode From </label>

                        <div class="col-md-6">

                            <div class="input-icon">

                                <i class="fa fa-calendar"></i>

                                <input id="order_date_from" type="text" placeholder="From" name="date_from" class="date-picker form-control form-filter">

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="diskon_ultah" class="col-md-4 control-label"> Periode To </label>

                        <div class="col-md-6">

                            <div class="input-icon">

                                <i class="fa fa-calendar"></i>

                                <input id="order_date_to" type="text" placeholder="To" name="date_to" class="date-picker form-control form-filter">

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label class="col-md-4 control-label"></label>

                        <div class="col-md-6">

                            <button type="submit" class="btn blue">Preview</button>

                        </div>

                    </div>

                </form>
                <!-- ajax -->

                <div id="ajax-modal-full" class="modal container fade" tabindex="-1"> </div>

            </div>

        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>