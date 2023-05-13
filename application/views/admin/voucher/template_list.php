<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<section class="content-header">
      <h1>
        Template Voucher
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Template Voucher</li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Template Voucher</h3>
    <div class="box-tools">
      <a href="<?php echo base_url('admin/voucher/template_add') ?>" class="btn btn-success">
        <i class="fa fa-plus"></i> Add Template</a>   
    </div>
  </div>
  <div class="box-body">

  
  <table id="table-01" class="table table-bordered">
    <thead>
      <tr>
        <th width="10">
        No.
        </th>
        <th>Template</th>
        <th>Nominal</th>
        <th>Date</th>
        <th>Publish</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $key => $value) { ?>
      <tr>
        <td><?php echo $key + 1 ?></td>
        <td>
          <a href="<?php echo base_url('admin/voucher/template_edit/'.$value['ID']) ?>">
            <img style="height: 100px;" src="<?php echo base_url('assets/image/voucher/'.$value['template']) ?>">
          </a>
        </td>
        <td><?php echo rupiah($value['voucher_value']) ?></td>
        <td><?php echo date('d M Y H:i', strtotime($value['date_add'])) ?></td>
        <td><?php echo ($value['publish'] == 1) ? 'Yes' : 'No' ?></td>
      </tr> 
      <?php } ?>
    </tbody>
    <tbody>
     
   
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