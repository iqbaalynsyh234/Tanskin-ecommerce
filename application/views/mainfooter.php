<?php 
if($this->uri->segment(1) == 'checkout'){ }
else{
?>
<div class="footer-main">
<style>
	
 .fab-icon-holder {
     width: 45px;
     height: 45px;
     bottom: 140px;
     left: 10px;
     color: #FFF;
     background: #5865f2;
     border-radius: 10px;
     text-align: center;
     font-size: 30px;
    z-index: 99999;
 }
 .fab-container {
  position: fixed;
  bottom: 70px;
  right: 10px;
  z-index: 999;
  cursor: pointer;
}
.fab-icon-holder {
  width: 45px;
  height: 45px;
  bottom: 140px;
  left: 10px;
  color: #FFF;
  background: #5865f2;
  border-radius: 100px;
  text-align: center;
  font-size: 30px;
  z-index: 99999;
}
.fab-icon-holder:hover {
  opacity: 0.8;
}
.fab-icon-holder i {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  font-size: 25px;
  color: #050000;
}
.fab-options {
  list-style-type: none;
  margin: 0;
  position: absolute;
  bottom: 48px;
  left: -37px;
  opacity: 0;
  transition: all 0.3s ease;
  transform: scale(0);
  transform-origin: 85% bottom;
}
.fab:hover+.fab-options,
.fab-options:hover {
  opacity: 1;
  transform: scale(1);
}
.fab-options li {
  display: flex;
  justify-content: flex-start;
  padding: 5px;
}

.fab-label {
  padding: 2px 5px;
  align-self: center;
  user-select: none;
  white-space: nowrap;
  border-radius: 3px;
  font-size: 16px;
  background: #666666;
  color: #ffffff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  margin-left: 10px;
}

</style>

<!-- ========CALL CENTER CONTACT========== -->
<div class="fab-container">
    <div class="fab fab-icon-holder" style="background-color:#FFF; padding:5px">
	<div class="fab-icon-holder" style="background-color: #5865F2;">
    <i class="fab fa-instagram"></i>
    </div>
    <ul class="fab-options">
      <li>
        <a href="https://www.instagram.com/novalsyahhhh/" class="text-decoration-none" target="_blank">
          <div class="fab-icon-holder" style="background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%);">
            <i class="fab fa-instagram"></i>
          </div>
        </a>
      </li>
      <li>
        <a href="https://wa.me/6285748638453" class="text-decoration-none" target="_blank">
          <div class="fab-icon-holder" style="background-color: #25D366;">
            <i class="fab fa-whatsapp"></i>
          </div>
        </a>
      </li>
      <li>
        <a href="https://www.tiktok.com/@valsyahh_?_t=8Yyh1RapBNy&_r=1" class="text-decoration-none" target="_blank">
		<div class="fab-icon-holder" style="background-color: #5865F2;">
            <i class="fab fa-tiktok"></i>
          </div>
        </a>
      </li>
    </ul>
    <a href="#" class="act-btn-top text-decoration-none" onclick="toTop()" style="display: none; background-color: #bd4cae; bottom: 19px;" data-cf-modified-3b8231d928fbd77a69f52826-="">
    <i class="fas fa-angle-up mt-2"></i>
    </a>
  </div>
</div> 
<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
	<div class="row row-mar">

		<div class="col-sm-4 col-md-3 col-pad hidden-sm hidden-xs">
		<div class="foot-media">
		<ul class="social-media">
			<li class="mainli">TANSKIN</li>
			<?php foreach(get_data('social_media', array('type' => 0), TRUE) AS $key => $value){ ?>
				<a href="<?php echo $value['url'] ?>" target="_blank"><li><i class="fab fa-<?php echo $value['socialmedia'] ?> inner-center"></i></li></a>
			<?php } ?>
		</ul>
		<form action="<?php echo base_url('processing/atlas_subscribe') ?>" method="post">
			<div class="input-group">
                <input type="email"  name="field_0556" class="form-control" placeholder="SUBSCRIBE">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-angle-right"></i></button>
                </div>
             </div>
		</form>
		</div>
		</div>

		
		
		<div class="col-xs-12 col-sm-12 col-md-6 col-pad">
			<div class="row row-mar">

			<div class="col-xs-6 col-sm-4 col-pad visible-sm visible-xs">
					<h5 style="margin-top: 0px;"><b>HUBUNGI KAMI</b></h5>
					09.00-17.30 WIB (Hari Kerja)<br>

					<a href="<?php echo link_WA(get_data('store')['no_telp'], 'Hi Kamnco') ?>" class="nav-item d-block" target="_blank"><i class="fab fa-whatsapp"></i>&nbsp; <span><?php echo get_data('store')['no_telp'] ?></span></a>
					<a href="mailto:<?php echo get_data('store')['email'] ?>" class="nav-item d-block" target="_blank"><i class="fa fa-envelope"></i>&nbsp; <span><?php echo get_data('store')['email'] ?></span></a>
			</div>

			<div class="col-xs-6 col-sm-4 col-md-4 col-pad">
				<div class="wrap-menu-footer">
				<ul>
					<?php foreach (static_menu(array('kt.title_kategori !=' => 'shop', 'kt.title_kategori !=' => 'description')) as $key => $value) { 
						$static_url    = 'page/'.$value['link'];
					?>
						<li><a href="<?php echo base_url($static_url) ?>" class="nav-item"><span><?php echo $value['section'] ?></span></a></li>
					<?php } ?>
				</ul>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-4 col-pad">
				<div class="wrap-menu-footer mt-xs-3">
				<ul>
					<?php foreach (static_menu(array('kt.title_kategori' => 'shop')) as $key => $value) { 
						$static_url    = 'page/'.$value['link'];
					?>
						<li><a href="<?php echo base_url($static_url) ?>" class="nav-item"><span><?php echo $value['section'] ?></span></a></li>
					<?php } ?>
					<li><a href="<?php echo base_url('contact') ?>" class="nav-item"><span>Contact</span></a></li>
					<li><a href="https://blog.tanskin.id/" target="_blank" class="nav-item"><span>Blog</span></a></li>
				</ul>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-pad">
				<div class="wrap-menu-footer mt-xs-3">
				<ul>
					<li><a href="<?php echo base_url().'shop/account' ?>" class="nav-item"><span>Account</span></a></li>
					<li><a href="<?php echo base_url().'shop/confirm-payment' ?>" class="nav-item"><span>Confirm Payment</span></a></li>
					<li><a href="<?php echo base_url().'shop/order-status' ?>" class="nav-item"><span>Orders Status</span></a></li>
					<?php /*/ ?>
					<li><a href="<?php echo base_url().'shop/faq' ?>" class="nav-item"><span>F A Q</span></a></li>
					<?php /*/ ?>
				</ul>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-pad visible-sm visible-xs">
			<div class="foot-media">
			<ul class="social-media">
				<li class="mainli">TANSKIN</li>
				<?php foreach(get_data('social_media', array('type' => 0), TRUE) AS $key => $value){ ?>
					<a href="<?php echo $value['url'] ?>" target="_blank"><li><i class="fab fa-<?php echo $value['socialmedia'] ?> inner-center"></i></li></a>
				<?php } ?>
			</ul>
			<form action="<?php echo base_url() ?>" method="post">
				<div class="input-group">
	                <input type="text" class="form-control" placeholder="SUBSCRIBE">
	                <div class="input-group-btn">
	                  <button type="button" class="btn btn-default"><i class="fa fa-angle-right"></i></button>
	                </div>
	             </div>
			</form>
			</div>
			</div>
			
			</div>
		</div>

		
		<div class="col-xs-12 col-sm-6 col-md-3 col-pad hidden-xs hidden-sm">
			<div class="fit-right">
				<h5 style="margin-top: 0px;"><b>HUBUNGI KAMI</b></h5>
				09.00-17.30 WIB (Hari Kerja)<br>

				<a href="<?php echo link_WA(get_data('store')['no_telp'], 'Hi TANSKIN') ?>" class="nav-item d-block" target="_blank"><i class="fab fa-whatsapp"></i>&nbsp; <span><?php echo get_data('store')['no_telp'] ?></span></a>
				<a href="mailto:<?php echo get_data('store')['email'] ?>" class="nav-item d-block" target="_blank"><i class="fa fa-envelope"></i>&nbsp; <span><?php echo get_data('store')['email'] ?></span></a>
			</div>
		</div>

	</div>
	</div>
</div>
</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-pad">
				<div class="wrap-menu-footer text-center">
				<ul class="footer-payment">
					<li class="icon midtrans"></li>
					<li class="icon ship-jne"></li>
				</ul>

				<?php if(count(get_data('social_media', array('type' => 1), TRUE)) > 0){ ?>
				<h5 style="margin-top: 0px;"><b>KAMI JUGA HADIR DI:</b></h5>
				<?php } ?>
				<ul class="footer-payment">
					<?php foreach(get_data('social_media', array('type' => 1), TRUE) AS $key => $value){ ?>
						<li class="px-1"><a href="<?php echo $value['url'] ?>" target="_blank"><span class="icon <?php echo $value['socialmedia'] ?> d-block"></span></a></li>
					<?php } ?>
				</ul>
				<?php if(count(get_data('social_media', array('type' => 1), TRUE)) > 0){ ?>
					<h5 style="margin-top: 0px;" class="method-payment"><b>DENGAN BERBAGAI METODE PEMBAYARAN:</b></h5>
                 <?php } ?>
				<ul class="footer-payment">
				<img src="assets/image/logo/payment.png" style="height:80px;">
				</ul>
				</div>
		</div>
	</div>
</div>
<div class="foot-print" style="border-top: 1px solid #d5d5d5;">
<div class="container">
	<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
	<div >
	<div class="row row-mar">
		<div class="col-xs-12 text-center">
		<p><small>Copyright © <?php echo date('Y'); ?> TANSKIN - All Right Discovered <a href="https://tanskin.id" target="_blank" style="color: #FF9800">TAN SKIN </a></p>
		</div>
	</div>
	</div>
	</div>
	</div>
</div>
</div>
<?php } ?>

<script type="text/javascript">
$(function(){
	 $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
});
</script>



