<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<section class="content-header">
      <h1>
        Content Website
        <small>static pages lorem ipsum dolor sit amet.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Blog Posts</li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Blog Posts</h3>

  <div class="box-tools">
   <a href="<?php echo base_url('entersite/blog/new') ?>" class="btn btn-success pull-right">
   <i class="fa fa-plus"></i> Tambah Page Baru
   </a>
  </div>
  
  
  </div>
  <div class="box-body">

  <form action="<?php echo base_url('process_entersite/blog_action'); ?>" method="post" enctype="multipart/form-data">
  <div class="form-group action-btn hide">

  <button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
  
  <button type="submit" name="action" value="publish" class="btn btn-sm btn-default"><i class="fa  fa-eye"></i>&nbsp;Publish</button>

  <button type="submit" name="action" value="unpublish" class="btn btn-sm btn-default"><i class="fa fa-eye-slash"></i>&nbsp;Unpublish</button>

  </div>
  <table id="table-01" class="table table-bordered">
    <thead>
      <tr>
        <th class="no-sort" width="10">
        <input type="checkbox" id="selectAll" />
        </th>
        <th>Title</th>
        <th>Date Posted</th>
        <th width="120px" class="text-center">Published</th>
      </tr>
    </thead>
    <tbody>
      
      <?php 
      foreach ($blog_list->result() as $key) {
        if($key->publish == '11'){
          $publish = 'yes';
        }else{
          $publish = 'no';
        }
      ?>
      <tr>
      <td>
      <input class="checktbl" type="checkbox" name="pages[]" value="">
      </td>
      <td>
        <a href="<?php echo base_url('entersite/blog/edit/'.$key->id_page); ?>"><?php echo $key->title ?></a>
      </td>
      <td><?php echo $key->dateposted ?></td>
      <td style="text-align: center"><?php echo $publish ?></td>
      </tr>
      <?php } ?>
    
    </tbody>
  </table>
  </form>
  <br><br>
  </div>
   

</div>
</section>

<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">


$('#table-01').DataTable({
    "columnDefs": [{
      "targets": 'no-sort',
      "orderable": false,
    }]
});

function init_action(row){
  if(row > 0){
    $('.action-btn').removeClass('hide');
  }else{
    $('.action-btn').addClass('hide');
  }
}

$(function(){

$('#selectAll').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    var chlength = $('.checktbl:checked').length;
    init_action(chlength);
});

$('.checktbl').click(function(){
var chlength = $('.checktbl:checked').length;
var tblength = $('#table-01 tbody tr').length;
    if(chlength == tblength){
      $('#selectAll').prop('checked', this.checked);
    }else{
      $('#selectAll').prop('checked', false);
    }
    init_action(chlength);
});


});
</script>