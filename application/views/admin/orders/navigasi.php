<?php 
$segment = $this->uri->segment(3);
?>
<style type="text/css">
	.bad-pos{
		position: absolute;
	    right: 2px;
	    top: -5px;
	}
</style>
<div class="box-body">
<ul class="nav nav-tabs">
   <li <?php if($segment == '' || $segment == 'all') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/all'; ?>">All Orders</a> 
   </li>
   <li <?php if($segment == 'new') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/new'; ?>">New Ordes</a>
   	<small class="label pull-right bg-red bad-pos"><?php echo $badges['new'] ?></small>
   </li>
   <li <?php if($segment == 'payment') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/payment'; ?>">Payment Confirmations</a>
   	<small class="label pull-right bg-red bad-pos"><?php echo $badges['pay'] ?></small>
   </li>
   <li <?php if($segment == 'shipping') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/shipping'; ?>">Shippings Orders</a>
   </li>
   <li <?php if($segment == 'cancel') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/cancel'; ?>">Cancel Orders</a>
   </li>
   <li <?php if($segment == 'sent') { echo 'class="active"'; } ?>>
   	<a href="<?php echo base_url().'entersite/orders/sent'; ?>">Sent Orders</a>
   </li>
   <li>
   	<a href="<?php echo base_url().'entersite/awb'; ?>">Cetak AWB</a>
   </li>  
</ul>
</div>