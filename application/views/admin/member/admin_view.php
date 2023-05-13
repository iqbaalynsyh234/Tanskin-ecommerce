<section class="content-header">
      <h1>
        Administrator
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Add</li>
      </ol>
</section>

<form action="" method="post">
<section class="content">
  <div class="box">
  <div class="box-header with-border">
  	<h3 class="box-title">Data</h3>
  </div>
  <div class="box-body">
  	<div class="row">
  		<div class="col-sm-6">
  			<button type="button" class="btn btn-warning">Reset</button>
  			<a href="<?php echo base_url('admin/administator') ?>" class="btn btn-success"><i class="fa fa-reply"></i> Back</a>
  		</div>
  		<div class="col-sm-6 text-right">
  			<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Submit</button>
  		</div>
  	</div>
  	<hr>
  	<div class="row">
  		<div class="col-sm-6">
  			<div class="form-group">
  				<label>User Name</label>
  				<input type="text" name="name" class="form-control" value="<?php echo $row['user_admin'] ?>" required>
  			</div>
  			<div class="form-group">
  				<label>Email</label>
  				<input type="email" name="email" class="form-control" value="<?php echo $row['email_admin'] ?>" required>
  			</div>
  			<div class="form-group">
  				<label>Password</label>
  				<input type="password" name="password" class="form-control" value="">
  			</div>
  		</div>
  		<div class="col-sm-6">
        <div class="form-group">
  			<label>Akses</label>
  			<div class="checkbox">
			  <label>
			    <input type="checkbox" name="akses_1" value="1" <?php echo ($row['akses1'] == '11') ? 'checked' : '' ?>>
			    Produk, Data Master
			  </label>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" name="akses_2" value="1" <?php echo ($row['akses2'] == '11') ? 'checked' : '' ?>>
			    Marketplace, Data Penjualan
			  </label>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" name="akses_3" value="1" <?php echo ($row['akses3'] == '11') ? 'checked' : '' ?>>
			    Content Website, Static Pages
			  </label>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" name="akses_4" value="1" <?php echo ($row['akses4'] == '11') ? 'checked' : '' ?>>
			    Orders, Voucher
			  </label>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" name="akses_5" value="1" <?php echo ($row['akses5'] == '11') ? 'checked' : '' ?>>
			    Administrator, Settings
			  </label>
			</div>

      <div class="checkbox">
        <label>
          <input type="checkbox" name="del_akses" value="1" <?php echo ($row['del_akses'] == '11') ? 'checked' : '' ?>>
          Delete Products
        </label>
      </div>
    </div>

      <div class="form-group">
        <label>Status Akun</label>
        <div class="radio">
          <label>
            <input type="radio" name="status" id="status" value="11" <?php echo ($row['status'] == '11') ? 'checked' : '' ?>>
            Active
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="status" id="status" value="01" <?php echo ($row['status'] == '01') ? 'checked' : '' ?>>
            Non Active
          </label>
        </div>
      </div>

  		</div>
  	</div>
  </div>
  </div>
</section>



</form>
