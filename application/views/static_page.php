<div id="wrap-content">
<div class="container">
<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Home</a></li>
  <li class="active text-capitalize"><?php echo $page['section']; ?></li>
</ol>


<div class="item-content">
	<div class="item-content-left side-open">
	
	<div class="wrap-menu-side">
	<?php 
	foreach ($menu as $key => $value) { 
		$active = ($value['link'] == $page['link']) ? 'active' : '';
		$url    = ($value['link'] == 'contact') ? '' : 'page/';
	?>
		<div class="side-title manu-page--menu <?php echo $active ?>">
		<a href="<?php echo base_url($url.$value['link']) ?>" class="nav-item">
		<span><?php echo $value['section'] ?></span>
		</a>
		</div>
	<?php } ?>
	</div>

	</div>
	<div class="item-content-right side-open">
	<div class="row">
	<div class="col-sm-12">
	<div id="freetext" class="page-side-box">
	<h3><?php echo $page['section']; ?></h3>

	<?php echo $page['deskripsi']; ?>
	</div>
	</div>
	</div>
	</div>
</div>

</div>
</div>

<script type="text/javascript">
$(function(){
	$("#freetext img").each(function(index, el) {
		$(this).css("max-width", "100%");
	});
});
</script>