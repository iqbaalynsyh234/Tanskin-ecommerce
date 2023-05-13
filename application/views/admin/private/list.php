<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
  .btn-status{
    padding: 10px 8px;
  }
</style>
<section class="content-header">
      <h1>
        List Private Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Orders</li>
        <li class="active">Private Order</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  
  <div class="box-body">
    <div class="table-responsive">
    <table id="table01" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>No.Order</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Url Pembayaran</th>
            <th>Tanggal</th>
          </tr>
        </thead> 
        <tbody>
          <?php 
          foreach ($list as $key => $value) { ?>
          <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $value['order_number'] ?></td>
            <td><?php echo $value['nama'] ?></td>
            <td><?php echo $value['telepon'] ?></td>
            <td><?php echo base_url('shop/pembayaran/').$value['token'] ?></td>
            <td><?php echo date('d M Y', strtotime($value['tanggal'])); ?></td>
          </tr>
          <?php } ?>
        </tbody>  
    </table>
    </div>
  </div>
  </div>
  
</section>





<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script type="text/javascript">
  $(function(){
    $('#table01').DataTable({
        pageLength : 100,
    });
  });
</script>