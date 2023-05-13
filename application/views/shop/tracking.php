<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Tracking</li>
	</ol>
	</div>
	</div>
	<div class="item-content">
    <div class="item-content-left side-open">
	<div class="nav-menu-page">
		<?php $this->load->view('shop/menu-page'); ?>
	</div>
	</div>


	<div class="item-content-right side-open">
	    <div class="row">
      <div class="col-sm-12">
      <div class="page-side-box" style="padding-bottom: 127px">
      <h3>Tracking</h3>

      <?php if($tracking_status == TRUE) { 
        if(!empty( $tracking['cnote']['cnote_no'])) { ?>
      <div>Nomor Resi: <?php echo $tracking['cnote']['cnote_no'] ?></div>
      <div class="row">
        <div class="col-md-6">
          Tanggal Pengiriman : <?php echo $tracking['cnote']['cnote_date'] ?><br>
          Penerima : <?php echo $tracking['detail']['cnote_date'] ?>
        </div>
        <div class="col-md-6">
          Status : <span class="red"><?php echo $tracking['cnote']['cnote_receiver_name'] ?></span>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6">
          
          <ul class="tracking-detail">
            <?php foreach ($tracking['history'] as $key => $value) { ?>
            <li><strong><?php echo date('d M Y', strtotime($value['date'])) ?></strong><span class="time"><?php echo date('H:i', strtotime($value['date'])) ?></span>
              <div class="desc">
                <?php echo $value['desc'] ?>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { echo $tracking['error']; } } else { echo $status; } ?>
      </div>
      </div>
      </div>
	</div>
	</div>

</div>
</div>	