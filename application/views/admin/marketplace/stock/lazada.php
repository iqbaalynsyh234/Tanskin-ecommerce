<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<table  class="table table-bordered table-striped" border="1">
	<thead>
    	<tr>
    		<th>SellerSku</th>
    		<th>Quantity</th>
    		<th>Name</th>
    	</tr>
	</thead>
	<tbody>
	    <?php foreach($stock as $key => $value){ 
	    	$size = ($value['size'] == 14) ? '' : '-'.$value['size'];
	    ?>
	    <tr>
	        <td><?php echo $value['kode'].'-'.str_replace(' ', '', $value['warna']).'-'.$value['barcode'].$size ?></td>
	        <td><?php echo $value['stock'] ?></td>
	        <td><?php echo 'Kamnco '.$value['name'] ?></td>
	    </tr>
	    <?php } ?>
	</tbody>
</table>