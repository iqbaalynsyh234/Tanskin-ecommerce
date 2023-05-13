<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">Confirm Payment</li>
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
	<h3>Orders Status</h3>
		<form action="#" method="post" class="row">
		<div class="col-sm-6">
		<div class="form-group">
            <label>Email Pembeli</label>
            <input type="email" class="form-control">
        </div>
		<div class="form-group">
            <label>No. Order</label>
            <input type="number" class="form-control">
        </div>
        </div>
        <div class="col-sm-12">
        <hr>

        <button type="submit" class="btn btn-main-black">Submit</button>
        <br><br>
        <p>Khusus untuk 'Beli tanpa Login'</p>
        </div>
		</form>
	</div>
	</div>
	</div>
	</div>
	</div>
</div>
</div>