<style>
    input[type="checkbox"]{
        width: 30px; /*Desired width*/
        height: 30px; /*Desired height*/
    }
</style>
<div class="row ">
    <?=$this->session->flashdata('pesan')?>
    <div class="col-md-6">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    PROSES DEALING
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" method="post" action="<?=$link_act?>" onsubmit="unmask_number()">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?=$d->customer_id?>">
                    <input type="hidden" id="appointment_id" name="appointment_id" value="<?=$d->id?>">
                    <input type="hidden" id="deal_id" name="id" value="<?=$deal?$deal->id:0?>">
                    <input type="hidden" id="codevoucher" value="<?=$deal?$deal->code_voucher:''?>" name="codevoucher">
                    <input type="hidden" id="discvoucher" value="<?=$deal?$deal->disc_voucher:0?>" name="discvoucher">
                    <input type="hidden" name="promo" id="promodeal" value="<?=$deal?$deal->promo:0?>">
                    <input type="hidden" id="lock_dp" value="<?=$deal?$deal->lock_dp:0?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="<?=$link_back?>" class="btn bold yellow">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Proses</label>
                        <?php foreach(proses() as $key=>$row): ?>
                            <label class="radio-inline">
                                <input type="radio" name="process" class="process-input" value="<?=$key?>" <?=$deal?$deal->process==$key?'checked':'disabled':''?> > <?=$row?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                    <div id="fittingdateform" style="display: none;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Fitting</label>
                            <div class="col-sm-4">
                                <input id="date-fitting" type="text" class="form-control" name="date_fitting" placeholder="Tanggal Fitting" value="<?=$deal?$deal->date_fitting:''?>">
                            </div>
                        </div>
                    </div>
                    <div id="pickupdateform" style="display: none;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Pickup</label>
                            <div class="col-sm-4">
                                <input id="datepickup" type="text" class="form-control" name="date_pickup" placeholder="Tanggal Pickup" value="<?=$deal?$deal->date_borrow:''?>">
                            </div>
                        </div>
                    </div>
                    <div id="rent-form" style="display: none;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Rent / Back</label>
                            <div class="col-sm-4">
                                <input id="daterent" type="text" class="form-control" name="date_borrow" placeholder="Tanggal Pinjam" value="<?=$deal?$deal->date_borrow:''?>">
                            </div>
                            <div class="col-sm-4">
                                <input id="dateback" type="text" class="form-control" name="date_back" placeholder="Tanggal Kembali" value="<?=$deal?$deal->date_back:''?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Note</label>
                        <div class="col-sm-8">
                            <textarea name="note" class="form-control" rows="4" placeholder="Keterangan Deal"><?=$deal?$deal->note:''?></textarea>
                        </div>
                    </div>
                    <div id="form-deposit" style="display: none;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Deposit</label>
                            <div class="col-sm-4">
                                <input id="deposit" type="text" placeholder="Jumlah Deposit" class="form-control" name="deposit" value="<?=$deal?$deal->deposit:''?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Shipping</label>
                        <?php foreach(shipping() as $key=>$row): ?>
                            <label class="radio-inline">
                                <input type="radio" id="shipping" onclick="disabled_address(this.value)" name="shipping" <?=$deal?$deal->shipping==$key?'checked':'':''?> value="<?=$key?>" <?=$deal?$deal->shipping==$key?'checked':'':''?>> <?=$row?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Shipping Address</label>
                        <div class="col-sm-8">
                            <textarea class="form-control shipping_address" name="shipping_address"><?=$deal?$deal->shipping_address:''?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Shipping Cost</label>
                        <div class="col-sm-4">
                            <input type="text" id="shipping_cost" class="form-control shipping_cost" name="shipping_cost" value="<?=$deal?$deal->shipping_cost:''?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Total</label>
                        <div class="col-sm-4">
                            <input type="text" id="dtotal" class="form-control" name="total" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Down Payment</label>
                        <div class="col-sm-4">
                            <input type="text" id="down_payment" class="form-control" name="down_payment" value="<?=$deal?$deal->down_payment:''?>" required <?=$deal?$deal->lock_dp==1?'disabled':'':''?>>
                            <p style="padding-top: 5px;" class="help-block"><button type="button" id="lockdp" class="btn btn-success"><span class="glyphicon glyphicon-lock"></span> Lock</button></p>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control date-picker" name="date_dp" value="<?=$deal?$deal->date_dp:date('Y-m-d')?>">
                        </div>
                        <div class="col-sm-3">
                            <select name="pay_dp" class="form-control" style="width: 70px;">
                                <?php foreach(pay() as $key=>$row): ?>
                                    <option value="<?=$key?>" <?=$deal?$deal->pay_dp==$key?'selected':'':''?> ><?=$row?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Remaining Payment</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="remaining_payment" name="remaining_payment" value="<?=$deal?$deal->remaining_payment:''?>" required>
                            <p class="help-block" id="label-remaining"></p>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control date-picker" name="date_rp" value="<?=$deal?$deal->date_rp:date('Y-m-d')?>">
                        </div>
                        <div class="col-sm-3">
                            <select name="pay_rp" class="form-control" style="width: 70px;">
                                <?php foreach(pay() as $key=>$row): ?>
                                    <option value="<?=$key?>" <?=$deal?$deal->pay_rp==$key?'selected':'':''?> ><?=$row?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
    <div class="col-md-6">
<!--        <div class="portlet box red">-->
<!--            <div class="portlet-title">-->
<!--                <div class="caption font-dark">-->
<!--                    Deposit Transaksi-->
<!--                </div>-->
<!--                <div class="tools"></div>-->
<!--            </div>-->
<!--            <div class="portlet-body">-->
<!--                <div id="deposit-form">-->
<!--                    <div class="form-horizontal">-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-xs-6">-->
<!--                                <input type="number" id="deposit" class="form-control" name="deposit">-->
<!--                                <p class="help-block" id="label-deposit"></p>-->
<!--                            </div>-->
<!--                            <div class="col-xs-1">-->
<!--                                <button class="btn btn-info btn-adddeposit"><i class="fa fa-plus"></i></button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="list-deposit"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                   <span>PROMO</span>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <div id="promo-form" style="display: none;">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-10">
                                <select class="form-control select2" id="promo_id" name="promo_id" onchange="promo_form_btn(this.value)">
                                    <option value="0">Pilih Promo</option>
                                    <?php foreach($promo as $row): ?>
                                        <option value="<?=$row->id?>"><?=$row->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <button disabled class="btn btn-info btn-addpromo"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-promo"></div>
                </div>
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    PRODUCT
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <div id="baju-form" style="display: none">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-10">
                                <select class="form-control select2" id="baju_id" name="baju_id" onchange="baju_form_btn(this.value)">
                                    <option value="0">Pilih Baju</option>
                                    <?php foreach($baju as $row): ?>
                                        <option value="<?=$row->id?>"><?=$row->name?> - <?=$row->colour?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <button disabled class="btn btn-info btn-addbaju"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-baju"></div>
                    <hr>
                </div>
                <div id="baju-form-sale" style="display: none">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-10">
                                <select class="form-control select2" id="baju_id_sale" name="baju_id_sale" onchange="baju_formsale_btn(this.value)">
                                    <option value="0">Pilih Baju</option>
                                    <?php foreach($baju as $row): ?>
                                        <option value="<?=$row->id?>"><?=$row->name?> - <?=$row->colour?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <button disabled class="btn btn-info btn-addbaju-sale"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-baju-sale"></div>
                    <hr>
                </div>
                <div id="accessories-form" style="display: none">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-10">
                                <select class="form-control select2" id="accessories_id" name="accessories_id" onchange="accessories_form_btn(this.value)">
                                    <option value="0">Pilih Acessories</option>
                                    <?php foreach($accessories as $row): ?>
                                        <option value="<?=$row->id?>"><?=$row->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <button disabled class="btn btn-info btn-addacc"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-accessories"></div>
                    <hr>
                </div>
                <div id="jobs-form" style="display: none">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-5">
                                <textarea id="text-jobs" class="form-control" placeholder="Jobs.."></textarea>
                            </div>
                            <div class="col-xs-4">
                                <input type="text" placeholder="Harga" class="form-control" id="price-jobs" onkeyup="job_form_btn(this.value)">
                            </div>
                            <div class="col-xs-1">
                                <button disabled class="btn btn-info btn-addjobs"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-jobs"></div>
                    <hr>
                </div>
                <div id="made-form" style="display: none">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-5">
                                <input type="text" id="text-disc" class="form-control" placeholder="Diskripsi ..">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Harga.." class="form-control" id="price-made" onkeyup="made_form_btn(this.value)">
                            </div>
                            <div class="col-sm-1">
                                <button disabled class="btn btn-info btn-addmade"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="list-made"></div>
                    <hr>
                </div>
                <div id="maderent-form" style="display: none">
                    <div class="form-horizontal">
                        <button type="button" class="btn btn-primary btn-lg btn-block btn-addform-baju"><span class="glyphicon glyphicon-plus"></span> Made For Rent</button>
                    </div>
                    <div id="list-madeforrent"></div>
                    <hr>
                </div>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Kode Voucher</label>
                        <div class="col-sm-5">
                            <input type="text" id="text-voucher" class="form-control" placeholder="Kode Voucher.." value="<?=$deal?$deal->code_voucher:''?>" onkeyup="kode_voucher_btn(this.value)">
                            <p id="help-voucher" class="help-block">Validasi kode</p>
                            <input type="hidden" id="nilai-disc">
                        </div>
                        <div class="col-xs-1">
                            <button disabled class="btn btn-info btn-addvoucher"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <h2>Total : <span id="ptotal"></span></h2>
                <h2>Down Payment : <span id="ptotaldp"></span></h2>
            </div>
        </div>
    </div>
</div>

<div id="loading" class="modal fade modal-overflow in" tabindex="-1" aria-hidden="true">
    <p>Loading....... </p>
</div>

<div id="promoform" class="modal fade modal-overflow in" tabindex="-1" aria-hidden="true">
    <div class="modal-body" id="form-promo">

    </div>
</div>

<div id="itemform" class="modal fade modal-overflow in" tabindex="-1" aria-hidden="true">
    <div class="modal-body" id="form-item">

    </div>
</div>

<div id="form-made" class="modal container fade modal-overflow in" tabindex="-1" aria-hidden="true">
    <div id="form-madecontent">

    </div>
</div>

<input type="hidden" id="urlbaju" value="<?=$link_baju?>">
<input type="hidden" id="urlbajumaderent" value="<?=$link_bajumaderent?>">
<input type="hidden" id="urlbajusale" value="<?=$link_bajusale?>">
<input type="hidden" id="urladdbaju" value="<?=$link_addbaju?>">
<input type="hidden" id="urladdbajusale" value="<?=$link_addbajusale?>">
<input type="hidden" id="urldelallbaju" value="<?=$link_del_allitem?>">
<input type="hidden" id="urldelidbaju" value="<?=$link_del_iditem?>">
<input type="hidden" id="urldelidbajuformaster" value="<?=$link_del_iditemformaster?>">

<input type="hidden" id="urlaccessories" value="<?=$link_accessories?>">
<input type="hidden" id="urladdaccessories" value="<?=$link_addaccessories?>">
<input type="hidden" id="urldelallaccessories" value="<?=$link_del_allaccessories?>">
<input type="hidden" id="urldelidaccessories" value="<?=$link_del_idaccessories?>">

<input type="hidden" id="urljobs" value="<?=$link_jobs?>">
<input type="hidden" id="urladdjobs" value="<?=$link_addjobs?>">
<input type="hidden" id="urldelalljobs" value="<?=$link_del_alljobs?>">
<input type="hidden" id="urldelidjobs" value="<?=$link_del_idjobs?>">

<input type="hidden" id="urldeposit" value="<?=$link_deposit?>">
<input type="hidden" id="urladddeposit" value="<?=$link_adddeposit?>">
<input type="hidden" id="urldelalldeposit" value="<?=$link_del_alldeposit?>">
<input type="hidden" id="urldeliddeposit" value="<?=$link_del_iddeposit?>">

<input type="hidden" id="urlmade" value="<?=$link_made?>">
<input type="hidden" id="urladdmade" value="<?=$link_addmade?>">
<input type="hidden" id="urldelallmade" value="<?=$link_del_allmade?>">
<input type="hidden" id="urldelidmade" value="<?=$link_del_idmade?>">

<input type="hidden" id="urlpromo" value="<?=$link_promo?>">
<input type="hidden" id="urladdpromo" value="<?=$link_addpromo?>">
<input type="hidden" id="urldelallpromo" value="<?=$link_del_allpromo?>">
<input type="hidden" id="urldelidpromo" value="<?=$link_del_idpromo?>">

<input type="hidden" id="urlformtrpromo" value="<?=$link_formtrpromo?>">
<input type="hidden" id="urlupdatetrpromo" value="<?=$link_updatetrpromo?>">

<input type="hidden" id="urlformtritem" value="<?=$link_formtritem?>">
<input type="hidden" id="urlupdatetritem" value="<?=$link_updatetritem?>">

<input type="hidden" id="urlformtritemsale" value="<?=$link_formtritemsale?>">
<input type="hidden" id="urlupdatetritemsale" value="<?=$link_updatetritemsale?>">

<input type="hidden" id="urlmadeforrent" value="<?=$link_madeforrentact?>">

<input type="hidden" id="urlformmadesale" value="<?=$link_formmadesale?>">

<input type="hidden" id="urlvoucher" value="<?=$link_urlvoucher?>">

<input type="hidden" id="urltotaltransaksi" value="<?=$link_total_transaksi?>">
<input type="hidden" id="urlinvoice" value="<?=$link_invoice?>">

<input type="hidden" id="urllockdp" value="<?=$link_lockdp?>">

<script src="<?php echo base_url('assets/pinky/global/scripts/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/pinky/global/scripts/jquery.price_format.2.0.min.js') ?>"></script>

<script type="text/javascript">

    var rupiah ={prefix: 'Rp. ', thousandsSeparator: '.', centsLimit: 0};

    function mask_number()
    {
        $('#deposit,#remaining_payment,#shipping_cost,#dtotal,#down_payment,#price-jobs,#price-made,#depositff,#despoitpromo').priceFormat(rupiah);
    }

    function unmask_number()
    {
        $('#deposit').val($('#deposit').unmask());
        $('#remaining_payment').val($('#remaining_payment').unmask());
        $('#shipping_cost').val($('#shipping_cost').unmask());
        $('#dtotal').val($('#dtotal').unmask());
        $('#down_payment').val($('#down_payment').unmask());
        $('#down_payment').removeAttr('disabled');

    }

    Date.prototype.yyyymmdd = function() {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear(),
            (mm>9 ? '-' : '0') + mm,
            (dd>9 ? '-' : '0') + dd
        ].join('');
    };

    var date = new Date();

    function toRp(a,b,c,d,e){e=function(f){return f.split('').reverse().join('')};b=e(parseInt(a,10).toString());for(c=0,d='';c<b.length;c++){d+=b[c];if((c+1)%3===0&&c!==(b.length-1)){d+='.';}}return'Rp.\t'+e(d)+',00'}
    function toAngka(rp){return parseInt(rp.replace(/,.*|\D/g,''),10)}

    function rent()
    {
        $("#baju-form,#accessories-form,#jobs-form,#promo-form").show();
        $('#made-form,#baju-form-sale,#rent-form,#fittingdateform,#form-deposit,#pickupdateform,#maderent-form').hide();
        $('#promo-check').attr("checked", true);
        $('.select2').select2();
    }

    function madeforRent()
    {
        $('#baju-form,#accessories-form,#jobs-form,#baju-form-sale,#promo-form,#pickupdateform,#made-form,#rent-form,#fittingdateform,#form-deposit').hide();
        $("#maderent-form").show();
        $('.select2').select2();
        $('#promo-check').attr("checked", false);
    }

    function madeforSale()
    {
        $("#baju-form,#accessories-form,#jobs-form,#rent-form,#baju-form-sale,#promo-form,#maderent-form").hide();
        $('#fittingdateform,#form-deposit,#pickupdateform,#made-form').show();
        $('#promo-check').attr("checked", false);
        $('.select2').select2();
    }

    function sale()
    {
        $('#baju-form-sale, #jobs-form').show();
        $("#made-form,#accessories-form,#rent-form,#baju-form,#promo-form,#fittingdateform,#form-deposit,#maderent-form").hide();
        $('#promo-check').attr("checked", false);
        $('.select2').select2();
    }

    function disabled_address(val)
    {
        if(val==2)
        {
            $('.shipping_address, .shipping_cost').removeAttr('disabled');
        }
        else
        {
            $('.shipping_address,.shipping_cost').attr('disabled','disabled');
        }
    }

    /*Function Disable*/
    function promo_form_btn(val)
    {
        if(val!='0')
        {
            $('.btn-addpromo').removeAttr('disabled');
        }
        else
        {
            $('.btn-addpromo').attr('disabled','disabled');
        }
    }

    function baju_form_btn(val)
    {
        if(val!='0')
        {
            $('.btn-addbaju').removeAttr('disabled');
        }
        else
        {
            $('.btn-addbaju').attr('disabled','disabled');
        }
    }

    function baju_formsale_btn(val)
    {
        if(val!='0')
        {
            $('.btn-addbaju-sale').removeAttr('disabled');
        }
        else
        {
            $('.btn-addbaju-sale').attr('disabled','disabled');
        }

    }

    function accessories_form_btn(val)
    {
        if(val!='0')
        {
            $('.btn-addacc').removeAttr('disabled');
        }
        else
        {
            $('.btn-addacc').attr('disabled','disabled');
        }
    }

    function job_form_btn(val)
    {
        if(val!='')
        {
            $('.btn-addjobs').removeAttr('disabled');
        }
        else
        {
            $('.btn-addjobs').attr('disabled','disabled');
        }
    }

    function made_form_btn(val)
    {
        if(val!='')
        {
            $('.btn-addmade').removeAttr('disabled');
        }
        else
        {
            $('.btn-addmade').attr('disabled','disabled');
        }

    }

    function kode_voucher_btn(val)
    {
        if(val!='')
        {
            $('.btn-addvoucher').removeAttr('disabled');
        }
        else
        {
            $('.btn-addvoucher').attr('disabled','disabled');
        }
    }

    jQuery(document).ready(function() {

        $( "#date-fitting" ).datepicker({
            format :	'yyyy-mm-dd',
            autoclose : true,
            startDate: date.yyyymmdd(),
        }).on('changeDate', function(e) {
            $('#daterent,#datepickup').datepicker({
                format :	'yyyy-mm-dd',
                autoclose : true,
                startDate: $("#date-fitting").val(),
            }).on('changeDate', function(e){
                $('#dateback').datepicker({
                    format :	'yyyy-mm-dd',
                    autoclose : true,
                    startDate: $("#daterent").val(),
                });
            });
        });

        console.log('tes '+$('input:radio:checked').val());
        if($('input:radio:checked').val()==1)
        {
            rent();
        }
        else if($('input:radio:checked').val()==2)
        {
            madeforRent();
        }
        else if($('input:radio:checked').val()==3)
        {
            madeforSale();
        }
        else if($('input:radio:checked').val()==4)
        {
            sale();
        }

        baju();
        bajumadeforrent();
        bajusale();
        accessories();
        jobs();
        made();
        promo();
        voucher();
        deposit();
        totaltransaksi();

        var bajuform = $('#baju-form');
        var accessoriesform = $('#accessories-form');
        var jobsform = $('jobs-form');
        var madeform = $('made-form');
        var processInput = $('.process-input');

//        ComponentsDateTimePickers.init();

        disabled_address(<?=$deal?$deal->shipping:'1'?>);

        $('.btn-addbaju').click(function(){
            addbaju();
            baju();
            totaltransaksi();
        });
        $('.btn-addbaju-sale').click(function(){
            addbajusale();
            bajusale();
            totaltransaksi();
        });
        $('.btn-addacc').click(function(){
            addaccessories();
            accessories();
            totaltransaksi();
        });
        $('.btn-addjobs').click(function(){
            addjobs();
            jobs();
            totaltransaksi();
        });
        $('.btn-adddeposit').click(function(){
            adddeposit();
            deposit();
//            totaltransaksi();
        });
        $('.btn-addmade').click(function(){
            addmade();
            made();
            totaltransaksi();
        });

        $('.btn-addpromo').click(function(){
            addpromo();
            promo();
        });

        $('.btn-addvoucher').click(function(){
            totaltransaksi();
        });

        $('.btn-addform-baju').click(function(){
            formmadebaju();
            bajumadeforrent();
            totaltransaksi();
        });
        $('#lockdp').click(function(){
            $('#down_payment').attr('disabled','true');
            lockdp();
        });

        $('#text-voucher').keyup(function()
        {
            if(this.value != '')
            {
                voucher();
            }
            else
            {
                $('#help-voucher').html('Validasi Kode');
            }
        });

        $('#promo-check').change(function()
        {
            if($(this).is(":checked")) {
                $(this).attr("checked", true);
                $('#promodeal').val(1);
            }
            else
            {
                $('#promodeal').val(0);
                $('#promo-form').hide();
            }
//            $('#textbox1').val($(this).is(':checked'));
            console.log($(this).is(':checked'));
        });

        $('.process-input').click(function(){
           var process = this.value;
            if(process==1)
            {
                rent();
            }
            else if(process==2)
            {
                madeforRent();
            }
            else if(process==3)
            {
                madeforSale();
            }
            if(process==4)
            {
                sale();
            }
        });

        $('#down_payment').keyup(function(){
            var dtotal = $('#dtotal').val();
            var dp = this.value;
            var hasil = Number(dtotal - dp).toFixed();
            $('#remaining_payment').val(hasil);
            $('#label-dp').html(toRp(this.value));
            $('#label-remaining').html(toRp(hasil));
        });

        $('#shipping_cost').keyup(function(){
            totaltransaksi();
            $('#down_payment').val('');
            $('#remaining_payment').val('');
        });

        $('#deposit').keyup(function(){
            $('#label-deposit').html(toRp(this.value));
        });

        $('.previews').click(function(){
            var urlinvoice = $('#urlinvoice').val();
            var appointment_id = $('#appointment_id').val();
            $.ajax({
                beforeSend:function(){
                    $("#loading").modal('show');
                },
                url: urlinvoice+'/'+appointment_id,
                type : 'get',
                cache: false,
            })
                .success(function(data) {
                    $('#invoice').html(data);
                    $("#loading").modal('hide');
                    $('#invoice').modal('show');
                });
        });

    });

    function voucher()
    {
        var urlvoucher = $('#urlvoucher').val();
        var textvoucher = $('#text-voucher').val();

        $.ajax({
            url: urlvoucher+'/'+textvoucher,
            type : 'get',
            cache: false,
            dataType : 'JSON',
        })
            .success(function(data) {
                $('#help-voucher').html('Potongan Sebesar '+toRp(data.disc));
                $('#nilai-disc').val(data.disc);
                $('#codevoucher').val(data.code);
                $('#discvoucher').val(data.disc);
                console.log(data.disc);
            });
    }

    function baju()
    {
        var urlbaju = $('#urlbaju').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlbaju+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-baju').html(data);
                $("#loading").modal('hide');
            });
    }

    function bajusale()
    {
        var urlbaju = $('#urlbajusale').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlbaju+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-baju-sale').html(data);
                $("#loading").modal('hide');
            });
    }

    function bajumadeforrent()
    {
        var urlbaju = $('#urlbajumaderent').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlbaju+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-madeforrent').html(data);
                $("#loading").modal('hide');
            });
    }

    function accessories()
    {
        var urlaccessories = $('#urlaccessories').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlaccessories+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-accessories').html(data);
                $("#loading").modal('hide');
            });
    }

    function jobs()
    {
        var urljobs = $('#urljobs').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urljobs+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-jobs').html(data);
                $("#loading").modal('hide');
            });
    }

    function deposit()
    {
        var urldeposit = $('#urldeposit').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urldeposit+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-deposit').html(data);
                $("#loading").modal('hide');
            });
    }

    function made()
    {
        var urlmade = $('#urlmade').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlmade+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-made').html(data);
                $("#loading").modal('hide');
            });
    }

    function promo()
    {
        var urlpromo = $('#urlpromo').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: urlpromo+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function(data) {
                $('#list-promo').html(data);
                $("#loading").modal('hide');
            });
    }

    function addbaju()
    {
        var baju_id = $('#baju_id').val();
        var appointment_id = $('#appointment_id').val();
        var customer_id = $('#customer_id').val();
        var urladdbaju = $('#urladdbaju').val();

        $.ajax({
            url: urladdbaju,
            type : 'post',
            data : {baju_id:baju_id,appointment_id:appointment_id,customer_id:customer_id},
            cache: false,
        })
            .success(function(data) {
                formtritem(data);
            });
    }

    function addbajusale()
    {
        var baju_id = $('#baju_id_sale').val();
        var appointment_id = $('#appointment_id').val();
        var customer_id = $('#customer_id').val();
        var urladdbajusale = $('#urladdbajusale').val();

        $.ajax({
            url: urladdbajusale,
            type : 'post',
            data : {baju_id:baju_id,appointment_id:appointment_id,customer_id:customer_id},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function addaccessories()
    {
        var accessories_id = $('#accessories_id').val();
        var appointment_id = $('#appointment_id').val();
        var customer_id = $('#customer_id').val();
        var urladdaccessories = $('#urladdaccessories').val();

        $.ajax({
            url: urladdaccessories,
            type : 'post',
            data : {accessories_id:accessories_id,appointment_id:appointment_id,customer_id:customer_id},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function addjobs()
    {
        var appointment_id = $('#appointment_id').val();
        var job = $('#text-jobs').val();
        var price = $('#price-jobs').unmask();
        var urladdjobs = $('#urladdjobs').val();

        $.ajax({
            url: urladdjobs,
            type : 'post',
            data : {job:job,appointment_id:appointment_id,price:price},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function adddeposit()
    {
        var appointment_id = $('#appointment_id').val();
        var deposit = $('#deposit').val();
        var urladddeposit = $('#urladddeposit').val();

        $.ajax({
            url: urladddeposit,
            type : 'post',
            data : {deposit:deposit,appointment_id:appointment_id},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function addmade()
    {
        var appointment_id = $('#appointment_id').val();
        var disc = $('#text-disc').val();
        var price = $('#price-made').unmask();
        var urladdmade = $('#urladdmade').val();

        $.ajax({
            url: urladdmade,
            type : 'post',
            data : {disc:disc,appointment_id:appointment_id,price:price},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function addpromo()
    {
        var appointment_id = $('#appointment_id').val();
        var promo_id = $('#promo_id').val();
        var customer_id = $('#customer_id').val();
        var urladdpromo = $('#urladdpromo').val();

        $.ajax({
            url: urladdpromo,
            type : 'post',
            data : {promo_id:promo_id,appointment_id:appointment_id,customer_id:customer_id},
            cache: false,
        })
            .success(function() {
                console.log('success');
            });
    }

    function delall()
    {
        var urldelallbaju = $('#urldelallbaju').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            url: urldelallbaju+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                baju();
                bajusale();
                totaltransaksi();
            });
    }

    function delallacc()
    {
        var urldelallaccessories = $('#urldelallaccessories').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            url: urldelallaccessories+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                accessories();
                totaltransaksi();
            });
    }

    function delalljobs()
    {
        var urldelalljobs = $('#urldelalljobs').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            url: urldelalljobs+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                jobs();
                totaltransaksi();
            });
    }

    function delalldeposit()
    {
        var urldelalldeposit = $('#urldelalldeposit').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            url: urldelalldeposit+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                deposit();
            });
    }

    function delallmade()
    {
        var urldelallmade = $('#urldelallmade').val();
        var appointment_id = $('#appointment_id').val();
        $.ajax({
            url: urldelallmade+'/'+appointment_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                made();
                totaltransaksi();
            });
    }

    function delperid(id)
    {
        var urldelidbaju = $('#urldelidbaju').val();
        $.ajax({
            url: urldelidbaju+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                baju();
                bajusale();
                totaltransaksi();
            });
    }

    function delperidformaster(id)
    {
        var urldelidbaju = $('#urldelidbajuformaster').val();
        $.ajax({
            url: urldelidbaju+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                bajumadeforrent();
                totaltransaksi();
            });
    }

    function delperidacc(id)
    {
        var urldelidaccessories = $('#urldelidaccessories').val();
        $.ajax({
            url: urldelidaccessories+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                accessories();
                totaltransaksi();
            });
    }

    function delperidjobs(id)
    {
        var urldelidjobs = $('#urldelidjobs').val();
        $.ajax({
            url: urldelidjobs+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                jobs();
                totaltransaksi();
            });
    }

    function delperiddeposit(id)
    {
        var urldeliddeposit = $('#urldeliddeposit').val();
        $.ajax({
            url: urldeliddeposit+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                deposit();
//                totaltransaksi();
            });
    }

    function delperidmade(id)
    {
        var urldelidmade = $('#urldelidmade').val();
        $.ajax({
            url: urldelidmade+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                made();
                totaltransaksi();
            });
    }

    function delperidpromo(id)
    {
        var urldelidpromo = $('#urldelidpromo').val();
        $.ajax({
            url: urldelidpromo+'/'+id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                console.log('success');
                promo();
                totaltransaksi();
            });
    }

    function totaltransaksi()
    {
        var urltotaltransaksi = $('#urltotaltransaksi').val();
        var appointment_id = $('#appointment_id').val();
        var shipping_cost = $('#shipping_cost').val();
        var voucher_disc = $('#discvoucher').val();

        $.ajax({
            url: urltotaltransaksi,
            type : 'post',
            data : {appointment_id:appointment_id,shipping_cost:shipping_cost,disc_voucher:voucher_disc},
            cache: false,
            dataType: "json"
        })
            .success(function(data) {
                $('#dtotal').val(data.total);
                $('#down_payment').val(data.dp);
                $('#ptotal').html(data.labeltotal);
                $('#ptotaldp').html(data.labeldp);
            })
            .done(function(){
                calculate();
                mask_number();
            });

    }

    function calculate()
    {
        var total = $('#dtotal').val();
        var dp = $('#down_payment').val();
        console.log('ini dp nya'+dp);
        var hasil = Number(total - dp).toFixed();
        console.log(hasil);
        $('#remaining_payment').val(hasil);
    }

    function formtrpromo(id)
    {
        var urlform = $('#urlformtrpromo').val();
        $.ajax({
            url: urlform+'/'+id,
            type : 'get',
            cache: false,
            dataType: "html"
        })
            .success(function(data) {
                $('#form-promo').html(data);
                $('#promoform').modal('show');
                mask_number();
            });
    }

    function updatetrpromo()
    {
        var urlupdate = $('#urlupdatetrpromo').val();
        var data = $('#formpromo').serializeArray();
        var deposit = $('#despoitpromo').unmask();
        data.push({
            name:"deposit",
            value: deposit
        });
//        console.log(data);

        $.ajax({
            url: urlupdate,
            type : 'post',
            cache: false,
            data: data
        })
            .success(function(data) {
                $('#promoform').modal('hide');
                promo();
                totaltransaksi();
            });
    }

    function formtritem(id)
    {
        var urlform = $('#urlformtritem').val();
        $.ajax({
            url: urlform+'/'+id,
            type : 'get',
            cache: false,
            dataType: "html"
        })
            .success(function(data) {
                $('#form-item').html(data);
                $('#itemform').modal('show');
                mask_number();
            });
    }

    function formtritemsale(id)
    {
        var urlform = $('#urlformtritemsale').val();
        $.ajax({
            url: urlform+'/'+id,
            type : 'get',
            cache: false,
            dataType: "html"
        })
            .success(function(data) {
                $('#form-item').html(data);
                $('#itemform').modal('show');
            });
    }

    function updatetritem()
    {
        var urlupdate = $('#urlupdatetritem').val();
        var data = $('#formitem').serializeArray();
        var depositff = $('#depositff').unmask();
        data.push({
            name:"deposit",
            value: depositff
        });

        $.ajax({
            url: urlupdate,
            type : 'post',
            cache: false,
            data: data
        })
            .success(function(data) {
                $('#itemform').modal('hide');
            });
    }

    function updatetritemsale()
    {
        var urlupdate = $('#urlupdatetritemsale').val();
        var data = $('#formitemsale').serializeArray();

        $.ajax({
            url: urlupdate,
            type : 'post',
            cache: false,
            data: data
        })
            .success(function(data) {
                $('#itemform').modal('hide');
            });
    }

    function formmadebaju()
    {
        var urlform = $('#urlformmadesale').val();
        var id = $('#appointment_id').val();

        $.ajax({
            url: urlform+'/'+id,
            type : 'get',
            cache: false,
            dataType: "html"
        })
            .success(function(data) {
                $('#form-madecontent').html(data);
                $('#form-made').modal('show');
            });
    }

    function bajumaderent()
    {
        var urlupdate = $('#urlmadeforrent').val();
        var data = $('#formmaderent').serializeArray();
        console.log(data);
//        alert('deye');

        $.ajax({
            url: urlupdate,
            type : 'post',
            cache: false,
            data: data
        })
            .success(function(data) {
                $('#form-made').modal('hide');
                console.log(data);
                formtritem(data);
                bajumadeforrent();
                totaltransaksi();
            });
    }

    function lockdp()
    {
        var url = $('#urllockdp').val();
        var deal_id = $('#deal_id').val();

        $.ajax({
            beforeSend:function(){
                $("#loading").modal('show');
            },
            url: url+deal_id,
            type : 'get',
            cache: false,
        })
            .success(function() {
                totaltransaksi();
                $("#loading").modal('hide');
            });
    }

</script>