<div class="row ">
    <?=$this->session->flashdata('pesan')?>
    <div class="col-md-12">
        <div id="alert">

        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <button type="button" class="btn btn-success" onclick="importImg($('#signature'))">Simpan</button>
                    <button type="button" class="btn btn-info" onclick="$('#signature').jSignature('clear')">Clear</button>
                    <a href="<?=$urlback?>" class="btn btn-warning"> Kembali</a>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <div id="signature"></div>
                <div class="row">
                    <div class="col-md-5 col-md-offset-3">
                        <input class="form-control" type="text" id="name_receiver" placeholder="Nama Anda....">
                    </div>
                </div>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>
<!-- END PAGE CONTENT-->
<input type="hidden" id="urlsignature" value="<?=$urlsignature?>">
<input type="hidden" id="appointment_id" value="<?=$id?>">

<script language="JavaScript" type="text/javascript" src="<?=base_url('assets/jSignature/jSignature.min.js')?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#signature").jSignature({color:"#000",lineWidth:5,"background-color":"#0f0"});
    });

    function importImg(sig)
    {
        sig.children("img.imported").remove();
//        $("<img class='imported'>").attr("src",sig.jSignature('getData')).appendTo(sig);
//        console.log(sig.jSignature('getData'));
        var url = $('#urlsignature').val();
        var id = $('#appointment_id').val();
        var reciver = $('#name_receiver').val();
        var ttd_invoice = sig.jSignature('getData');
        $.ajax({
            url: url,
            type : 'post',
            data : {id : id, ttd_invoice:ttd_invoice,receiver:reciver},
            cache: false,
        })
            .success(function() {
                $('#alert').append('<div class="alert alert-success" role="alert">Tanda tangan berhasil tersimpan</div>')
            });
    }
</script>