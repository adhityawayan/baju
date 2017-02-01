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

            <form id="new_customer" class="form-horizontal" action="<?=$link_act?>" method="post" role="form">

                <div class="form-group">

                    <label for="customer_nama" class="col-md-4 control-label">Nama Customer</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <i class="fa fa-user"></i>

                            <input name="name" type="text" class="form-control"> </div>

                    </div>

                </div>



                <div class="form-group">

                    <label for="customer_tanggal_lahir" class="col-md-4 control-label">Tanggal Lahir</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <i class="fa fa-calendar"></i>

                            <input name="born_date" class="form-control date-picker" size="16" type="text">

                        </div>

                    </div>

                </div>



                <div class="form-group">

                    <label for="customer_handphone" class="col-md-4 control-label">Handphone</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <i class="fa fa-mobile"></i>

                            <input name="phone" type="text" class="form-control"> </div>

                    </div>

                </div>



                <div class="form-group">

                    <label for="customer_alamat" class="col-md-4 control-label">Alamat</label>

                    <div class="col-md-8">

                        <div class="input-icon">

                            <i class="fa fa-map-marker"></i>

                            <textarea name="address" class="form-control" id="customer_alamat"></textarea> </div>

                    </div>

                </div>



                <hr>



                <div class="form-group">

                    <div class="col-md-12">

                        <button type="submit" class="pull-right btn blue">Tambah</button>

                    </div>

                </div>



            </form>

        </div>

    </div>

</div>
<script type="text/javascript">

    jQuery(document).ready(function() {

        ComponentsDateTimePickers.init();
    });

</script>
