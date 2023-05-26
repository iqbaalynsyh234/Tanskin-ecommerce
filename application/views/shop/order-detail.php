
<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Order Status</li>
	  <li class="active">Order Details</li>
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
	<div id="print-invoice" class="page-side-box">

<style type="text/css">
.fot-print { display: none; }
@media print {
#print-invoice { padding: 10px 15px; }
.col-sm-8 {
    width: 66.66666667% !important;
    float: left;
}
.col-sm-4 {
    width: 33.33333333% !important;
    float: left;
}
.col-sm-6 {
    width: 50% !important;
    float: left;
}
#print-iframe{position: absolute; visibility: hidden; z-index: -1; height: 0px;}
.h-print { display: none; }
.fot-print { display: block !important; }
}
</style>


	<h3>Order Details</h3>
	<div class="row row-mar">
	<div class="col-sm-6 col-md-6 col-pad">
	<table>
		<tbody>
		<tr valign="top">
			<td>Alamat Pengiriman :</td>
			<td style="padding-left: 15px;">
				<address style="text-transform: capitalize;">
				<?php echo '<p><b>'.$orders->ShipName.' - (62+) '.$orders->ShipPhone.'</b></p>'; ?>
			    <p><?php echo $orders->ShipAddress ?><br>
			    <?php echo $alamat->kecamatan.', '.$alamat->kabupaten.'<br>'.$alamat->propinsi.', '.$orders->ShipPostcode; ?>.</p>
			    </address>
			</td>
		</tr>
		</tbody>
	</table>
	</div>
	<div class="col-sm-6 col-md-6 col-pad">
	<table class="fit-right">
		<tbody>
		<tr valign="top">
			<td style="text-align: right">No.Order :</td>
			<td style="padding-left: 15px;"><b><?php echo $orders->No_Orders ?></b></td>
		</tr>
		<tr valign="top">
			<td style="text-align: right">Metode Pengiriman :</td>
			<td style="padding-left: 15px;"><?php echo strtoupper($orders->ShippingMet); ?></td>
		</tr>
		<tr valign="top">
			<td style="text-align: right">Metode Pembayaran :</td>
			<td style="padding-left: 15px; text-transform: capitalize;"><?php echo $orders->PaymentMet.' / '.$orders->transaction_status; ?></td>
		</tr>
		<tr valign="top">
			<td style="text-align: right">Status :</td>
			<?php 
			if($orders->OrderStatus == 0){
				$status = 'Kadaluarsa';
			}elseif($orders->OrderStatus == 1){
				$status = 'Menunggu Pembayaran';
			}elseif($orders->OrderStatus == 2){
				$status = 'Diproses';
			}elseif($orders->OrderStatus == 3){
				$status = 'Dikirim';
			}elseif($orders->OrderStatus == 4){
				$status = 'Selesai';
			}else{
				$status = 'Kadaluarsa';
			}
			?>
			<td style="padding-left: 15px;"><?php echo $status ?></td>
		</tr>
		</tbody>
	</table>
	<br>
	</div>
	<div class="col-sm-12 col-pad">
	<div class="text-right"><small>Dihitung dalam satuan Rupiah (Rp)</small></div>
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Item</th>
			<th class="text-center">Qty</th>
			<th class="text-right">Price</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($list as $key) {
			$color = ($key->color != '') ? ' / '.get_color_name($key->color) : '';
      		$size = ($key->size != '') ? ' / '.get_size_name($key->size) : '';
		?>
			<tr>
			<td><?php echo $key->ItemName.$color.$size; ?></td>
			<td style="text-align: center;"><?php echo $key->qty ?></td>
			<td style="text-align: right;"><?php echo rupiah($key->PriceSell) ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<tr>
			<th class="text-right">Shipping Cost</th>
			<th class="text-right">Voucher</th>
			<th class="text-right">Code</th>
			<th class="text-right">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td style="text-align: right;"><?php echo rupiah($orders->ShippingCost) ?></td>
			<td style="text-align: right;">(0)</td>
			<td style="text-align: right;"><?php echo rupiah($orders->UnikCode) ?></td>
			<td style="text-align: right;"><?php echo rupiah($orders->Subtotal) ?></td>
			</tr>
		</tbody>
	</table>

	<hr>
	<span class="fot-print">Di print pada <?php echo date('d-M-Y H:i:s'); ?></span>
	<div class="text-right">
		<?php if($orders->OrderStatus == 3) { ?>
			<a href="<?php echo base_url('shop/tracking/'.$orders->cnote_no) ?>" class="btn btn-main-black"  type="button">Tracking Order</a>
		<?php } ?>
	<button class="btn btn-main-black h-print" id="print-inv" type="button"><i class="fa fa-print"></i> Print Invoice</button>
	</div>
	
	<?php if($orders->OrderStatus == 1){ ?>
	<strong>Catatan :</strong>
	<hr>
	<div class="payment-description">
	<div class="row">
		<div class="col-sm-8">
		  <a href="<?php echo $orders->pdf ?>" class="btn btn-info" target="_blank">Cara Pembayaran</a>
		  <br>
		  <br>
          <strong>
          Ketentuan Pembayaran
          </strong>
          <ul>
          <li>Total belanja kamu belum termasuk kode pembayaran untuk keperluan proses verifikasi otomatis</li>
          <li>Mohon transfer tepat sampai 3 digit terakhir</li>
          </ul>
         </div>
         <div class="col-sm-4 text-center">
         <h4><strong>Tagihan #KAM.<?php echo $orders->No_Orders ?> </strong></h4>
          <button class="btn btn-warning bayar-tag"><strong>IDR&nbsp;&nbsp;<?php echo rupiah($orders->Subtotal) ?>;-</strong></button><br>

          Transfer tepat sampai 3 digit terakhir.
         </div>
    </div>
       
    </div>
    <?php } ?>

	</div>

	</div>
	

	</div>
	</div>
	</div>
	</div>

	</div>
</div>
</div>

<iframe id="print-iframe" frameborder="0" class="hidden"></iframe>

<script type="text/javascript">
function printpop(){
  var myStyle = '<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ego-style.css">',
    content = myStyle + $("#print-invoice").html(),
    $iframe = $('#print-iframe');
    $iframe.ready(function() {
    $iframe.contents().find("body").html("");
    $iframe.contents().find("body").append(content);
        setTimeout(function () {
           $iframe.get(0).contentWindow.print();
        }, 500);
    });
}
$(function(){
	$('#print-inv').on('click', function(){
		printpop();
	});
});
</script>