<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<style>
.select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 0px;
}
.select2-container .select2-selection--single, .select2-container .select2-selection--multiple{
    height: 34px;
}
</style>
<section class="content-header">
      <h1>
        Pengembalian & Penukaran Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Pengembalian & Penukaran Barang</li>
      </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Form Pengambalian & Penukaran Barang</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<form action="<?php echo base_url('admin/return-order/invoice') ?>" method="post">
				<div class="col-sm-6">
					<label>No Invoice</label>
					<div class="form-inline">
						<div class="form-group" style="width: 250px;">
							 <select name="no_invoice" class="form-control select2" style="width: 100%;" >
							 	<option> -- Select No Invoice --</option>
							 	<?php foreach ($list_no as $key => $value) { 
							 		$selected = ($value['no_transaksi'] == $no_invoice) ? 'selected' : '';
							 	?>
							 	<option value="<?php echo $value['no_transaksi'] ?>" <?php echo $selected ?>><?php echo $value['Note'] ?></option>
							 	<?php } ?>
							 </select>
						</div>
						<?php if(empty($no_invoice)){ ?>
						<button type="submit" class="btn btn-primary mb-2">Submit</button>
						<?php } else{ ?>
							<a href="<?php echo base_url('admin/return-order/form') ?>" class="btn btn-warning"><i class="fa fa-close"></i></a>
						<?php } ?>
					</div>
				</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
		<form action="" method="post">
		<input type="hidden" name="invoice_number" value="<?php echo $no_invoice ?>">
		<div class="box-footer">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th colspan="2">Barcode</th>
							<th>Item Name</th>
							<th style="width: 100px;">Qty</th>
							<th style="width: 150px;">Price</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($data_list['pos_list'])){ 
							foreach ($data_list['pos_list'] as $key => $value) { ?>
							<tr>
								<td><?php echo $key + 1 ?></td?>
								<td><?php echo $value['ItemCode'] ?></td>
								<td><?php echo $value['barcode'] ?></td>
								<td>
									<?php echo $value['ItemName'].' /Color : '.get_color_name($value['color']).' /Size: '.get_size_name($value['size']) ?>
								</td>
								<td>
									<?php echo $value['qty'] ?>
								</td>
								<td>
									<?php echo $value['price'] ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-danger" title="Penukaran" data-id="<?php echo $value['ID_ms'] ?>" data-qty="<?php echo $value['qty'] ?>" data-toggle="modal" data-target="#modalChange"><i class="fa fa-retweet"></i></button>
									<button type="button" class="btn btn-warning" title="Pengembalian" data-item="<?php echo $value['ItemName'].' /Color : '.get_color_name($value['color']).' /Size: '.get_size_name($value['size']) ?>" data-id="<?php echo $value['ID_ms'] ?>" data-qty="<?php echo $value['qty'] ?>" data-toggle="modal" data-target="#modalReturn"><i class="fa fa-reply"></i></button>
								</td>
							</tr>

						<?php } ?>

						<?php foreach ($order_temp as $temp => $tempdata) { ?>
							<tr>
								<td><?php echo ($tempdata['status'] == 1 ) ? ' - ' : ' + '; ?></td?>
								<td><?php echo $tempdata['ItemCode'] ?></td>
								<td><?php echo $tempdata['barcode'] ?></td>
								<td>
									<?php echo $tempdata['ItemName'].' /Color : '.get_color_name($tempdata['color']).' /Size: '.get_size_name($tempdata['size']) ?>
								</td>
								<td>
									<?php echo $tempdata['qty_temp'] ?>
								</td>
								<td>
									<?php echo $tempdata['price'] ?>
								</td>
								<td></td>
							</tr>
						<?php } ?>

						<?php } else { ?>
							<tr>
								<td colspan="7" align="center">No Data</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="box-footer text-right">
			<?php if(!empty($no_invoice)){ ?>
			<button class="btn btn-primary" type="submit" onclick="confirm('Data Pengembalian / Penukaran barang sudah sesuai ?')">Submit</button>
			<?php } ?>
		</div>
		</form>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="modalChangeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalChangeLabel">Penukaran Produk</h4>
      </div>
      <form action="<?php echo base_url('admin/return-order/modal-item/'.$no_invoice) ?>" method="post">
      <div class="modal-body">
      	<div class="row">
        	<div class="col-sm-10">
	        	<select class="form-control select2" name="item_change" style="width: 100%;" required>
	        		<option value="">--Pilih Produk--</option>
	        		<?php foreach ($product as $key => $value) { ?>
	        			<option value="<?php echo $value['ID_ms'] ?>"><?php echo $value['ItemCode'].' / '.$value['ItemName'].'/ '.$value['colorname'].' / '.$value['sizename'] ?></option>
	        		<?php } ?>
	        	</select>
	        	<input type="hidden" name="id_return">
	        </div>
	        <div class="col-sm-2">
	        	<input type="number" name="qty" class="form-control" required placeholder="qty" min="1">
	        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalReturn" tabindex="-1" role="dialog" aria-labelledby="modalReturnLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalReturnLabel">Pengembalian Produk</h4>
      </div>
      <form action="<?php echo base_url('admin/return-order/modal-item/'.$no_invoice) ?>" method="post">
      <div class="modal-body">
      	<div class="row">
        	<div class="col-sm-10">
	        	<input type="text" name="return" class="form-control" value="" disabled>
	        	<input type="hidden" name="id_return">
	        </div>
	        <div class="col-sm-2">
	        	<input type="number" name="qty" class="form-control" min="1" required placeholder="qty">
	        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	$(function(){
		$(".select2").select2();

		$('#modalChange').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget),
			    ItemID = button.data('id'),
			       qty = button.data('qty'),
			     modal = $(this);

			modal.find('input[name=id_return]').val(ItemID);
			modal.find('input[name=qty]').val(qty).attr('max', qty);
		});

		$('#modalReturn').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget),
			  ItemName = button.data('item'),
			    ItemID = button.data('id'),
			       qty = button.data('qty'),
			     modal = $(this);

			modal.find('input[name=return]').val(ItemName);
			modal.find('input[name=id_return]').val(ItemID);
			modal.find('input[name=qty]').val(qty).attr('max', qty);
		});
	});
</script>