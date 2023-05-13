<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

<section class="content-header">
      <h1>
        Daftar Packing
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Penjualan</li>
        <li class="active">Packing</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
    <form action="<?php echo base_url('process-entersite/table') ?>" method="post" class="form-inline">
      <div class="form-group">
        <select name="meja" class="form-control" required>
          <option value=""> -- Pilih Meja -- </option>
          <option value="1" <?php echo ($this->session->userdata('table') == '1') ? 'selected' : ''; ?>>Meja 1</option>
          <option value="2" <?php echo ($this->session->userdata('table') == '2') ? 'selected' : ''; ?>>Meja 2</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success">Set Meja</button>
      </div>
    </form>
  </div>
  
  <div class="box-body">
      <table id="table01" class="table table-bordered table-striped">
          <thead>
              <tr>
                <th>No.</th>
                <th>Invoice</th>
                <th>Store</th>
                <th>Customer</th>
                <th class="text-right">Tgl. Transaksi</th>
                <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($list_packing as $key => $value) { ?>
              <tr>
                <td><?php echo $key + 1 ?></td>
                <td><a href="<?php echo base_url('admin/penjualan/detail/'.$value['id']) ?>"><?php echo $value['Note'] ?></a></td>
                <td><?php echo $value['meth'] ?></td>
                <td><?php echo $value['cusname'] ?></td>
                <td align="right"><?php echo date('d M Y', strtotime($value['tgl_transaksi'])) ?></td>
               
                <td>
                  <!-- <form action="" method="post" style="display: inline-block">
                    <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">PACKING</button>
                  </form> -->
                  <a href="<?php echo base_url('entersite/del-order-list/'.$value['id']) ?>" class="btn btn-danger" onclick="confirm('Hapus order list?')" style="display: inline-block"><i class="fa fa-trash"></i></a>
              </td>
              </tr>
            <?php } ?>
          </tbody>
      </table>
  </div>
  </div>
</section>

<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>

<script type="text/javascript">
  $(function(){
      
      $('#table01').DataTable({
        pageLength : 100,
      });
  });
</script>