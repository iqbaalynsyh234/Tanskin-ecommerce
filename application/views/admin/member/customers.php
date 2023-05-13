<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">

<section class="content-header">
      <h1>
        Customers
        <small>daftar list email Customers.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Customers</li>
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
      <th>ID</th>
      <th>Email</th>
      <th>Provider</th>
      <th>Name</th>
      <th>Crated</th>
      <th>Modified</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if($users->num_rows() > 0){
    foreach ($users->result() as $key) {
  ?>
  <tr>
      <td><?php echo $key->id ?></td>
      <td><?php echo $key->email ?></td>
      <td><?php echo $key->oauth_provider ?></td>
      <td><?php echo $key->first_name.' '.$key->last_name ?></td>
      <td><?php echo $key->created ?></td>
      <td><?php echo $key->modified ?></td>
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