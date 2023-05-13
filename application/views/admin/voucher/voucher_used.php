<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<section class="content-header">
      <h1>
        List Voucher Used
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Voucher Used</li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Voucher Used</h3>
  </div>
  <div class="box-body">

  
  <table id="table-01" class="table table-bordered">
    <thead>
      <tr>
        <th width="10">
        No.
        </th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Voucher</th>
        <th>Nominal</th>
        <th>Exp Voucher</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $key => $value) { ?>
        <tr>
          <td><?php echo $key + 1 ?></td>
          <td><?php echo $value['first_name'].' '.$value['last_name'] ?></td>
          <td><?php echo $value['email'] ?></td>
          <td><?php echo $value['phone'] ?></td>
          <td><?php echo $value['voucher_code'] ?></td>
          <td><?php echo rupiah($value['voucher_value']) ?></td>
          <td><?php echo date('d M Y', strtotime($value['end'])) ?></td>
          
        </tr>
      <?php } ?>
   
    </tbody>
  </table>

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
    }],
    pageLength : 100,
});

</script>