<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin :: E-commerce</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo base_url('assets/image/favicon/favicon50.png') ?>">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>css/admin-custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- jQuery 2.2.3 -->
<script src="<?php echo base_url().'assets/' ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
  var base_url = "<?php echo base_url(); ?>";
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url().'assets/' ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/validate/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/simpleclock/simpleClock.min.js"></script>
</head>
<body class="hold-transition skin-black sidebar-mini fixed">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('entersite') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>AN</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>TAN</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          
          <!-- User Account: style can be found in dropdown.less -->
          <li><a href="<?php echo base_url(); ?>" target="_blank"><?php echo base_url(); ?></a></li>
          <li class="tasks-menu">
            <a href="javascript:void(0);">
            <div id="clock">
              <div id="time"></div>
              <div class="datetime"><?php echo date('d M Y'); ?></div>
            </div>
            </a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url().'assets/' ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucfirst($this->session->userdata('user_admin')) ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url().'assets/' ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucfirst($this->session->userdata('user_admin')) ?> - Admin
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url('entersite/logout-admin') ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url().'assets/' ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ucfirst($this->session->userdata('user_admin')) ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        
        <!-- <li><a href="#">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a></li> -->

        <li><a href="<?php echo base_url().'entersite/view-website' ?>">
        <i class="fa  fa-laptop"></i> <span>Website Page</span>
        </a></li>

        <?php if($this->session->userdata('akses_01') == '11'){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bookmark"></i>
            <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'entersite/product/list' ?>"><i class="fa fa-circle-o"></i> Products</a></li>
            <li><a href="<?php echo base_url().'entersite/barcode' ?>"><i class="fa fa-circle-o"></i> Barcode</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bookmark"></i>
            <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'master/brand' ?>"><i class="fa fa-circle-o"></i> Brand</a></li>
            <li><a href="<?php echo base_url().'master/product-master' ?>"><i class="fa fa-circle-o"></i> Product</a></li>
            <li><a href="<?php echo base_url().'entersite/product/categories' ?>"><i class="fa fa-circle-o"></i> Categories</a></li>
            <li><a href="<?php echo base_url().'entersite/product/color-and-size' ?>"><i class="fa fa-circle-o"></i> Color & Size</a></li>
            <li><a href="<?php echo base_url().'master/adjustment' ?>"><i class="fa fa-circle-o"></i> Adjustment Stock</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if($this->session->userdata('akses_02') == '11'){ ?>
        <li class="treeview hide">
          <a href="#">
            <i class="fa fa-bookmark"></i>
            <span>Marketplace</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'import/tokopedia' ?>"><i class="fa fa-circle-o"></i> Tokopedia</a></li>
            <li><a href="<?php echo base_url().'import/zalora' ?>"><i class="fa fa-circle-o"></i> Zalora</a></li>
            <li><a href="<?php echo base_url().'import/blibli' ?>"><i class="fa fa-circle-o"></i> BliBli</a></li>
            <li><a href="<?php echo base_url().'import/lazada' ?>"><i class="fa fa-circle-o"></i> Lazada</a></li>
            <li><a href="<?php echo base_url().'import/shopee' ?>"><i class="fa fa-circle-o"></i> Shopee</a></li>

            <li><a href="<?php echo base_url().'import/stock' ?>"><i class="fa fa-circle-o"></i> Stock</a></li>
            <?php /* ?>
            
            <li><a href="<?php echo base_url().'import/akulaku' ?>"><i class="fa fa-circle-o"></i> Akulaku</a></li>
            <li><a href="<?php echo base_url().'import/bukalapak' ?>"><i class="fa fa-circle-o"></i> Bukalapak</a></li>
            <li><a href="<?php echo base_url().'import/meesho' ?>"><i class="fa fa-circle-o"></i> Meesho</a></li>
            <li><a href="<?php echo base_url().'import/lazada' ?>"><i class="fa fa-circle-o"></i> Lazada</a></li>
            <?php */ ?>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>Data Penjualan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'entersite/packing' ?>"><i class="fa fa-circle-o"></i> Packing <span class="label label-warning pull-right"><?php echo badge('pos', array('table_packing' => 0)) ?></span></a></li>
            <li><a href="<?php echo base_url().'entersite/penjualan' ?>"><i class="fa fa-circle-o"></i> Penjualan</a></li>
            <li><a href="<?php echo base_url().'admin/return-order/form' ?>"><i class="fa fa-circle-o"></i> Pengembalian & Penukaran</a></li>
          </ul>
        </li>

        
        <?php } ?>

        <?php if($this->session->userdata('akses_03') == '11'){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-crop"></i>
            <span>Content Website</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('entersite/content/sliders'); ?>"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="<?php echo base_url('entersite/banner'); ?>"><i class="fa fa-circle-o"></i> Banner</a></li>
            <li><a href="<?php echo base_url('entersite/image'); ?>"><i class="fa fa-circle-o"></i> Image Home</a></li>
          </ul>
        </li>

        <li><a href="<?php echo base_url().'entersite/static-page' ?>">
        <i class="fa fa-file"></i> <span>Static Pages</span>
        </a></li>
        <?php } ?>

        <?php if($this->session->userdata('akses_04') == '11'){ ?>
       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>Voucher</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'admin/voucher/template_voucher' ?>"><i class="fa fa-circle-o"></i> Template</a></li>
            <li><a href="<?php echo base_url().'entersite/voucher' ?>"><i class="fa fa-circle-o"></i>Voucher Code</a></li>
            <li><a href="<?php echo base_url().'admin/voucher/voucher_used' ?>"><i class="fa fa-circle-o"></i>Vouchers List</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-exchange"></i>
            <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url().'entersite/orders/all' ?>"><i class="fa fa-circle-o"></i> All Orders</a></li>
            <li><a href="<?php echo base_url().'entersite/orders/new' ?>"><i class="fa fa-circle-o"></i> New Orders</a></li>
            <li><a href="<?php echo base_url().'entersite/orders/payment' ?>"><i class="fa fa-circle-o"></i> Payment Confirmations</a></li>
            <li><a href="<?php echo base_url().'entersite/orders/shipping' ?>"><i class="fa fa-circle-o"></i> Shippings Orders</a></li>
            <li><a href="<?php echo base_url().'entersite/orders/sent' ?>"><i class="fa fa-circle-o"></i> Sent Orders</a></li>
            <li><a href="<?php echo base_url().'entersite/orders/cancel' ?>"><i class="fa fa-circle-o"></i> Cancel Orders</a></li>
            <li><a href="<?php echo base_url().'entersite/awb' ?>"><i class="fa fa-circle-o"></i> Cetak AWB</a></li>
            <li><a href="<?php echo base_url().'admin/private-order' ?>"><i class="fa fa-circle-o"></i> Private Order</a></li>
            <li><a href="<?php echo base_url().'admin/private-order/listdata' ?>"><i class="fa fa-circle-o"></i> Private Order List</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($this->session->userdata('akses_05') == '11'){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('admin/administator') ?>"><i class="fa fa-circle-o"></i> Administator</a></li>
            <li><a href="<?php echo base_url('entersite/members/customers') ?>"><i class="fa fa-circle-o"></i> Customers</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="<?php echo base_url().'entersite/setting' ?>">
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
          </a>
        </li>

        <li class="treeview">
          <a href="<?php echo base_url().'entersite/subscriber' ?>">
            <i class="fa fa-envelope"></i>
            <span>Subscribers</span>
          </a>
        </li>
        
        <?php } ?>
        
        <li class="treeview" style="height: 50px;">
        </li>

        <li class="treeview logout-admin">
          <a href="<?= base_url('entersite/logout-admin') ?>"><i class="fa fa-power-off"></i></a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <?php if($this->session->flashdata('set_meja')!=null && $this->uri->segment(2) == 'packing'){ ?>
      <div style="padding: 0px 15px; padding-bottom: 0px">
      <div class="alert alert-warning alert-dismissible" style="margin-bottom: 0px; margin-top: 5px">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4 style="margin-bottom: 0px;"><?php echo $this->session->flashdata('set_meja') ?></h4>
       </div>
      </div>
      <?php } if($this->session->flashdata('alert_errors')!=null){ ?>
      <div style="padding: 0px 15px; padding-bottom: 0px">
      <div class="alert alert-warning alert-dismissible" style="margin-bottom: 0px; margin-top: 5px">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4 style="margin-bottom: 0px;"><?php echo $this->session->flashdata('alert_errors') ?></h4>
       </div>
      </div>
      <?php } if($this->session->flashdata('alert_success')!=null) { ?>
      <div style="padding: 0px 15px; padding-bottom: 0px">
      <div class="alert alert-info alert-dismissible" style="margin-bottom: 0px; margin-top: 5px">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4 style="margin-bottom: 0px;"><?php echo $this->session->flashdata('alert_success') ?></h4>
       </div>
      </div>
      <?php } ?>

    <?php echo $content; ?>
<div class="status-alert-view">
<span>
</span>
</div>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer text-right">
    <strong>All Right Discovery &copy; <?php echo date('Y') ?> <a href="#">tanskin.id</a></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <ul class="control-sidebar-menu">
        
          
          

        </ul>
      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
     
      <div class="tab-pane" id="control-sidebar-settings-tab">
        
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
 
  <div class="control-sidebar-bg"></div>
</div>

<!-- ./wrapper -->
<link rel="stylesheet" href="<?php echo base_url().'assets/css/entersite-ego.css' ?>">
<!-- Slimscroll -->
<script src="<?php echo base_url().'assets/' ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url().'assets/' ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url().'assets/' ?>dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url().'assets/' ?>dist/js/demo.js"></script>
<script src="<?php echo base_url().'assets/' ?>js/custome.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var CURRENT_URL = window.location.href.split('#')[0].split('?')[0];

  $('.sidebar').find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active');
  $('.sidebar').find('a[href="' + CURRENT_URL + '"]').closest('.treeview').addClass('active');

  $("#clock").simpleClock();

});
</script>
</body>
</html>
