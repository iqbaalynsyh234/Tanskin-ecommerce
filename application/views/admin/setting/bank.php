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
          <div class="col-sm-6">
          <div class="form-group">
              <label>Nama Metode Pembayaran</label>
              <input type="text" name="meth" class="form-control meth" placeholder="ex: Bank BCA - ATM Transfer">
          </div>
          </div>
          <div class="col-sm-6">
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
        <li class="active text-capitalize"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
    <?php $this->load->view('admin/setting/nav-settings') ?>
<div class="tab-content">
   <h3 class="box-title">Rekening Bank
    <button id="addbank" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tambah Rekening Bank</button>
   </h3>
   <table class="table table-bordered table-middle">
     <thead>
       <tr>
         <th colspan="5">Daftar Rekening</th>
         <th width="200px"></th>
       </tr>
     </thead>
     <tbody>
     <?php 
     if($bank->num_rows() > 0){
     foreach ($bank->result() as $key) {
      if($key->nama_bank == 'PT. Bank Central Asia Tbk (BCA)'){
        $bankicon = 'icon-bca'; $nickbank = 'BCA';        
      }else if($key->nama_bank == 'PT. Bank Mandiri Persero Tbk (MANDIRI)'){
        $bankicon = 'icon-mandiri'; $nickbank = 'MANDIRI';
      }else if($key->nama_bank == 'PT. Bank Negara Indonesia Persero Tbk (BNI)'){
        $bankicon = 'icon-bni'; $nickbank = 'BNI';
      }else if($key->nama_bank == 'PT. Bank Rakyat Indonesia Persero Tbk (BRI)'){
        $bankicon = 'icon-bri'; $nickbank = 'BRI';
      }else{
        $bankicon = 'icon-permata'; $nickbank = 'PERMATA';
      }

     ?>
       <tr data-id="<?php echo $key->id_bank ?>" data-value="<?php echo $key->nama_bank ?>" data-akun="<?php echo $key->nama_akun ?>" data-rekening="<?php echo $key->no_rek ?>" data-cabang="<?php echo $key->cabang ?>" data-bank="<?php echo $nickbank ?>"
       data-meth="<?php echo $key->method ?>">
         <td width="60px"><span class="icon <?php echo $bankicon ?>"></span></td>
         <td>
           <ul class="inline">
              <li class="mr-30"><small><b>Nama Akun:</b></small><br><?php echo $key->nama_akun ?></li>
            </ul>
         </td>
         <td>
           <ul class="inline">
              <li class="mr-30"><small><b>Nomor Rekening:</b></small><br><?php echo $key->no_rek ?></li>
            </ul>
         </td>
         <!-- <td>
           <ul class="inline">
              <li class="mr-30"><small><b>Nama Bank:</b></small><br><?php //echo $key->nama_bank ?></li>
            </ul>
         </td> -->
         <td>
           <ul class="inline">
              <li class="mr-30"><small><b>Cabang:</b></small><br><?php echo $key->cabang ?></li>
            </ul>
         </td>
         <td>
           <ul class="inline">
              <li class="mr-30"><small><b>Metode:</b></small><br><?php echo $key->method ?></li>
            </ul>
         </td>
         <td style="text-align: right">
         <button class="btn btn-default btn-xs updatebank"><i class="fa fa-edit"></i> Ubah</button>
         <button type="button" onclick="init_Delete($(this).data('id'));" data-id="<?php echo $key->id_bank ?>" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Hapus</button>
         </td>
       </tr>
      <?php } } else { ?>
      <tr><td colspan="6">No available data!</td></tr>
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
      document.location.href="<?php echo base_url().'entersite/del/bank/'; ?>"+id;
    } 
  });
}

$(function(){
$(".select2").select2({
    minimumResultsForSearch: -1
});

$('#myModal').on('hidden.bs.modal', function (e) {
  document.getElementById("myForm").reset();
})

$('#myForm').validate({
    rules:{
      bank    : "required",
      akun    : "required",
      norek   : "required",
      cabang  : "required",
    },
    errorPlacement: function(error, element){}
});

$('#myModal').on('hide.bs.modal', function (e) {
  document.getElementById("myForm").reset();
  $('#myForm select.select2').html('<option value="" selected>-- Select Option --</option>'
    +'<option value="PT. Bank Central Asia Tbk (BCA)">BCA</option>'
    +'<option value="PT. Bank Mandiri Persero Tbk (MANDIRI)">MANDIRI</option>'
    +'<option value="PT. Bank Negara Indonesia Persero Tbk (BNI)">BNI</option>'
    +'<option value="PT. Bank Rakyat Indonesia Persero Tbk (BRI)">BRI</option>'
    +'<option value="PT. Bank Permata Tbk (PERMATA)">PERMATA</option>');
  var validator = $("#myForm").validate();
  validator.resetForm();
});

$('#addbank').on('click', function(){
    $('#myModal').modal('show');
    $('#myModal h4#myModalLabel').text('Tambah Rekening Bank');
    $('form#myForm').attr('action', '<?php echo base_url().'entersite/prosesbank' ?>');
    $('form#myForm .btn-proses').text('Tambah');
});

$('.updatebank').on('click', function(){
    $('#myModal').modal('show');
    $('#myModal h4#myModalLabel').text('Ubah Rekening Bank');
    var bank   = $(this).closest('tr').data('value'),
        kord   = $(this).closest('tr').data('bank'),
        akun   = $(this).closest('tr').data('akun'),
        rek    = $(this).closest('tr').data('rekening'),
        cabang = $(this).closest('tr').data('cabang'),
        meth   = $(this).closest('tr').data('meth'),
        id     = $(this).closest('tr').data('id');
        
    $('form#myForm').attr('action', '<?php echo base_url().'entersite/prosesbank/edit/' ?>'+id);
    $('form#myForm').find('select.select2').append('<option value="'+bank+'" selected>'+kord+'</option>');
    $('form#myForm').find('input.akun').val(akun);
    $('form#myForm').find('input.rekening').val(rek);
    $('form#myForm').find('input.cabang').val(cabang);
    $('form#myForm').find('input.meth').val(meth);
    $('form#myForm .btn-proses').text('Ubah');
});

});
</script>