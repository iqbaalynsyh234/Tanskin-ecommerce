<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert-master/dist/sweetalert.css">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Navigasi</h4>
      </div>
      <form action="<?php echo base_url().'entersite/proses_nav' ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
         <label>Nama</label>
         <input type="text" name="nav" class="form-control">
        </div>
        <div class="row">
        <div class="col-sm-6">
        <div class="form-group">
              <label>Kategori Produk</label>
              <?php
              $dis = ''; 
              if(count($list_categories) > 0){ $dis = ''; }else{ $dis = 'disabled'; }
              ?>
              <select name="kategori" class="form-control select2" <?php echo $dis ?> style="width: 100%;">
                  <option value="">-- select category --</option>
                  <option value="All">ALL</option>
              <?php

              foreach ($list_categories as $key => $value) {
              ?>
                  <option value="<?php echo $value['ID_cat'] ?>"><?php echo strtoupper($value['kategori']) ?></option>
              <?php } ?>
              </select>
          </div>
        </div>
        <div class="col-sm-6">
        <div class="form-group">
        <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="yes" checked="">
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="no">
                      No
                    </label>
                  </div>
                </div>
        </div>
        
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="submit" value="true" class="btn btn-primary">Tambah Navigasi</button>
      </div>
      </form>
    </div>
  </div>
</div>


<section class="content-header">
      <h1>
        Navigation
        <small>Menu navigasi website.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Navigasi</li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Navigasi</h3>
  <div class="box-tools">
   <button class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Navigasi</button>     
  </div>
  
  
  </div>
  <div class="box-body">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="20">No</th>
        <th>Navigasi</th>
        <th width="120px" class="text-center">Publish</th>
        <th width="120px"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    if($navigasi->num_rows() > 0){ 
      $no = 1;
      foreach ($navigasi->result() as $key) {
    ?>
      <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $key->navigasi ?></td>
        <td style="text-align: center">
         <?php if($key->publish == '01'){ echo 'No'; }else{ echo 'Yes'; } ?>
        </td>
        <td style="text-align: center; white-space: nowrap;">
          <a href="<?php echo base_url() ?>" class="btn btn-default"><i class="fa fa-trash"></i> Hapus</a>
          <a href="<?php echo base_url() ?>" class="btn btn-default"><i class="fa fa-edit"></i> Ubah</a>
        </td>
      </tr>
      <?php $no++;} } else { ?>
      <tr><td colspan="5">No Available data!</td></tr>
      <?php } ?>
    </tbody>
  </table>
  <br><br>
  </div>
   

</div>
</section>


<script src="<?php echo base_url() ?>assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>


<script type="text/javascript">
function init_Delete(id){
  swal({
    title: "Hapus Data",
    text: "baris data akan di hapus.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Hapus",
    cancelButtonText: "Batal",
    closeOnConfirm: false,
  },
  function(isConfirm){
    if (isConfirm) {
      document.location.href="<?php echo base_url().'entersite/del/faq/'; ?>"+id;
    } 
  });
}


$(function(){
$(".select2").select2({
    minimumResultsForSearch: -1
});
});

</script>