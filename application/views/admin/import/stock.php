<section class="content-header">
      <h1>
        Marketplace Stock Update
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Marketplace</a></li>
        <li><a href="#">Stock</a></li>
      </ol>
</section>


<section class="content">
    <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Marketplace Stock</h3>
            </div>     
    </div>

<div class="row">
<div class="col-md-4">
<form action="<?php echo base_url('import/stockmarketplace/') ?>tokopedia" class="box" methode="get">
<div class="box-header with-border">
<h3 class="box-title">Tokopedia</h3>
</div>
<div class="box-body form-inline">
  <div class="form-group">
  <input type="number" class="form-control" name="percentase" value="30" max="100" required>
  <button type="submit" class="btn btn-default">Download</button>
</div>
</div>
</form>
</div>

<div class="col-md-4">
<form action="<?php echo base_url('import/stockmarketplace/') ?>zalora" class="box" methode="get">
<div class="box-header with-border">
<h3 class="box-title">Zalora</h3>
</div>
<div class="box-body form-inline">
<input type="number" class="form-control" name="percentase" value="30" max="100" required>
  <button type="submit" class="btn btn-default">Download</button>
</div>
</form>
</div>

<div class="col-md-4">
<form action="<?php echo base_url('import/stockmarketplace/') ?>shopee" class="box" methode="get">
<div class="box-header with-border">
<h3 class="box-title">Shopee</h3>
</div>
<div class="box-body form-inline">
<input type="number" class="form-control" name="percentase" value="30" max="100" required>
  <button type="submit" class="btn btn-default">Download</button>
</div>
</form>
</div>

<div class="col-md-4">
<form action="<?php echo base_url('import/stockmarketplace/') ?>blibli" class="box" methode="get">
<div class="box-header with-border">
<h3 class="box-title">Blibli</h3>
</div>
<div class="box-body form-inline">
<input type="number" class="form-control" name="percentase" value="30" max="100" required>
  <button type="submit" class="btn btn-default">Download</button>
</div>
</form>
</div>

<div class="col-md-4">
<form action="<?php echo base_url('import/stockmarketplace/') ?>lazada" class="box" methode="get">
<div class="box-header with-border">
<h3 class="box-title">Lazada</h3>
</div>
<div class="box-body form-inline">
<input type="number" class="form-control" name="percentase" value="30" max="100" required>
  <button type="submit" class="btn btn-default">Download</button>
</div>
</form>
</div>

</div>
</section>
