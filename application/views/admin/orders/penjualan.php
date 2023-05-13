<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

<section class="content-header">
      <h1>
        Data Penjualan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Penjualan</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <form class="form-inline" role="form" method="post" action="">
            <div class="form-group">
                  <label>Tanggal: </label>
                  <div class="form-group">
                  </div>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="sortdate" class="form-control pull-right" id="reservation0">
                  </div>
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="btn btn-success">Sort Sales</button>
                </div>
          </form>
  </div>
  <div class="box-body">
    <div class="text-center"><h4><label>Data Penjualan<br><?php echo $start.' - '.$end ?></label></h4></div>
  </div>
  <div class="box-body">
      <table id="table01" class="table table-bordered table-striped">
          <thead>
              <tr>
                <th>No.</th>
                <th>Invoice</th>
                <th>Store</th>
                <th>No. Transaksi</th>
                <th>Customer</th>
                <th class="text-right">Tgl. Transaksi</th>
                <th class="text-right">Tgl. Packing</th>
                <th>Table</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($penjualan as $key => $value) { ?>
              <tr>
                <td><?php echo $key + 1 ?></td>
                <td><a href="<?php echo base_url('admin/penjualan/detail/'.$value['id']) ?>"><?php echo $value['Note'] ?></a></td>
                <td><?php echo $value['meth'] ?></td>
                <td><?php echo $value['no_transaksi'] ?></td>
                <td><?php echo $value['cusname'] ?></td>
                <td align="right"><?php echo date('d M Y', strtotime($value['tgl_transaksi'])) ?></td>
                <td class="text-right"><?php echo (!empty($value['packing'])) ? date('d M Y H:i:s', strtotime($value['packing'])) : 'Belum di packing'; ?></td>
                <td><?php echo $value['table_packing'] ?></td>
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
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
  $(function(){
      $('#reservation0').daterangepicker({
          locale: {
            format: 'YYYY/MM/DD'
          },
          startDate: '<?php  echo date('Y/m/d', strtotime($start)) ?>',
          endDate: '<?php  echo date('Y/m/d', strtotime($end)) ?>'
      });
      $('#table01').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ]
    });
  });
</script>