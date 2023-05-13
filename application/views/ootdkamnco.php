<div id="wrap-content">
<div class="container">
<ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>">Home</a></li>
  <li class="active">#OOTDKamnco</li>
</ol>

<div class="banner-image">
	<img class="w-100" src="<?php echo base_url('assets/image/media/page-banner-ootd-1.png') ?>">
</div>

<div id="ootdkamnco" class="row row_md">
	<?php foreach ($ootd as $key => $value) { ?>
	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 col_md">
		<div class="item">
			<a href="#" target="_blank">
			<span class="inner-image" style="background-image: url(<?php echo base_url('img/ootd/'.$value['gambar']) ?>)"></span>
			</a>
		</div>
	</div>
	<?php } ?>

	<div class="col-xs-12 hide">
		<div class="text-center mt-5">
			<button type="button" class="btn btn-main btn-main-black btn-def">Load More</button>
		</div>
	</div>
</div>


</div>
</div>