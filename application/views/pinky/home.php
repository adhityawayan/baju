<!-- BEGIN DASHBOARD STATS 1-->

<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">

            <div class="visual">

                <i class="fa fa-shopping-bag"></i>

            </div>

            <div class="details">

                <div class="number">

                    <span><?=rupiah($trans_today)?></span>

                </div>

                <div class="desc"> Transaksi Hari Ini </div>

            </div>

        </a>

    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

        <a class="dashboard-stat dashboard-stat-v2 red" href="#">

            <div class="visual">

                <i class="fa fa-mail-reply"></i>

            </div>

            <div class="details">

                <div class="number">

                    <span>0</span>

                </div>

                <div class="desc"> Return Hari Ini </div>

            </div>

        </a>

    </div>

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">

            <div class="visual">

                <i class="fa fa-bar-chart-o"></i>

            </div>

            <div class="details">

                <div class="number">

                    <span><?=rupiah($total_all)?></span>

                </div>

                <div class="desc"> Total Pendapatan </div>

            </div>

        </a>

    </div>

</div>

<div class="clearfix"></div>

<!-- END DASHBOARD STATS 1-->

<div class="row">

    <div class="col-md-12 col-sm-12">

        <!-- BEGIN PORTLET-->

        <div class="portlet box red">

            <div class="portlet-title">

                <div class="caption">

                    <i class="icon-share font-red-sunglo hide"></i>

                    <span class="caption-subject bold uppercase">Schedule</span>

                </div>

            </div>

            <div class="portlet-body">
                <div id="calendar"></div>
            </div>

        </div>

        <!-- END PORTLET-->

    </div>

</div>

<div id="invoice" class="modal container fade modal-overflow in" tabindex="-1" aria-hidden="true">

</div>
<input type="hidden" id="urlinvoice" value="<?=site_url('bisnis/appointment/invoice/')?>">
<script>
    var events_array = <?=$dcalendar?>
</script>