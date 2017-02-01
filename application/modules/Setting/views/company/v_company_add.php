<!-- include summernote css/js-->
<link href="<?=base_url('assets/pinky/global/plugins/summernote/summernote.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/pinky/global/plugins/summernote/summernote.js')?>"></script>
<div class="row ">
    <?=$this->session->flashdata('pesan')?>
    <div class="col-md-8">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-white">
                    <label>IDENTITAS</label>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <form class="form-horizontal" method="post" action="<?=$link_act?>" role="post" enctype="multipart/form-data" onsubmit="return postForm()">
                    <input type="hidden" name="id" value="<?=$d->id?>">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Nama</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?=$d->name?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">No Telp</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="phone" value="<?=$d->phone?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Alamat</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" rows="4" name="address"><?=$d->address?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="email" value="<?=$d->email?>">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="setting_syarat_ketentuan" class="col-sm-2 col-sm-offset-1 control-label">Logo</label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new">
                                <input type="file" name="logo">
                            </div>
                            <p class="help-block">* Kosongi jika tidak diganti</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 control-label">Term Condition</label>
                        <div class="col-sm-9">
                            <textarea id="summernote" name="term_condition"><?=$d->term_condition?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-1">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption font-white">
                    <label>LOGO</label>
                </div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <img src="<?=base_url('uploads/logo/'.$d->logo)?>" class="img-responsive" alt="Logo Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function() {

        ComponentsDateTimePickers.init();
        $('#summernote').summernote({
            height: 200,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,
        });
    });

    function postForm() {
        $('textarea[name="term_condition"]').html($('#summernote').code());
    }

</script>