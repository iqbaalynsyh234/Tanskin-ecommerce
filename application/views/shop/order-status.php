<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Order Status</li>
	</ol>
	</div>
	</div>

	<div class="item-content">
	<div class="item-content-left side-open">
	<div class="nav-menu-page">
		<?php $this->load->view('shop/menu-page'); ?>
	</div>
	</div>


		<div class="item-content-right side-open">
	<div class="row">
	<div class="col-sm-12">
	<div class="page-side-box" style="padding-bottom: 127px">
	<h3>Orders Status</h3>

	<table id="table01" class="table table-bordered">
		<thead>
			<tr>
				<th>No. Orders</th>
				<th class="text-center">Tagihan</th>
				<th class="text-center" width="100px">Status</th>
			</tr>
		</thead>
		<tbody>

		<?php
		if($orders->num_rows() > 0){ 
		foreach ($orders->result() as $key) {?>
			<tr>
				<td><a href="<?php echo base_url().'shop/order-detail/'.$key->No_Orders ?>">KAM.<?php echo $key->No_Orders ?></a></td>
				<td style="text-align: right; white-space: nowrap;">IDR <?php echo rupiah($key->Subtotal) ?></td>
				<?php 
				if($key->OrderStatus == 0){
					$status = 'Kadaluarsa';
				}elseif($key->OrderStatus == 1){
					$status = 'Menunggu Pembayaran';
				}elseif($key->OrderStatus == 2){
					$status = 'Diproses';
				}elseif($key->OrderStatus == 3){
					$status = 'Dikirim';
				}
				elseif($key->OrderStatus == 4){
					$status = 'Selesai';
				}else{
					$status = 'Kadaluarsa';
				}
				?>
				<td style="text-align: right; white-space: nowrap;"><?php echo $status ?></td>
			</tr>
		<?php } } else { ?>
		<?php } ?>
		</tbody>
	</table>

	</div>
	</div>
	</div>
	</div>

	</div>
</div>
</div>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#table01').DataTable();
});
</script>