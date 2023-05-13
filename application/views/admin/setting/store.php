<?php
$segment = $this->uri->segment(3); 
?>
<style type="text/css">
.gbrupload {
    width: 100%;
    height: 100%;
    margin-right: 10px;
    background-position: center center;
    background-size: contain;
    background-repeat: no-repeat;
    position: relative;
    z-index: 10;
}
.custom-file-input {
    display: inline-block;
    position: relative;
    width: 100%;
    top: 0px;
    left: 0px;
    height: 30px;
    background-color: rgb(238, 238, 238);
    color: #333;

    font: normal normal 13px/30px Helmet,FreeSans,Sans-Serif;
    border-radius: 4px;
    overflow: hidden;
    cursor: text;
    border: 1px solid #fff;
}
.custom-file-input span {
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 0 10px;
    overflow: hidden;
}
.custom-file-input span + span {
    text-align: center;
    font-weight: 600;
    background-color: rgb(238, 238, 238);
    border-radius: 0 4px 4px 0;
    padding: 0px 15px;
}
.custom-file-input input {
    opacity: 0;
    filter: alpha(opacity=0);
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 2000%;
    z-index: 4;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
</style>
<section class="content-header">
      <h1>
        Setting
        <small>Pengaturan Informasi Toko.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
        <?php if($segment == null){ }else{ ?>
        <li class="active text-capitalize"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
    <?php $this->load->view('admin/setting/nav-settings') ?>
<div class="tab-content">
<form id="myForm" action="<?php echo base_url().'entersite/proses_store' ?>" method="post" enctype="multipart/form-data">
   <h3 class="box-title">Ubah Informasi Toko</h3>
      <div class="row">
      <div class="col-sm-4">
      <?php
      if($store->brand_logo != ''){
        $logo = $store->brand_logo;
      } else {
        $logo = 'wrap-logo.png';
      }
      ?>
      <div class="box-store image--preview">
      <label>Logo Toko</label>
        <div class="gbrupload" style="background-image: url('<?php echo base_url().'assets/image/logo/'.$logo ?>');"><img src="<?php echo base_url().'assets/image/logo/wrap-logo-trans.png' ?>" width="100%"></div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imagemain">
            </span>
        </div>
        <br>
        <p><span>Besar file: maksimum 10 Megabytes
        Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</span></p>

      </div>
      <button class="btn btn-success hide"><i class="fa fa-plus"></i> Favicon</button>

      </div>
      <div class="col-sm-8">
          <div class="form-group">
            <label>Nama Toko *</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $store->nama_toko ?>" required>
          </div>
          <div class="form-group row row-mar">
            <div class="col-sm-6 col-pad">
            <label>Email *</label>
            <input type="text" class="form-control" name="email" value="<?php echo $store->email ?>" required>
            </div>
            <div class="col-sm-6 col-pad">
            <label>No. Telepon *</label>
            <input type="text" class="form-control" name="notel" value="<?php echo $store->no_telp ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" rows="5" name="address"><?php echo $store->alamat_toko ?></textarea>
          </div>
      </div>

      <div class="col-sm-12">
      <hr>
      <div class="form-group">
            <label>Title *</label>
            <input type="text" class="form-control" name="title" value="<?php echo $store->title ?>" required>
       </div>
       <div class="form-group">
            <label>Meta Description</label>
            <textarea class="form-control" rows="3" name="deskripsi"><?php echo $store->meta_deskripsi ?></textarea>
       </div>
       <div class="form-group hide">
            <label>Meta Author</label>
            <input type="text" class="form-control" name="author" value="<?php echo $store->meta_author ?>">
       </div>
       <div class="form-group">
            <label>Meta Keyword</label>
            <input type="text" class="form-control" name="keyword" value="<?php echo $store->meta_keyword ?>">
       </div>
       
      </div>
      </div>
   <div class="box-footer text-right">
   <button type="submit" name="toko" value="true" class="btn btn-success">Simpan Perubahan</button>
   </div>
</form>    
</div>
</div>
</section>

<script type="text/javascript">
$(function(){
$('body').on('change', '.btn-img-prev', function(){
        var files = !!this.files ? this.files : [],
            ini   = $(this).parents('.image--preview').find('.gbrupload');
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                ini.css("background-image", "url("+this.result+")");
                }
            }
});

$('#myForm').validate({
    rules:{
      nama     : "required",
      email    :{
          email    : true,
          required : true
                },
      notel    : "required",
    },
    errorPlacement: function(error, element) {
      
    },

});


});
</script>