var FormWizard = function () {

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var form    = $('#submit_form');
            var error   = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: false, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {

                    transaksi_customer: {
                        required: true
                    },

                    transaksi_tanggal_masuk: {
                        required: true
                    },

                    transaksi_tanggal_selesai: {
                        required: true
                    },

                    transaksi_tipe_pembayaran: {
                        required: true
                    },
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "transaksi_customer") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#customer_error");
                    } else if (element.attr("name") == "transaksi_tipe_pembayaran") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#transaksi_tipe_pembayaran_error");
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                    .addClass('valid') // mark the current input as valid and display OK icon
                    .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                },

                submitHandler: function (form) {
                    // success.show();
                    error.hide();
                    form[0].submit();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }
            });

            var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        if ($(this).attr("data-display") == 'transaksi_dp') {
                            if (input.val() == null || input.val() == '') {
                                $(this).html('-');
                            } else {
                                $(this).html(toRp(input.val()));
                            }
                        } else {
                            $(this).html(input.val());
                        }
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'item-display') {
                        var payment = [];
                        $('[class="m_tipe_id"]:checked', form).each(function(i){

                            var $num      = i+1;
                            var $open_tr  = '<tr>';
                            var $no       = '<td class="text-center">'+ $num +'</td>';
                            var $item     = '<td>' + $(this).data( "title" ) + '</td>';
                            var $qty      = '<td class="text-center">' + $(this).siblings('.qty-hide').find('input.transaksi_quantity').val() + '</td>';
                            var $total    = '<td>' + $(this).siblings('.qty-hide').find('input.transaksi_harga').val() + '</td>';
                            var $catatan  = '<td>' + $(this).siblings('.qty-hide').find('.transaksi_catatan').val() + '</td>';
                            var $clode_tr = '</tr>';

                            payment.push($open_tr);
                            payment.push($no);
                            payment.push($item);
                            payment.push($qty);
                            payment.push($catatan);
                            payment.push($total);
                            payment.push($clode_tr);

                        });

                        $(this).html(payment.join(''));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1').find('.button-submit').hide();
            // $('#form_wizard_1 .button-submit').click(function () {
            //     alert('Finished! Hope you like it :)');
            // }).hide();


            /* ============================================================================ */

            /* Info */
            $('.transaksi_customer').bind('change', function() {
                $.ajax({
                    url: $base_url + 'transaksi/customer/'+ $(".transaksi_customer").val(), 
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(i,item){
                            if (item.field == 'customer_card') {
                                $('#customer_card').val(item.value);
                            } else if (item.field == 'customer_tanggal_lahir') {
                                $('#customer_tanggal_lahir').val(item.value);
                            } else if (item.field == 'customer_handphone') {
                                $('#customer_handphone').val(item.value);
                            } else if (item.field == 'customer_alamat') {
                                $('#customer_alamat').val(item.value);

                            } else if (item.field == 'diskon_tipe') {
                                $('#diskon_tipe').html(item.value);
                                $('.transaksi_diskon_tipe').val(item.value);
                            } else if (item.field == 'diskon_persen') {
                                $('.transaksi_diskon_persen').val(item.value);
                            } else if (item.field == 'diskon_persen_view') {
                                $('#diskon_persen_view').html(item.value);

                            } else {
                                $('#customer_card').val('');
                                $('#customer_tanggal_lahir').val('');
                                $('#customer_handphone').val('');
                                $('#customer_alamat').val('');

                                $('#diskon_tipe').html('');
                                $('.transaksi_diskon_tipe').val('');
                                $('.transaksi_diskon_persen').val('');
                                $('#diskon_persen_view').html('');
                            }
                        });
                    }
                });
            });

            /* Jenis Item */
            $('.m_tipe_id').removeAttr('checked');
            $('.m_tipe_id').siblings('.qty-hide').slideUp();
            $('.transaksi_quantity').val('');
            $('.transaksi_harga').val('');

            $('.m_tipe_id_label').each(function(){
                var $m_tipe_id_label    = $(this);
                var $m_tipe_id          = $(this).find('.m_tipe_id');
                var $transaksi_quantity = $(this).find('.transaksi_quantity');
                var $id                 = $('.transaksi_category').val();
                var $tipe               = $m_tipe_id_label.data('id');
                $m_tipe_id.removeAttr('checked');
                $transaksi_quantity.val('');
            });

            $('.m_tipe_id').on('click', function() {
                $parent_box = $(this).siblings('.qty-hide');
                $parent_box.slideToggle(100);
                $(this).each(function() {
                    if ($(this).is(':checked')) {
                    } else {
                        $(this).siblings('.qty-hide').find('.transaksi_quantity').val('');
                        $(this).siblings('.qty-hide').find('.transaksi_harga').val('');
                        $(this).siblings('.qty-hide').find('.transaksi_catatan').val('');
                    }
                });
            });

            if ($('.transaksi_total') == null) {
                $('.transaksi_total_view').val('');
            }

            $('.transaksi_quantity').bind('change', function() {
                var $parent_form  = $(this).parents('.form-group');
                var $val_qty      = $(this).val();
                var $val_price    = $parent_form.siblings('.form-group').find('.transaksi_harga').data('val');
                
                $val_qty_price    = $val_qty * $val_price;
                $val_qty_price_rp = toRp($val_qty_price);

                $parent_form.siblings('.form-group').find('.transaksi_harga').val($val_qty_price_rp);
                $parent_form.siblings('.form-group').find('.transaksi_harga').attr('data-val', $val_qty_price);
    
                transaksi_total();
            });

            /* Pembayaran */
            $('.transaksi_kartu_debit, .transaksi_kartu_kredit, .transaksi_tipe_cash, .transaksi_pengambilan').on('click', function() {
                
                var dp_sibling            = $(this).parent().siblings('.transaksi_tipe_w');
                var dp_sibling_form_group = dp_sibling.find('.form-group');
                var dp_sibling_hr         = dp_sibling.find('hr');
                var dp_sibling_input      = dp_sibling_form_group.find('.transaksi_dp');
                
                dp_sibling_form_group.hide();
                dp_sibling_hr.hide();
                dp_sibling_input.val('');

                var $transaksi_total      = $('body').find('#transaksi_total');
                var $transaksi_total_view = $('body').find('.transaksi_total_view');

                var $transaksi_subtotal   = $('body').find('.transaksi_subtotal').val();
                var $transaksi_diskon     = $('body').find('.transaksi_diskon').val();

                var $transaksi_total_update =  ($transaksi_subtotal-$transaksi_diskon)-dp_sibling_input.val();


                $transaksi_total.val($transaksi_total_update);
                $transaksi_total_view.val(toRp($transaksi_total_update));

            });

            $('.transaksi_tipe_dp').siblings('.form-group').hide();
            $('.transaksi_tipe_dp').siblings('hr').hide();
            $('.transaksi_tipe_dp').on('click', function() {
                var form_group         = $(this).siblings('.form-group');
                var hr                 = $(this).siblings('hr');

                form_group.show();
                hr.show();
            });

            $('.transaksi_dp').bind('change', function() {
                var $transaksi_total      = $('body').find('#transaksi_total');
                var $transaksi_total_view = $('body').find('.transaksi_total_view');

                var $transaksi_subtotal   = $('body').find('.transaksi_subtotal').val();
                var $transaksi_diskon     = $('body').find('.transaksi_diskon').val();

                var $transaksi_total_update =  ($transaksi_subtotal-$transaksi_diskon)-$(this).val();


                $transaksi_total.val($transaksi_total_update);
                $transaksi_total_view.val(toRp($transaksi_total_update));
            });

            $('.transaksi_quantity').on('keyup', function(){
                var std = $(this).data('max');
                var cha = $(this).val();
                if (cha > std) {
                    $(this).val(std);
                }
            });


            $('#return_tipe').on('change', function(){
                var val = $(this).val();
                var tgl = $('body').find('#return_tanggal_selesai');
                if (val == 'rusak') {
                    tgl.find('input').val('');
                    tgl.siblings('.hr_return_tanggal_selesai').hide();
                    tgl.hide();
                } else if (val == 'kotor') {
                    tgl.find('input').val('');
                    tgl.siblings('.hr_return_tanggal_selesai').show();
                    tgl.show();
                }
            });





        }

    };

}();

jQuery(document).ready(function() {
    FormWizard.init();
});