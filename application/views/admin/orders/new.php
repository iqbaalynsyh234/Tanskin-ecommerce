<?php $segment = $this->uri->segment(3); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert-master/dist/sweetalert.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<section class="content-header">
      <h1>
        Orders
        <small>Penjualan Toko.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
        <?php if($segment == null){ }else{ ?>
        <li class="active text-capitalize"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
<?php $this->load->view('admin/orders/navigasi') ?>
<div class="tab-content">
<?php foreach ($tahun as $key => $value) { 
  $action = ($value['tahun'] == date('Y')) ? 'btn-info disabled' : ''; ?>
<a href="#" class="btn btn-default <?php echo $action ?>"><?php echo $value['tahun'] ?></a>
<?php } ?>
<hr class="mini-hr">

<?php echo $list_temp; ?>

<br>
</div>

</div>
  <b><i class="fa fa-info-circle"></i></b>&nbsp;&nbsp;
  <b>NEW ORDER</b>&nbsp;&nbsp;pesanan baru, belum melakukan pembayaran.&nbsp;
  <b>PAYMENT</b>&nbsp;&nbsp;pesanan yang sudah melakukan pembayaran.&nbsp;
  <b>PROCCESS</b>&nbsp;&nbsp;pesanan diproses, segera lakukan pengiriman.&nbsp;
  <b>SENT</b>&nbsp;&nbsp;pesanan telah dikirim.&nbsp;
  <b>CANCEL</b>&nbsp;&nbsp;pesanan yang dibatalkan oleh penjual, atau tidak melakukan pembayaran selama 2 hari dari waktu pemesanan.&nbsp;

</section>

<script src="<?php echo base_url() ?>assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
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

$('body').on('change', 'select.no-padd', function(){
  var data = $(this).val(), value = $(this).data('order'), 
      uri  = '<?php echo base_url() ?>entersite/changestatus', 
      init = $(this);
  init_ChangeStatus(data, value, uri, init);
});

$('body').on('click', '.atlas_payment button', function(){
  var form = $(this).closest('.atlas_payment'), data = $(this).val();
  init_PaymentConfirm(form, data);
});

var table;
    //datatables
    table = $('#table-01').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ],
        "pageLength": 20,
        "responsive": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url().'entersite/orders_list/'.$bag;?>",
            "type": "POST",
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    });


});
</script>