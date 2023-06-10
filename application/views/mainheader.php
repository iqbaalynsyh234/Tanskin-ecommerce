<?php 
if($this->session->flashdata('alert_flash') != null){
  $alert_status  = 'open';
  $alert_message = $this->session->flashdata('alert_flash');
}
else
{
  $alert_status = ''; $alert_message = '';
}
?>
<style>
  #menu-list li {
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

#menu-list li.d-none {
  display: none;
}

#menu-list li:not(.d-none) {
  opacity: 1;
  transform: translateY(0);

}
</style>
<div class="status-alert-view <?php echo $alert_status ?>">
<span>
<?php echo $alert_message; ?>
</span>
</div>

<?php 
if($this->uri->segment(1) == 'checkout'){
  $this->load->view('checkout/header');
} else {
?>

<script src="<?php echo base_url(); ?>assets/js/run.js"></script>

<nav class="navbar navbar-default navbar-shop navbar-fixed-top">
<div class="head-nav-top hidden-xs hidden-sm">
  <div class="container">
    <div class="pull-left hidden-xs">
      <a href="<?php echo base_url('shop/confirm-payment'); ?>" class="nav-item"><span>Payment Confirmation</span></a> &nbsp;|&nbsp; <a href="<?php echo base_url('shop/order-status'); ?>" class="nav-item"><span>Order Status</span></a>
    </div>
    <div class="pull-right">
      <?php 
      $menu_help = select_all_row("static_page", array("kategori" => 8, "publish" => "11")); foreach ($menu_help as $key => $value) { 
        $sparate = (($key + 1) < count($menu_help)) ? ' &nbsp;|&nbsp; ' : '';
      ?>
        <a href="<?php echo base_url('page/'.$value['link']) ?>" class="nav-item"><span><?php echo ucwords(strtolower($value['section'])) ?></span></a>
      <?php echo $sparate; } ?>
      <!-- <a href="<?php echo base_url('page/help') ?>" class="nav-item"><span>Help</span></a> &nbsp;|&nbsp; <a href="<?php echo base_url('page/support') ?>" class="nav-item"><span>Support</span></a> -->
    </div>
  </div>
</div>
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
    <ul class="visible-xs visible-sm nav-menu-mobile pull-left">
    <li class="btn-nav-btn">
        <button class="menu-mob-icon">
          <span></span>
        </button>
    </li>
    </ul>
    <ul class="visible-xs nav-menu-mobile">
    <li class="search-icon-nav"><i class="fal fa-search fa-2x"></i></li>
    <li>
      <a href="<?php echo base_url() ?>shop/cart" class="">
        <i class="fal fa-shopping-bag fa-2x"></i>
        <div class="int-cart"><span></span></div></a>
    </li>
    </ul>
      <a class="navbar-brand" href="<?php echo base_url() ?>">
      <img src="<?php echo base_url('assets/image/logo/'.get_data('store')['brand_logo']) ?>" alt="<?php echo get_data('store')['nama_toko'] ?>">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="hidden-xs" style="position: relative;">
      <ul class="nav navbar-nav navbar-left hidden-sm">
        <li><a href="<?php echo base_url() ?>" class="nav-item text-uppercase"><span>Home</span></a></li>
        <li><a href="<?php echo base_url('shop/catalogue') ?>" class="nav-item text-uppercase"><span>Products</span></a></li>
        <li><a href="<?php echo base_url('contact') ?>" class="nav-item text-uppercase"><span>Contact</span></a></li>
        <li><a href="<?php echo base_url('page/skin-test') ?>" class="nav-item text-uppercase"><span>SKIN TEST</span></a></li>
        <li><a href="<?php echo base_url('page/marketplace') ?>" class="nav-item text-uppercase"><span>Marketplace</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="search-icon-nav"><i class="far fa-search"></i></li>
        <li class="hidden-sm">
          <?php if($this->session->userdata('login') == true){ ?>
          <a href="<?php echo base_url() ?>shop/account" class="nav-item">
            <i class="fal fa-user-circle fa-2x"></i></a>
        <?php } else { ?>
          <a href="<?php echo base_url() ?>shop/account">
            <i class="fal fa-user-circle fa-2x"></i>
          </a>
        <?php } ?>
        
        <?php if($this->session->userdata('login') == true){ ?>
        <div class="sub-menu sub-menu--mini">
          <div class="wrap-menu-sub row row-mar">
          <div class="col-sm-12 col-pad">
          <h2>Account</h2>
          <ul  class="list-menu-sub">
            <li><a href="<?php echo base_url().'shop/account/user-profile' ?>" class="nav-item"><span>My Account</span></a></li>
            <li><a href="<?php echo base_url().'shop/confirm-payment' ?>" class="nav-item"><span>Confirm Payment</span></a></li>
            <li><a href="<?php echo base_url().'shop/order-status' ?>" class="nav-item"><span>Orders Status</span></a></li>
            <li><div class="line"></div></li>
            <li><a href="<?php echo base_url().'shop/logout' ?>"><div>Logout
            <span class="pull-right" style="padding-right: 5px; margin-top: 2px;"><i class="fa fa-power-off"></i></span>
            </div></a></li>
          </ul>
          </div>
          </div>
        </div>
        <?php } ?>
        </li>
        <li>
          <a href="<?php echo base_url() ?>shop/cart" class="">
            <span>
              <i class="fal fa-shopping-bag fa-2x"></i>
            </span>
            <div class="int-cart"><span></span></div></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

    </div>
</nav>
 <div class="form-search-head">
 <div class="container">
 <div class="wrap-search">
    <form action="<?php echo base_url('shop/search_key') ?>" method="post">
      <div class="input-group">
          <input type="text" class="form-control" name="key" placeholder="Search Products">
          <div class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
      </div>
      <div class="clearfix"></div>
    </form>

  </div>
  </div>
  </div>

<div id="menu-nav-mob">

<div class="wrapper-menu-left">
  <ul class="menu-one">
  <li class="li-one"><a href="<?php echo base_url('shop/account') ?>"><div>
  <?php if($this->session->userdata('login') == true){ 
        echo 'HAI, '.strtoupper($this->session->userdata('fname')); } else { ?>
        ACCOUNT
        <?php } ?>
  </div></a></li>
  
  <ul class="menu-one">
  <li class="li-one">PRODUCT CATEGORY
  <i class="fa fa-caret-down" id="toggle-button"></i>
  <a href="<?php echo base_url('shop/catalogue/') ?>"><div>
  <?php
    $menu = select_all_row("category", array('publish' => '11', 'parent_id' => 0));
  ?>

  <ul id="menu-list">
    <?php foreach ($menu as $key => $value) { ?>
      <li class="li-one">
        <a href="<?php echo base_url('shop/catalogue/'.$value['link']) ?>"><div><?php echo strtoupper($value['kategori']) ?></div></a>
      </li>
     <?php } ?>
  </ul>

  <?php if($this->session->userdata('login') == true){ ?>
    <li class="li-one"><a href="<?php echo base_url('shop/logout') ?>"><div>KELUAR</div></a></li>
  <?php } ?>

  <ul class="menu-one">
  <li class="li-one">FOLLOW US
     <i class="fab fa-instagram"></i>
  </ul>

</div>
</div>

</script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $("#menu-list li").each(function(index) {
    $(this).delay(index * 200).queue(function() {
      $(this).removeClass("d-none").dequeue();
    });
  });
});

$("#toggle-button").click(function() {
  $("#menu-list li").each(function(index) {
    $(this).toggleClass("d-none");
  });
});
</script>
<?php 
}
?>