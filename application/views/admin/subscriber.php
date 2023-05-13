<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">

<section class="content-header">
      <h1>
        Subscribers
        <small>daftar list email subscribers.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Subscribers</li>
      </ol>
</section>
<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Email List</h3>
  </div>
  <div class="box-body">
   
<table id="table01" class="table table-bordered">
  <thead>
    <tr>
      <th>Email</th>
      <th style="width: 150px">Created</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if(count($subscriber) > 0){
    foreach ($subscriber as $data => $key) {
  ?>
  <tr>
      <td><?php echo $key['email'] ?></td>
      <td><?php echo date('d M Y', strtotime($key['sub_date'])) ?></td>
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
    $('#table01').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    });
  });

</script>