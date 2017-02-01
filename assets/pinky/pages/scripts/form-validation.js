var FormValidation = function () {

    var user_group = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_user_group');
            var error1 = $('.alert-danger', form1);
            // var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    user_group_nama: {
                        minlength: 2,
                        required: true
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    // success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var cont = $(element).parent('.input-group');
                    if (cont) {
                        cont.after(error);
                    } else {
                        element.after(error);
                    }
                },

                highlight: function (element) { // hightlight error inputs

                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                submitHandler: function (form) {
                    // success1.show();
                    error1.hide();
                    form.submit();
                }
            });
    }

    var user = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#new_user');
            var error1 = $('.alert-danger', form1);
            // var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    user_nama: {
                        minlength: 2,
                        required: true
                    },
                    user_username: {
                        minlength: 6,
                        required: true
                    },
                    user_password: {
                        minlength: 6,
                        required: true
                    },
                    m_cabang_id: {
                        required: true
                    },
                    s_user_group_id: {
                        required: true
                    }
                },
                messages: {
                    user_nama: "Tidak boleh kosong.",
                    user_password: "Tidak boleh kosong / Minimal 6 karakter",
                    m_cabang_id: "Tidak boleh kosong.",
                    s_user_group_id: "Tidak boleh kosong.",
                    user_username: "Tidak boleh kosong / Username sudah ada.",
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    // success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                errorPlacement: function (error, element) {
                    if (element.attr("name") == "m_cabang_id") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#m_cabang_id_error");
                    } else if (element.attr("name") == "s_user_group_id") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#s_user_group_id_error");
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                highlight: function (element) { // hightlight error inputs

                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                submitHandler: function (form) {
                    // success1.show();
                    error1.hide();
                    form.submit();
                }
            });
    }
    var user_edit = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#edit_user');
            var error1 = $('.alert-danger', form1);
            // var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    user_nama: {
                        minlength: 2,
                        required: true
                    },
                    user_username: {
                        minlength: 6,
                        required: true,
                    },
                    m_cabang_id: {
                        required: true
                    },
                    s_user_group_id: {
                        required: true
                    }
                },
                messages: {
                    user_nama: "Tidak boleh kosong.",
                    m_cabang_id: "Tidak boleh kosong.",
                    s_user_group_id: "Tidak boleh kosong.",
                    user_username: "Tidak boleh kosong",
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    // success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                errorPlacement: function (error, element) {
                    if (element.attr("name") == "m_cabang_id") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#m_cabang_id_error");
                    } else if (element.attr("name") == "s_user_group_id") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#s_user_group_id_error");
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                highlight: function (element) { // hightlight error inputs

                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                submitHandler: function (form) {
                    // success1.show();
                    error1.hide();
                    form.submit();
                }
            });
    }



    return {
        //main function to initiate the module
        init: function () {

            user_group();
            user();
            user_edit();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});