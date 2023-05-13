<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<table  class="table table-bordered table-striped" border="1">
	<thead>
    	<tr>
    		<th>product_id</th>
    		<th>reason</th>
    		<th>name</th>
    		<th>url</th>
    		<th>variant</th>
    		<th>category_id</th>
    		<th>category</th>
    		<th>stock</th>
    		<th>stock_use</th>
    		<th>status</th>
    		<th>sku</th>
    		<th>price</th>
    		<th>price_currency</th>
    		<th>description</th>
    		<th>hash_key</th>
    	</tr>
	</thead>
	<tbody>
	    <?php foreach($stock as $key => $value){ 
	        $url = $value['name'].'-'.$value['warna'];
	        $size = ($value['size'] == 14) ? '' : '-'.$value['size'];
	    ?>
	    <tr>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['name'].' - '.$value['warna'] ?></td>
	        <td><?php echo 'https://www.tokopedia.com/kamnco/'.strtolower(str_replace(array(' ', '-', '"', "'", '!'), '-', $url)) ?></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['stock'] ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo $value['kode'].'-'.str_replace(' ', '', $value['warna']).'-'.$value['barcode'].$size ?></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	    </tr>
	    <?php } ?>
	</tbody>
</table>