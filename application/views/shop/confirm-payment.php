<?php
require 'vendor/autoload.php';

use Xendit\Xendit;

Xendit::setApiKey('xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3');

$sql = "SELECT * FROM payment_xendit";

?>

<?php echo $script_captcha; ?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.min.css">
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #555;
    line-height: 34px;
}
.select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #ccc;
}
.gbrupload {
    background-image: url('<?php echo base_url() ?>assets/image/logo/default.jpg');
    width: 100%;
    height: 262px;
    margin-right: 10px;
    background-position: center center;
    background-size: contain;
    background-repeat: no-repeat;
    position: relative;
    z-index: 10;
    border: 1px dashed #ccc;
    border-radius: 4px;
    cursor: pointer;
}
.custom-file-input {
    display: inline-block;
    position: relative;
    width: 100%;
    top: 0px;
    left: 0px;
    height: 34px;
    background-color: rgb(238, 238, 238);
    color: #333;
	margin-top: 10px;
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
    padding: 0 10px;
    overflow: hidden;
    width: 125px;
}
.custom-file-input span + span {
    text-align: center;
    font-weight: 600;
    background-color: rgb(0, 0, 0);
    border-radius: 0 4px 4px 0;
    padding: 0px 15px;
    color: #fff;
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

<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
      <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Confirm Payment</li>
	</ol>
	</div>
    </div>

	<div class="item-content">
    <div class="item-content-left side-open">
	<div class="nav-menu-page">
		<?php $this->load->view('shop/menu-page'); ?>
	</div>
	</div>


	<div class="item-content-right side-open">
    <div class="row">
    <div class="col-sm-12">
	<div class="page-side-box">
	<h3>Confirm Payment</h3>
	<form class="row" action="<?php echo base_url('processing/atlas_confirm_payment'); ?>" method="post" enctype="multipart/form-data">
		<div class="col-sm-6">
		<div class="form-group">
            <label>No. Order</label>
            <input type="number" name="no_order" class="form-control" placeholder="234">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select class="form-control select2 showprov" name="paymeth" style="width: 100%;">
            <option value="" selected="selected">-- pilih metode pembayaran --</option>
            <?php 
            if($bank->num_rows() > 0){
            foreach ($bank->result() as $key){
            ?>
                  <option value="<?php echo $key->id_bank ?>"><?php echo $key->method ?></option>
            <?php } } ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="account" class="form-control" placeholder="Nama pemilik rekening" name="external_id">
        </div>
        <div class="form-group">
            <label>Jumlah Pembayaran</label>
            <input type="number" name="pay" class="form-control">
        </div>
		</div>
		<div class="col-sm-6">
		<div class="image--preview">
		<label>Resi Pembayaran</label>
        <div class="gbrupload" onclick='$(".btn-img-prev").click()'>
        </div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imagemain" required>
            </span>
        </div>
      </div>
		</div>
		<div class="col-sm-12">
        <div class="form-group">
         <?php echo $captcha  ?>
        </div>
		<hr>
		<button type="submit" name="confirm" value="submit" class="btn btn-main-black">Confirm Payment</button>
		</div>
	</form>
	</div>
	</div>
    </div>
    </div>
	</div>
</div>
</div>	

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	$(function(){
		$(".select2").select2({
		 	minimumResultsForSearch: -1
		});
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
	});
</script>