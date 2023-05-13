<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">

<section class="content-header">
      <h1>
        Administrator
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Administrator</li>
      </ol>
</section>
<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Email List</h3>
  <a href="<?php echo base_url('admin/administator/add') ?>" class="box-tools btn btn-success"><i class="fa fa-plus"></i> Tambah Admin</a>
  </div>
  <div class="box-body">
   
<table id="table01" class="table table-bordered">
  <thead>
    <tr>
      <th>User Name</th>
      <th>Email</th>
      <th>Created</th>
      <th>Modified</th>
      <th style="width: 100px">Status</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if(count($admin) > 0){
    foreach ($admin as $key => $value) {
  ?>
  <tr>
      <td><a href="<?php echo base_url('admin/administator/view/'.$value['id_admin']) ?>"><?php echo ucfirst($value['user_admin']) ?></a></td>
      <td><?php echo $value['email_admin'] ?></td>
      <td><?php echo $value['crated'] ?></td>
      <td><?php echo $value['modifiedate'] ?></td>
      <td><?php echo ($value['status'] == '11') ? 'Active' : 'Deactive' ?></td>
  </tr>
   <?php } } ?>
  </tbody>
</table>

  </div>
  
</section>

<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.flash.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.print.min.js"></script>

<script type="text/javascript">
  $(function(){
    $('#table01').DataTable();
  });

</script>