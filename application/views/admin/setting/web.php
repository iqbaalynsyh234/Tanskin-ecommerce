<?php
$segment = $this->uri->segment(3); 
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert-master/dist/sweetalert.css">

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
  <form id="form-setting" action="<?php echo base_url('entersite/setting/web') ?>" method="post">
   <h3 class="box-title">Setting Website</h3>
   <div class="row">
      
      <div class="col-sm-6">
          <label>Diskon Belanja</label>
          <div class="form-group row">
            <div class="col-sm-6">
            <label>Minimal Pembelanjaan</label>
            <input type="number" class="form-control" name="min_pembelanjaan" value="<?php echo setting_value('min_pembelanjaan') ?>" required>
            </div>
            <div class="col-sm-6">
            <label>Maksimal Potongan</label>
            <input type="number" class="form-control" name="max_potongan" value="<?php echo setting_value('max_potongan') ?>" required>
            </div>

            <div class="col-sm-12">
            <hr>
            <br>
            <label>Token Instagram Feed</label>
            <input type="text" class="form-control" name="token_ig" value="<?php echo setting_value('token_ig') ?>" required>
            </div>
          </div>
      </div>
      <div class="col-sm-6">
        <label>Email Konfigurasi</label>
        <div class="form-group row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Mail Host</label>
                <input type="text" class="form-control" name="mail_host" value="<?php echo setting_value('mail_host') ?>" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Mail Port</label>
                <input type="number" class="form-control" name="mail_port" value="<?php echo setting_value('mail_port') ?>" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Mail Timeout</label>
                <input type="number" class="form-control" name="mail_timeout" value="<?php echo setting_value('mail_timeout') ?>" required>
              </div>
            </div>
            <div class="col-sm-6 hide">
              <div class="form-group">
                <label>Mail Username</label>
                <input type="text" class="form-control" name="mail_username" value="<?php echo setting_value('mail_username') ?>" required>
              </div>
            </div>
            <div class="col-sm-6 hide">
              <div class="form-group">
                <label>Mail Password</label>
                <input type="text" class="form-control" name="mail_password" value="<?php echo setting_value('mail_password') ?>" required>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo setting_value('email') ?>" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Site Name</label>
                <input type="text" class="form-control" name="site_name" value="<?php echo setting_value('site_name') ?>" required>
              </div>
            </div>
          </div>
      </div>

      </div>
      <div class="box-footer text-right">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>
 </form>
</div>
</div>
</section>

<script type="text/javascript">
$(function(){
  $('#form-setting').validate();
});
</script>
