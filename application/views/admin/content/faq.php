<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert-master/dist/sweetalert.css">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Frequently Asked Questions</h4>
      </div>
      <form action="<?php echo base_url().'entersite/proses_faq' ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
     <label>Pertanyaan</label>
     <input type="text" name="ask" class="form-control">
     </div>
     <div class="form-group">
     <label>Jawaban</label>
     <textarea class="form-control textarea" rows="4" name="answer"></textarea>
     </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="submit" value="true" class="btn btn-primary">Tambah Pertanyaan</button>
      </div>
      </form>
    </div>
  </div>
</div>


<section class="content-header">
      <h1>
        Static Page
        <small>Halaman Static Website.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Static Page</li>
        <li class="active">FAQ</li>
     </ol>
</section>
<section class="content">
<div class="nav-tabs-custom">
    <div class="box-body">
<?php $this->load->view('admin/content/nav_static_page') ?>
</div><div class="tab-content">
   <h3 class="box-title">Frequently Asked Questions
   <button class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Pertanyaan</button>
   </h3>
   <?php if($faq->num_rows() > 0){ 
    foreach ($faq->result() as $key) {
    ?>
   <form action="<?php echo base_url().'entersite/proses_faq/edit/'.$key->id_faq ?>" method="post">
     <div class="form-group">
     <label>Pertanyaan</label>
     <input type="text" name="ask" class="form-control" value="<?php echo $key->pertanyaan ?>" readonly>
     </div>
     <div class="form-group ans hidden">
     <label>Jawaban</label>
     <textarea class="form-control textarea" rows="4" name="answer"><?php echo htmlspecialchars_decode($key->jawaban); ?></textarea>
     </div>
     <div class="dummy">
     <label>Jawaban</label>
     <?php echo htmlspecialchars_decode($key->jawaban); ?>
     </div>
    <div class="text-right">
    <button type="button" onclick="init_Delete($(this).data('id'));" data-id="<?php echo $key->id_faq ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button>
    <button type="button" class="btn btn-default btn-ubah"><i class="fa fa-edit"></i> Ubah</button>
    <button type="submit" name="submit" value="true" class="btn btn-default btn-simpan hidden">Simpan Perubahan</button>
    <hr class="mini-hr">
    </div>
   </form>
   <?php } } ?>
</div>
</div>
</section>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
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
      document.location.href="<?php echo base_url().'entersite/del/faq/'; ?>"+id;
    } 
  });
}


$(function(){
    $(".textarea").wysihtml5();
    $('#myModal form').validate({
      rules:{
        ask:"required",
      },
      errorPlacement: function(error, element){}
    });

    $('.btn-ubah').on('click', function(){
        var induk  = $(this).closest('form').find('input'),
            btn    = $(this).closest('form').find('.btn-simpan');
            ini    = $(this).closest('form');
        if(induk.attr('readonly')){
          induk.removeAttr('readonly');
          btn.removeClass('hidden');
          $(this).text('Batal');
          ini.find('.ans').removeClass('hidden');
          ini.find('.dummy').addClass('hidden');
        }else{
          induk.attr('readonly', true);
          btn.addClass('hidden');
          $(this).html('<i class="fa fa-edit"></i> Ubah');
          ini.find('.ans').addClass('hidden');
          ini.find('.dummy').removeClass('hidden');
        }
    });

});
</script>