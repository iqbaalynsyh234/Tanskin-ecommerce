
<div id="wrap-content">
<div class="container">
<div class="row">
	<div class="col-sm-12" style="position: relative;">

	

	<div class="item-content">

	<div class="title-page" style="margin-bottom: 50px;">
	<h1>Search : <?php echo ucwords(strtolower($key)) ?></h1>
	</div>

	

	<div class="item-content-right">
	<div class="row row-mar">

	<?php 
	if (isset($results) > 0) {
	foreach ($results as $key => $data) { 
		if($data['ItemType'] == 2 || $data['ItemType'] == 4){
			$uricolor = '/'.my_slug($data['ID_colorname']);
		}else{
			$uricolor = '';
		}
		$linkproduk = $data['url'].$uricolor;
	?>
		<div class="col-xs-6 col-sm-4 col-pad">
		<div class="box-item">
		<a href="<?php echo base_url().'shop/products/'.$linkproduk ?>">
		<div class="box-image-show">
			<img src="<?php echo base_url().'assets/image/product/'.$data['image1'] ?>" alt="">
			<div class="inner-center">
				<div class="hover-cart"></div>
			</div>
		</div>
		</a>
		<div class="box-item-info">
			<div class="product_name"><a href="<?php echo base_url().'shop/products/'.$linkproduk ?>">
			<span><b><?php echo $data['ItemName'] ?></b></a></div>
			<div class="product_shortdesc"><?php echo $data['ItemNmDesc'] ?></div>
			<div class="product_price">
			<?php if($data['disc'] > 0){ ?>
			<span class="disc-notif">
			<?php if($data['disc'] <= 100){ echo $data['disc'].'% off'; 
			} else{ echo '- '.rupiah($data['disc']); } ?>
			</span>
			<span style="text-decoration: line-through">&nbsp;IDR <?php echo rupiah($data['price']) ?>&nbsp;</span><br>
			<span style="color: #F44336;">
			<?php 
			if($data['disc'] <= 100){ 
				echo 'IDR '.rupiah($data['price'] - ($data['price']*$data['disc'])/100);
			} else {
				echo 'IDR '.rupiah($data['price'] - $data['disc']);
			}
			?>
			</span>
			<?php } else { ?>
			IDR <?php echo rupiah($data['price']) ?>
			<?php } ?>
			</div>
		</div>
		</div>
		</div>
	<?php } }else{ ?>
	<div class="col-xs-12 col-sm-12 col-pad">
	<div style="min-height: 350px;">
	<div class="alert alert-info" role="alert">No product(s) found.</div>
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
