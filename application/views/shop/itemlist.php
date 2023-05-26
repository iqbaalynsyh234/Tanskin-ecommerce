<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-slider/slider.css">
<style type="text/css">
.slider-handle {
    position: absolute;
    top: 3px;
    width: 15px;
    height: 15px;
    background-color: #000000;
    background-image: -webkit-linear-gradient(top,#000000 0,#000000 100%);
    background-image: -o-linear-gradient(top,#337ab7 0,#2e6da4 100%);
    background-image: linear-gradient(to bottom,#000000 0,#000000 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7',endColorstr='#ff2e6da4',GradientType=0);
    filter: none;
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
    box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
    border: 0 solid transparent;
    cursor: pointer;
}
.slider.slider-horizontal {
    margin-top: 10px;
}
.loading {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	width: 45px;
	height: 45px;
	border: 4px solid #f3f3f3;
	border-top: 4px solid #3498db;
	border-radius: 50%;
	animation: spin 1s linear infinite;
}

@keyframes spin {
	0% {
		transform: translate(-50%, -50%) rotate(0deg);
	}
	100% {
		transform: translate(-50%, -50%) rotate(360deg);
	}
}
</style>

<div id="wrap-content">
<div class="container">
<div class="row">
	<div class="col-sm-12" style="position: relative;">

	

	<div class="item-content">

	<div class="title-page" style="margin-bottom: 50px;">
	<div class="view-menu"><span class="caret"></span> Menu</div>
	<h1><?php echo ($section != 'all') ? ucwords($section) : 'Semua Produk'; ?></h1>
	<?php /*/ ?>
	<div class="view-item hide">
	<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Sort
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="#">Default</a></li>
    <li><a href="#">Name (A - Z)</a></li>
    <li><a href="#">Name (Z - A)</a></li>
    <li><a href="#">Price (Low - High)</a></li>
    <li><a href="#">Price (High - Low)</a></li>
    <li><a href="#">Latest - Oldest</a></li>
    <li><a href="#">Oldest - Latest</a></li>
  </ul>
</div>
	</div>
	<div class="list-menu-category">
		<ul>
			<?php if(!empty($sub_kategori)) { foreach ($sub_kategori as $key => $value) { ?>
			<li><a href="<?php echo base_url('shop/catalog/'.$value['link']) ?>" class="nav-item"><span><?php echo ucwords($value['kategori']) ?></span></a></li>
			<?php } } ?>
		</ul>
	</div>
<?php /*/ ?>
	</div>

	<div class="item-content-left side-open">
	<div id="sidesticky">
	<div class="wrap-menu-side">
	<h2 class="side-title">Category</h2>

	<div class="hirarki_kategori">
	<?php echo $kategori ?>
	</div>
	</div>
	<?php /*/ ?>
	<div class="wrap-menu-side">
	<h2 class="side-title">Price</h2>
	<p>Filter by price interval: </p><b>IDR 100.000</b>  <b class="pull-right">IDR 1.000.000</b><br>
	<div><input id="ex2" type="text" class="span2" value="" data-slider-min="10000" data-slider-max="1000000" data-slider-step="5" data-slider-value="[100000,400000]"/></div>
	</div>
	<div class="wrap-menu-side hide">
	<h2 class="side-title">Brands</h2>
	<ul class="side-list">
		<a href="#"><li class="nav-item"><span>Lorem Ipsum</span></li></a>
		<a href="#"><li class="nav-item"><span>Dolor</span></li></a>
		<a href="#"><li class="nav-item"><span>Sit Amet</span></li></a>
		<a href="#"><li class="nav-item"><span>Voluptua Inciderint</span></li></a>
		<a href="#"><li class="nav-item"><span>Molestiae</span></li></a>
	</ul>
	</div>
	<?php /*/ ?>
	</div>
	</div>

	<div class="item-content-right side-open">
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
			  <div id="loading-animation" class="loading"></div>
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

	<?php if (isset($links)) { ?>
	<div class="col-xs-12 col-sm-12 col-pad">
	<nav aria-label="Page navigation" class="text-right">
    <?php echo $links ?>
    </nav>
    </div>
    <?php } ?>
		
	</div>
	</div>
	</div>

	
	</div>
</div>
</div>
</div>
<script>
	window.addEventListener('DOMContentLoaded', (event) => {
		// Show the loading animation
		document.getElementById('loading-animation').style.display = 'block';

		// Hide the loading animation and show the image when it's loaded
		document.getElementById('product-image').addEventListener('load', function() {
			document.getElementById('loading-animation').style.display = 'none';
			document.getElementById('product-image').style.display = 'show';
		});
	});
</script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sticky-kit/jquery.sticky-kit.min.js"></script>
<script type="text/javascript">
$(function(){

	$('.view-menu').on('click', function(){
		$('.item-content-left, .item-content-right').toggleClass('side-open');
	});

	$("#ex2").slider();
	
	$(".item-content-left").stick_in_parent().on("sticky_kit:stick", function(e) {
		$(this).addClass('stuked');
  	}).on("sticky_kit:unstick", function(e) {
  		$(this).removeClass('stuked');
  	});

});
</script>