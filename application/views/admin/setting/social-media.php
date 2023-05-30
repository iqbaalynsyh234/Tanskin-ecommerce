<?php
$segment = $this->uri->segment(3); 
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert-master/dist/sweetalert.css">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Social Media</h4>
      </div>
      <form id="myForm" action="<?php echo base_url().'entersite/addmedsos' ?>" method="post">
      <div class="modal-body row row-mar">
        
          <div class="col-sm-4">
          <div class="form-group">
              <label>Sosial Media</label>
              <select name="media" class="select2 form-control" style="width: 100%" required>
                <option value="" selected>-- Select Option --</option>
                <option value="facebook-f">Facebook</option>
                <option value="twitter">Twitter</option>
                <option value="instagram">Instagram</option>
                <option value="youtube">Youtube</option>
                <option value="pinterest">Pinterest</option>
                <option value="linkedin">Linkedin</option>
                <option value="tiktok">Tiktok</option>
              </select>
          </div>
          </div>
          <div class="col-sm-8">
          <div class="form-group">
              <label>Nama Akun</label>
              <input type="text" name="akun" class="form-control akun" value="" required>
          </div>
          </div>
          <div class="col-sm-12">
          <div class="form-group">
              <label>Url</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                <input type="text" name="url" class="form-control url" value="" required>
              </div>
          </div>
          </div>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="addmedsos" value="true" class="btn btn-primary btn-proses">Tambah</button>
      </div>
        <div class="clearfix"></div>
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
        <li class="active text-capitalize"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
    <?php $this->load->view('admin/setting/nav-settings') ?>
<div class="tab-content">
   <h3 class="box-title">Social Media
    <button id="add-modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Social Media</button>
   </h3>
   <table class="table table-bordered table-middle">
     <thead>
       <tr>
         <th colspan="2">Daftar Social Media</th>
         <th width="200px"></th>
       </tr>
     </thead>
     <tbody>
     <?php 
     if($medsos->num_rows() > 0){
     foreach ($medsos->result() as $key) {
     ?>
       <tr>
         <td width="60px" style="text-align: center" data-id="<?php echo $key->id_sm ?>" data-sosial="<?php echo $key->socialmedia ?>"><i class="fa fa-<?php echo $key->socialmedia ?> fa-2x"></i></td>
         <td data-name="<?php echo $key->nama_akun ?>" data-url="<?php echo $key->url ?>">
           <ul class="inline">
              <li class="mr-30"><small><b>Nama Akun:</b></small><br><?php echo $key->nama_akun ?></li>
              <li class="mr-30"><small><b>Url:</b></small><br><a href="<?php echo $key->url ?>" target="_blank"><?php echo $key->url ?></a></li>
            </ul>
         </td>
         <td style="text-align: right">
         <button class="btn btn-default btn-xs update-modal"><i class="fa fa-edit"></i> Ubah</button>
         <button type="button" onclick="init_Delete($(this).data('id'));" data-id="<?php echo $key->id_sm ?>" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Hapus</button>
         </td>
       </tr>
      <?php } } else { ?>
      <tr><td colspan="3">No available data!</td></tr>
      <?php } ?>
     </tbody>
   </table>
   <br><br>
   
</div>
</div>
</section>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
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
      document.location.href="<?php echo base_url().'entersite/del/social_media/'; ?>"+id;
    } 
  });
}

function validate() {
  $('#myForm').validate({
    rules:{
      media: "required",
      akun : "required",
      url  : {
              required: true,
              url: true
             }
    },
    errorPlacement: function(error, element){}
  });
}
$(function(){
$(".select2").select2({
    minimumResultsForSearch: -1
});

$('#add-modal').on('click', function(){
    $('#myModal').modal('show');
    $('#myModal h4#myModalLabel').text('Tambah Sosial Media');
    $('#myForm').attr('action', '<?php echo base_url().'entersite/addmedsos' ?>');
    $('form#myForm .btn-proses').text('Tambah');
    validate();
});

$('.update-modal').on('click', function(){
    $('#myModal').modal('show');
    $('#myModal h4#myModalLabel').text('Ubah Sosial Media');
    
    var section = $(this).closest('tr').find('td:nth-child(2)'),
        media   = $(this).closest('tr').find('td:first-child').data('sosial'),
        akun    = section.data('name'),
        id      = $(this).closest('tr').find('td:first-child').data('id'),
        url     = section.data('url');
    $('#myForm').attr('action', '<?php echo base_url().'entersite/updatemedsos/' ?>'+id);
    $('#myForm').find('select.select2').append('<option value="'+media+'" selected>'+media+'</option>');
    $('#myForm').find('input.akun').val(akun);
    $('#myForm').find('input.url').val(url);
    $('form#myForm .btn-proses').text('Ubah');
    validate();
});

$('#myModal').on('hide.bs.modal', function (e) {
  document.getElementById("myForm").reset();
  $('#myForm select').html('<option value="" selected>-- Select Option --</option>'
    +'<option value="facebook">Facebook</option><option value="twitter">Twitter</option>'
    +'<option value="instagram">Instagram</option><option value="youtube">Youtube</option>'
    +'<option value="pinterest">Pinterest</option><option value="linkedin">Linkedin</option>');
  var validator = $("#myForm").validate();
   validator.resetForm();
});



});
</script>