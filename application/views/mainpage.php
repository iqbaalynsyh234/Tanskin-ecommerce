<!doctype html>
<?php
require 'vendor/autoload.php';

use Xendit\Xendit;

Xendit::setApiKey('xnd_public_development_1ioVugjr6NcqAjDWmskmCT0ORycVQwSri48N2Fo7gktHXrNuGhN9Dyk7BmsXc');

// $id = '63c0e47ba59ff7c3537117bb';
// Melihat Invoice
// $getInvoice = \Xendit\Invoice::retrieve($id);
// echo '<pre>';
// print_r($getInvoice);
// echo '</pre>';

// Invoice Kadaluarsa
// $expireInvoice = \Xendit\Invoice::expireInvoice($id);
// echo '<pre>';
// print_r($expireInvoice);
// echo '</pre>';

?>
<?php 
	$page_title = (!empty($title)) ? $title.' | ' : '';
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $page_title.get_data('store')['title'] ?></title>
<meta name="author" content="miefta">
<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
<meta name="keywords" content="<?php echo get_data('store')['meta_keyword'] ?>">
<meta name="description" content="<?php echo get_data('store')['meta_deskripsi'] ?>">

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/image/favicon/favicon50.png') ?>"> 
<link rel="apple-touch-icon" href="<?php echo base_url('assets/image/favicon/favicon50.png') ?>"> 
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/image/favicon/favicon50.png') ?>"> 
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets/image/favicon/favicon.png') ?>"> 
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('assets/image/favicon/favicon.png') ?>">

<link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/fontawesome/all.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ego-style.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">

   
<?php 
if(!empty($css)):
	foreach ($css as $style) echo '<link rel="stylesheet" type="text/css" href="', base_url(), 'assets/', $style ,'.css"/>'; 
endif;
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/validate/jquery.validate.js"></script>
<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";
</script>
<?php 
if(!empty($js)):
	foreach ($js as $script) echo '<script type="text/javascript" src="', base_url(), 'assets/', $script ,'.js"></script>';
endif;
?>


    
</head>
<body>
<section id="wrapper">
<header id="header">
<?php echo $header ?>
</header>

<?php echo $content; ?>

<section id="footer" class="<?php echo ($this->uri->segment(1) == '') ? 'ig-feed' : ''; ?>">
<?php echo $footer ?>
</section>	
</section>

<script type="text/javascript">
//function alert
function alert_notification(type, message){
  if(message == null){ }else{
  $(".status-alert-view").addClass('open');
  $(".status-alert-view.open").append('<div class="alert '+type+' alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+message+'</div>');
  }
}

$('.dropdown').click(function(){
  $('.nav-arrow').removeClass('fa-angle-down');
  $('.nav-arrow').removeClass('fa-angle-left');
  $(this).find('.nav-arrow').removeClass('fa-angle-left');
  $(this).find('.nav-arrow').addClass('fa-angle-down');
 });

$(function(){
var RightHeight  = parseInt(window.innerHeight)-476;
var LeftHight    = $('.item-content-left').innerHeight();
if(LeftHight >= RightHeight){
$('.item-content-right').css('min-height', LeftHight);

}else{
$('.item-content-right').css('min-height', RightHeight);

}
});
</script>

<script>
// JavaScript code
var dropdown = document.getElementById("dropdown-menu");

dropdown.addEventListener("change", function() {
  var selectedOption = dropdown.options[dropdown.selectedIndex];
  var selectedValue = selectedOption.value;
  
  // Perform any actions based on the selected value
  console.log("Selected value:", selectedValue);
  // You can add more logic here based on the selected value
});
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VH8RL11TTQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VH8RL11TTQ');
</script>

</body>
</html>