<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fancybox/css/jq-fancybox.css">
<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60c584029e82e296"></script>

<div id="wrap-content">
<div class="container">

<ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>">Home</a></li>
  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
  <li class="active">Products</li>
  <li class="active"><?php echo $data->ItemName ?></li>
</ol>

<div class="row" style="padding-bottom: 50px;">
<div class="col-sm-6 col-xs-12">
<div class="info-product relative">

<div id="carousel-detail-item" class="carousel carousel-fade slide" data-ride="carousel" data-interval="false">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-detail-item" data-slide-to="0" class="active"><img src="<?php echo base_url().'assets/image/product/'.$data->image1 ?>" alt="#"></li>
    <?php if($data->image2 != ''){ ?>
    <li data-target="#carousel-detail-item" data-slide-to="1"><img src="<?php echo base_url().'assets/image/product/'.$data->image2 ?>" alt="#"></li>
    <?php } if($data->image3 != ''){ ?>
    <li data-target="#carousel-detail-item" data-slide-to="2"><img src="<?php echo base_url().'assets/image/product/'.$data->image3 ?>" alt="#"></li>
    <?php } if($data->image4 != ''){ ?>
    <li data-target="#carousel-detail-item" data-slide-to="3"><img src="<?php echo base_url().'assets/image/product/'.$data->image4 ?>" alt="#"></li>
    <?php } if($data->image5 != ''){ ?>
    <li data-target="#carousel-detail-item" data-slide-to="4"><img src="<?php echo base_url().'assets/image/product/'.$data->image5 ?>" alt="#"></li>
    <?php } if($data->image6 != ''){ ?>
    <li data-target="#carousel-detail-item" data-slide-to="5"><img src="<?php echo base_url().'assets/image/product/'.$data->image6 ?>" alt="#"></li>
    <?php } if($data->video != ''){ ?>
    <li class="relative yt-video" data-target="#carousel-detail-item" data-slide-to="6"><img src="<?php echo base_url().'assets/image/product/'.$data->image1 ?>" alt="#"><i class="fa fa-play"></i></li>
	<?php } ?>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image1 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image1 ?>" alt="#">
    </a>
    </div>
    <?php if($data->image2 != ''){ ?>
    <div class="item">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image2 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image2 ?>" alt="#">
    </a>
    </div>
    <?php } if($data->image3 != ''){ ?>
    <div class="item">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image3 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image3 ?>" alt="#">
    </a>
    </div>
    <?php } if($data->image4 != ''){ ?>
    <div class="item">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image4 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image4 ?>" alt="#">
    </a>
    </div>
    <?php } if($data->image5 != ''){?>
    <div class="item">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image5 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image5 ?>" alt="#">
    </a>
    </div>
    <?php } if($data->image6 != ''){?>
    <div class="item">
    <a class="fancybox" href="<?php echo base_url().'assets/image/product/'.$data->image6 ?>" data-fancybox="imagezoom">
      <img src="<?php echo base_url().'assets/image/product/'.$data->image6 ?>" alt="#">
    </a>
    </div>
    <?php } if($data->video != ''){ ?>
    <div class="item video-wrapper">
    	<img src="<?php echo base_url().'assets/image/product/'.$data->image6 ?>" alt="#">
    	<iframe id="iframe" src="https://www.youtube.com/embed/<?php echo $data->video ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
	<?php } ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-detail-item" role="button" data-slide="prev">
    <span class="control-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-detail-item" role="button" data-slide="next">
    <span class="control-chevron-right"></span>
  </a>

  

</div>
	
	</div>
	</div>
	<div class="col-sm-6 col-xs-12">
	<div class="info-product">
	<section class="info-head">
		<h1><?php cetak($data->ItemName) ?></h1>
		<p><?php cetak($data->ItemNmDesc) ?></p>
		<?php if($data->ItemDisc > 0){ ?>
		<h2><p><span style="text-decoration: line-through;">&nbsp;IDR <?php echo rupiah($data->ItemPrice) ?>&nbsp;</span>
		<?php if($data->ItemDisc <= 100){ 
			$disc = $data->ItemPrice - (($data->ItemPrice*$data->ItemDisc)/100);
			echo ' &nbsp;&nbsp;<span style="color:#c50f0f">Disc '.$data->ItemDisc.'%</span>'; 
		} else {
			$disc = $data->ItemPrice - $data->ItemDisc; 
			echo ' &nbsp;&nbsp;<span style="color:#c50f0f">(- '.rupiah($data->ItemDisc).')</span>'; } 
		?></p>
		<b><?php echo 'IDR '.rupiah($disc) ?></b>
		</h2>

		<?php }else{ ?>
		<h2>IDR <?php echo rupiah($data->ItemPrice) ?></h2>
		<?php } ?>
		
	</section>
	<section class="info-body">
	<div class="row row-mar">
	<?php 
	
	if($coloritem->num_rows() > 1){
	
	?>
	<div class="col-sm-12 col-xs-12 col-pad">
	<b>Available Color</b>
	<div class="option-color">
	<ul>
		<?php foreach ($coloritem->result() as $color) { 
			if($this->uri->segment(4) == $color->ID_colorname){
				$active = 'yes';
				$linkproduk = '#';
			}else{
				$active = '';
				$linkproduk = base_url().'shop/products/'.$data->url.'/'.$color->ID_colorname;
			}
		
		?>
		<li>
		<a href="<?php echo $linkproduk ?>" class="isActive <?php echo $active ?>" title="<?php echo $color->ColorName ?>">
			<!-- <div class="coloring" style="background-color: <?php //echo $color->ColorCode ?>"></div> -->
			<img src="<?php echo base_url('assets/image/product/').$color->image1 ?>" class="op-image">
		</a>
		</li>
		<?php } ?>
	</ul>
	</div>
	</div>
	<?php } 
	if($sizeitem->num_rows() > 0 && ($data->ItemType != 1 && $data->ItemType != 2)){
	?>
	<div class="col-sm-12 col-xs-12 col-pad form-group size">
		<div class="row">
			<label class="col-sm-2 control-label">
				Size
			</label>
			<div class="col-sm-10">
				<div class="option-size">
				<?php foreach ($sizeitem->result() as $size ) { 
					if($data->size == $size->size){ $ss = 'selected'; }else{ $ss = ''; }
					if($size->stock == 0){ $st = 'disabled'; }else{ $st = ''; }
	        	echo '<span class="'.$ss.' '.$st.'" data-size="'.$size->size.'" data-stock="'.$size->stock.'">'.strtoupper($size->Size).'</span>';
	        	}?>
					<div class="clearfix"></div>
					<div class="error-placement"></div>
				</div>
			</div>
		</div>
	<!-- <b>Size</b> -->
	<!-- <div class="option-size">
		<select class="form-control select2" onchange="initSize(this.value);" style="width: 150px">
	        <option value="false" selected="selected">Select Size</option>
	    </select>
	    <br>
	    <span class="error-placement"></span>
	</div> -->
	</div>
	<!-- <button type="submit" id="btn-buy" class="btn btn-add-to-cart disabled">BUY NOW</button> -->
	<?php 
		}
		if($stock_item > 0){
			$quantity = '';
			$qval     = 1;
			$btn_buy  = '<button type="submit" id="btn-buy" class="btn btn-add-to-cart">BUY NOW</button>';
			if($stock_item > 5){
				$max  = 5;
			}else{
				$max  = $stock_item;
			}
		}else{
			$quantity = 'disabled';
			$qval     = 0;
			$btn_buy  = '<button type="button" class="btn btn-add-to-cart oos">OUT OF STOCK!</button>';
			$max      = 0;
		}
	?>
	<div class="qty form-group col-sm-12 col-pad">
		<div class="row">
        <label class="col-sm-2 control-label">
        	<span class="hidden-xs">Quantity</span><span class="visible-xs">Qty</span>
        </label>
        <div class="col-sm-10">
        <div class="input-group number-spinner">
        	<span class="input-group-btn">
				<button type="button" class="btn btn-default" data-dir="dwn" <?php echo $quantity ?>><i class="fa fa-minus"></i></button>
			</span>
			<input style="z-index: 0;" type="text" min="1" max="<?php echo $max ?>" step="1" autocomplete="off" id="qtyPro" class="form-control text-center" name="qtypro" data-inc="<?php echo encode64($idmap); ?>" data-cart="<?php echo encode64($data->ItemCode); ?>" data-type="<?php echo $data->ItemType ?>" value="<?php echo $qval ?>" <?php echo $quantity ?>>
        	<span class="input-group-btn">
				<button type="button" class="btn btn-default" data-dir="up" <?php echo $quantity ?>><i class="fa fa-plus"></i></button>
			</span>
        </div>
    	</div>
    	</div>
        </div>
	</div>

	</section>
	<section class="info-body">
		<div class="add-to-cart">

		<?php echo $btn_buy ?>
		
		</div>
	</section>
	<section class="info-footer">
		<ul class="social-media addthis_toolbox" addthis:title="<?php cetak($data->ItemName) ?>" addthis:url="<?php echo current_url() ?>" addthis:description="<?php cetak($data->ItemNmDesc) ?>">
			<li class="mainli" style="background-color: #FFF;">Share</li>
			<a href="#" class="addthis_button_facebook" target="_blank" title="Facebook">
				<li><i class="fab fa-facebook-f inner-center"></i></li>
			</a>
			<a href="#" class="addthis_button_twitter" target="_blank" title="Twitter">
				<li><i class="fab fa-twitter inner-center"></i></li>
			</a>
			<a href="#" class="addthis_button_whatsapp" target="_blank" title="Whatsapp">
				<li><i class="fab fa-whatsapp inner-center"></i></li>
			</a>
		</ul>

		<div class="item-description">
		<b>Description</b><br>
		<?php echo $data->ItemDescription ?>
		<span id="collapse_description" data-html="more">more <i class="fa fa-angle-down"></i></span>
		</div>
	</section>
	
	</div>
	</div>
</div>

<?php if($other_product->num_rows() > 0){ ?>
<div class="others-item">
<h2 class="text-center">Other Products</h2>
<div class="row row-mar">
<?php

foreach ($other_product->result() as $data) {
	if($data->ItemType == 2 || $data->ItemType == 4){
		$uricolor = '/'.my_slug($data->ID_colorname);
	}else{
		$uricolor = '';
	}
	$linkproduk = $data->url.$uricolor;
?>
	<div class="col-xs-6 col-sm-3 col-pad">
		<div class="box-item">
		<a href="<?php echo base_url().'shop/products/'.$linkproduk ?>">
		<div class="box-image-show">
			<img src="<?php echo base_url().'assets/image/product/'.$data->image1 ?>" alt="">
			<div class="inner-center">
				<div class="hover-cart"></div>
			</div>
		</div>
		</a>
		<div class="box-item-info">
			<div class="product_name"><a href="<?php echo base_url().'shop/products/'.$linkproduk ?>">
			<span><b><?php echo $data->ItemName ?></b></a></div>
			<div class="product_shortdesc"><?php echo $data->ItemNmDesc ?></div>
			<div class="product_price">
			<?php if($data->disc > 0){ ?>
			<span class="disc-notif">
			<?php if($data->disc <= 100){ echo $data->disc.'% off'; 
			} else{ echo '- '.rupiah($data->disc); } ?>
			</span>
			<span style="text-decoration: line-through">&nbsp;IDR <?php echo rupiah($data->price) ?>&nbsp;</span><br>
			<span style="color: #F44336;">
			<?php 
				if($data->disc <= 100){ 
					echo 'IDR '.rupiah($data->price - ($data->price*$data->disc)/100);
				} else {
					echo 'IDR '.rupiah($data->price - $data->price);
				}
			?>
			</span>
			<?php } else { ?>
			IDR <?php echo rupiah($data->price) ?>
			<?php } ?>
			</div>
		</div>
		</div>
	</div>
<?php } ?>
	
</div>
</div>
<?php } ?>

</div>
</div>
<script src="<?php echo base_url() ?>assets/plugins/fancybox/js/jq-fancybox.js"></script>
<script type="text/javascript">


var	current_c  = $('#qtyPro'),
	data_inc   = current_c.attr('data-inc'),
	data_cart  = current_c.attr('data-cart'),
	data_type  = current_c.attr('data-type'),
	s          = parseInt(current_c.attr('max')), 
	uk         = '';
if(data_type > 2){
	var array = [];
	$('.option-size span').each(function(e){
		var sz    = $(this).attr('data-size');
		var st    = $(this).attr('data-stock');
		array[e] = [sz, st];
	});
	localStorage.setItem("data", JSON.stringify(array));
}


function initCart(){
		if(isNaN(s)){ s = 0; }
		if( data_type > 2 ){
			var on = $('.option-size span.selected'),
				uk = on.data('size'),
				ex = on.index();
			if (typeof(Storage) !== "undefined") {
				uk = JSON.parse(localStorage.getItem('data'))[ex][0];
				s  = JSON.parse(localStorage.getItem('data'))[ex][1];
				on.attr('data-size', uk); on.attr('data-stock', s);
				current_c.attr('max', s);
			} else {
				if( uk == '' || uk == 'undefined' || uk == null ){
					s = 0;
					$('.option-size .error-placement').html('*This field is required.');
					$('html, body').animate({
			        scrollTop: $(".info-head").offset().top
			    	}, 1000);
				}
			}
		}

		if(s > 0){
			var qty = current_c.val(); 
			$.ajax({
	        url: "<?php echo base_url().'shop/addtocart' ?>",
	        type: "POST",
	        cache: false,
	        data: {item: data_inc, hash: data_cart, size: uk, qty: qty},
	        dataType:'json',
	        headers: {'X-Requested-With': 'XMLHttpRequest'},
	        success: function(json){
		            if(json.status == '1'){
	                    $('.status-alert-view span').html(json.message);
	                    $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
	                    $('.status-alert-view').addClass('open').delay(1500).queue(function(next){
	                    $(this).removeClass('open');
	                    $('.status-alert-view span').html('');
	                    next();
	                    });
	                }
	                if(json.status == '0'){
	                    $('.status-alert-view span').html(json.message);
	                    $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
	                    $('.status-alert-view').addClass('open').delay(5000).queue(function(next){
	                    $(this).removeClass('open');
	                    $('.status-alert-view span').html('');
	                    next();
	                    });
	                }
	        	 }
	    	});
		}
}

function initBtnBuy(stock){
	if(stock > 0){
		$('.info-body .qty .btn, .info-body .qty input').attr('disabled', false);
		$('.info-body .qty input').val(1);
		$('.add-to-cart').html('<button type="submit" id="btn-buy" class="btn btn-add-to-cart">BUY NOW</button>');
	}else{
		$('.info-body .qty .btn, .info-body .qty input').attr('disabled', true);
		$('.info-body .qty input').val(0);
		$('.add-to-cart').html('<button type="button" class="btn btn-add-to-cart oos">OUT OF STOCK</button>');
	}
}

$(function(){


	$('body').on('click', '#btn-buy', function(e){
		e.preventDefault();
		initCart();
	});

	$('#collapse_description').on('click', function(){
		var x = $(this).data('html');
		$('.item-description').toggleClass('open');
		if(x == 'more'){
			$(this).data('html', 'less');
			$(this).html('less <i class="fa fa-angle-up"></i>');
		}else{
			$(this).data('html', 'more');
			$(this).html('more <i class="fa fa-angle-down"></i>');
		}
	});

	$('.option-size').on('click', 'span', function(){
		var $this  = $(this);
		var eq     = $this.index();
		if (typeof(Storage) !== "undefined") {
			var stock = JSON.parse(localStorage.getItem('data'))[eq][1];
			var size  = JSON.parse(localStorage.getItem('data'))[eq][0];
			$this.attr('data-size', size); $this.attr('data-stock', stock);
		}else{
			var stock = $this.data('stock');
		}
		$('.option-size span').each(function(){
			$('.option-size span').not(this).removeClass('selected');
		});
		if(isNaN(stock)){ stock = 0; }
		$this.addClass('selected');
		$('#qtyPro').attr('max', stock);
		$('.option-size .error-placement').html('');
		initBtnBuy(stock);
	});

	$('.int-cart span').load("<?php echo base_url();?>shop/badgecart");

    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

 	$('body').on('click', '.number-spinner button', function () {    
	var btn      = $(this),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
		maxVal   = parseInt(btn.closest('.number-spinner').find('input').attr('max')),
		newVal   = 0;
	
		if (btn.attr('data-dir') == 'up') {
			if(oldValue < maxVal ){
				newVal = parseInt(oldValue) + 1;
			} else {
				newVal = oldValue;
			}
		} else {
			if (oldValue > 1) {
				newVal = parseInt(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		btn.closest('.number-spinner').find('input').val(newVal);
	
	}); 

	$("#qtyPro").on('change', function(){
		var value = $(this).val();
		if(isNaN(value) || value > s){
			value = 1;
		}
		$(this).val(value);
	});


});
</script>

