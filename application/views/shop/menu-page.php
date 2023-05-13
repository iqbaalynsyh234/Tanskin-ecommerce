<div class="wrap-menu-side">
	
	<?php if($this->session->userdata('login') == true){ ?>
	<div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/account/user-profile' ?>" class="nav-item"><span>My Account</span></a></div>
	<div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/account/user-password' ?>" class="nav-item"><span>Password</span></a></div>
	<?php } ?>
	<!-- <div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/faq' ?>" class="nav-item"><span>FAQ</span></a></div> -->
	<div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/confirm-payment' ?>" class="nav-item"><span>Confirm Payment</span></a></div>
	<div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/order-status' ?>" class="nav-item"><span>Order Status</span></a></div>
	<?php if($this->session->userdata('login') == true){ ?>
		<div class="side-title manu-page--menu"><a href="<?php echo base_url().'shop/logout' ?>" class="nav-item"><span>Logout</span></a></div>
	<?php } ?>
</div>