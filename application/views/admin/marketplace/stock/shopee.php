<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<table  class="table table-bordered table-striped" border="1">
	<thead>
    	<tr>
    		<th>Kode Produk</th>
    		<th>Nama Produk</th>
    		<th>Kode Variasi</th>
    		<th>Nama Variasi</th>
    		<th>SKU Induk</th>
    		<th>SKU</th>
    		<th>Harga</th>
    		<th>Stok</th>
    	</tr>
	</thead>
	<tbody>
	    <?php foreach($stock as $key => $value){ 
	    	$size = ($value['size'] == 14) ? '' : '-'.$value['size'];
	    ?>
	    <tr>
	        <td><?php echo $value['barcode'] ?></td>
	        <td><?php echo $value['name'].' - '.$value['warna'] ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['kode'].'-'.str_replace(' ', '', $value['warna']).'-'.$value['barcode'].$size ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['stock'] ?></td>
	    </tr>
	    <?php } ?>
	</tbody>
</table>