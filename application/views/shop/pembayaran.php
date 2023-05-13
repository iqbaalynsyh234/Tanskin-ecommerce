<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Pembayaran</li>
	</ol>
	</div>
	</div>

	<div class="item-content">

	<div class="full_content">
	<div class="row">
	<div class="col-sm-12">
	<div id="print-invoice" class="page-side-box">

	<h3>Order Details</h3>
	<div class="row row-mar">
	<div class="col-sm-6 col-md-6 col-pad">
	<table>
		<tbody>
		<tr valign="top">
			<td>Alamat Pengiriman :</td>
			<td style="padding-left: 15px;">
				<address style="text-transform: capitalize;">
				<p><b><?php echo $pengiriman['nama'].' - '.$pengiriman['telepon'] ?></b></p>
				<p><?php echo nl2br($pengiriman['alamat']) ?><br>
				<?php echo $alamat['desa'].', '.$alamat['kecamatan'].'<br>'.$alamat['propinsi'].', '.$pengiriman['zip'] ?></p>
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
			<td style="padding-left: 15px;"><b><?php echo $pengiriman['order_number'] ?></b></td>
		</tr>
		<tr valign="top">
			<td style="text-align: right">Metode Pengiriman :</td>
			<td style="padding-left: 15px;"><?php echo $pengiriman['pengiriman'] ?></td>
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
			<?php foreach ($list as $key => $value) { 
			?>
			<tr>
			<td><?php echo $value['data_item']['ItemCode'].''.$value['item_name'].' '.get_color_name($value['color']).' '.get_size_name($value['size']) ?></td>
			<td style="text-align: center;"><?php echo $value['qty'] ?></td>
			<td style="text-align: right;"><?php echo rupiah($value['harga_jual']) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<table class="table table-bordered">
		<thead>
			<tr>
			<th class="text-right">Shipping Cost</th>
			<th class="text-right">Code</th>
			<th class="text-right">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td style="text-align: right;"><?php echo rupiah($pengiriman['cost']) ?></td>
			<td style="text-align: right;"><?php echo $pengiriman['unic_code'] ?></td>
			<td style="text-align: right;"><?php echo rupiah($pengiriman['total']) ?></td>
			</tr>
		</tbody>
	</table>

	<hr>
	<div class="text-right">
		 <form action="virtualaccount/submit" method="post">
		 <form action="virtualaccount/submit" method="post">
            <p>Input External ID: <input type="text" id="external_id" name="external_id"></p>
            <p>
                Select bank:
                <select name="bank_code" id="bank_code">
                  <option value="mandiri">Mandiri</option>
                  <option value="bni">BNI</option>
                  <option value="bri">BRI</option>
				  <option value="bca">BCA</option>
                </select>
            </p>
            <P>input Va Name: <input type="text" id="name" name="name"></p>
			<input type="submit" value="submit">
        </form>

	</div>
	


	</div>

	</div>
	

	</div>
	</div>
	</div>
	</div>

	</div>
</div>
</div>

<form id="payment-form" method="post" action="<?php echo base_url('private-snap/finish/'.$pengiriman['order_number']) ?>">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo setting_value('midtrans_clientkey') ?>"></script>
<script type="text/javascript">
$(function(){
	$('#submitdata-01').click(function (event) {
    event.preventDefault();
    $(this).prop('disabled', true);

    $.ajax({
      url: base_url + 'private-snap/token/<?php echo $pengiriman['order_number'] ?>',
      cache: false,
      success: function(data) {        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
        }

        snap.pay(data, {
          onSuccess: function(result){
            changeResult('success', result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            $("#payment-form").submit();
          }
        });

      }
    });
  });
});
</script>
