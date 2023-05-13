<?php
$segment = $this->uri->segment(3); 
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Rekening Bank</h4>
      </div>
      <form id="myForm" action="" method="post">
      <div class="modal-body row row-mar">
          <div class="col-sm-4">
          <div class="form-group">
              <label>Bank</label>
              <select name="bank" class="select2 form-control" style="width: 100%">
                <option value="" selected> -- Select Option --</option>
                <option value="PT. Bank Central Asia Tbk (BCA)">BCA</option>
                <option value="PT. Bank Mandiri Persero Tbk (MANDIRI)">MANDIRI</option>
                <option value="PT. Bank Negara Indonesia Persero Tbk (BNI)">BNI</option>
                <option value="PT. Bank Rakyat Indonesia Persero Tbk (BRI)">BRI</option>
                <option value="PT. Bank Permata Tbk (PERMATA)">PERMATA</option>
              </select>
          </div>
          </div>
          <div class="col-sm-8">
          <div class="form-group">
              <label>Nama Akun</label>
              <input type="text" name="akun" class="form-control akun">
          </div>
          </div>
          <div class="col-sm-12">
          <div class="form-group">
              <label>No. Rekening</label>
              <input type="text" name="norek" class="form-control rekening">
          </div>
          </div>
          <div class="col-sm-12">
          <div class="form-group">
              <label>Cabang</label>
              <input type="text" name="cabang" class="form-control cabang">
          </div>
          </div>
              </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="bankproses" value="true" class="btn btn-primary btn-proses">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>

<section class="content-header">
      <h1>
        Setting
        <small>Pengaturan Informasi Toko.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
        <?php if($segment == null){ }else{ ?>
        <li class="active"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
    <?php $this->load->view('admin/setting/nav-settings') ?>
<div class="tab-content">
   <h3 class="box-title">Pengiriman Barang</h3>
   <table class="table table-bordered">
     <thead>
       <tr>
         <th>Point Pengiriman</th>
         <th></th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td>Banten, Kab. Tangerang, Sepatan 15520
Indonesia</td>
         <td style="text-align: center">
         <button class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Ubah</button>
         </td>
       </tr>
     </tbody>
   </table>
   <br><br>
   
</div>
</div>
</section>

<script type="text/javascript">
$(function(){

});
</script>