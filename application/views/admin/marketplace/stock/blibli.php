<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<table  class="table table-bordered table-striped" border="1">
	<thead>
    	<tr>
    		<th>Blibli SKU</th>
    		<th>Nama Produk</th>
    		<th>SKU Code</th>
    		<th>Seller SKU</th>
    		<th>Harga (Rp)</th>
    		<th>Harga Penjualan (Rp)</th>
    		<th>Stok</th>
    		<th>Toko/Gudang</th>
    		<th>Ditampilkan</th>
    		<th>Dapat Dibeli</th>
    	</tr>
	</thead>
	<tbody>
	    <?php foreach($stock as $key => $value){ 
	    	$size = ($value['size'] == 14) ? '' : '-'.$value['size'];
	    ?>
	    <tr>
	        <td></td>
	        <td><?php echo $value['name'].' - '.$value['warna'] ?></td>
	        <td></td>
	        <td><?php echo $value['kode'].'-'.str_replace(' ', '', $value['warna']).'-'.$value['barcode'].$size ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['stock'] ?></td>
	        <td></td>
	        <td></td>
	        <td></td>
	    </tr>
	    <?php } ?>
	</tbody>
</table>