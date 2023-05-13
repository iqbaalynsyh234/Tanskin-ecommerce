<?php $section = $this->uri->segment(3); ?>
<ul class="nav nav-tabs">
   <li class="<?php if($section == 'about'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/about' ?>">About</a></li>
   <li class="<?php if($section == 'support'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/support' ?>">Support</a></li>
   <li class="<?php if($section == 'term-and-conditions'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/term-and-conditions' ?>">Tern &amp; Conditions</a></li>
   <li class="<?php if($section == 'privacy-policy'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/privacy-policy' ?>">Privacy Policy</a></li>
   <li class="<?php if($section == 'member-policy'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/member-policy' ?>">Member Policy</a></li>
   <li class="<?php if($section == 'faq'){ echo 'active'; }else{ } ?>"><a href="<?php echo base_url().'entersite/static_page/faq' ?>">F A Q</a></li>
</ul>