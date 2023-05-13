<?php 
$segment = $this->uri->segment(3);
?>
<div class="box-body">
<ul class="nav nav-tabs">
   <li <?php if($segment == '' || $segment == 'store') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/store'; ?>">Store</a></li>
   <?php /* ?>
   <li <?php if($segment == 'delivery') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/delivery'; ?>">Delivery</a></li>
   <li <?php if($segment == 'shipping') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/shipping'; ?>">Shipping Method</a></li>
   <li <?php if($segment == 'bank') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/bank'; ?>">Rekening Bank</a></li>
   <?php */ ?>
   <li <?php if($segment == 'web') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/web'; ?>">Web Setting</a></li>
   <li <?php if($segment == 'social-media') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/social-media'; ?>">Social Media</a></li>
   <li <?php if($segment == 'marketplace') { echo 'class="active"'; } ?>><a href="<?php echo base_url().'entersite/setting/marketplace'; ?>">Marketplace</a></li>
</ul>
</div>