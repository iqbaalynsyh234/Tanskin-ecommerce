<link rel="stylesheet" href="<?php echo base_url().'assets/' ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
      <h1>
        Brand
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Master</li>
        <li class="active">Brand</li>
      </ol>
</section>

<section class="content">
<div class="row row-mar">
	<div class="col-sm-12 col-pad">
	<div class="box">
		
		
		<div class="box-header with-border">
		<h3 class="box-title">Tambah Brand</h3>
		
		</div>
		<div class="box-body">
		
		<form id="form" action="<?php echo base_url('master/brand/add') ?>" method="post" novalidate="novalidate">
	      <div class="modal-body">
	          <div class="row row-mar">
	          <div class="col-sm-6 col-pad">
	            <div class="form-group">
	                <label>Brand Name</label>
	                <input type="text" name="brand_name" class="form-control valid" value="" required>
	            </div>
	          </div>

	          <div class="col-sm-6 col-pad">
	            <div class="form-group">
	                <label>Brand Code</label>
	                <input type="text" minlength="4" maxlength="4" name="brand_code" class="form-control valid" value="" required>
	            </div>
	          </div>
	          
	          <div class="col-sm-4 col-pad">
	          <div class="form-group">
	          <label>Publish</label>
	                  <div class="radio">
	                    <label>
	                      <input type="radio" name="publish" value="1" checked="">
	                      Yes
	                    </label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label>
	                      <input type="radio" name="publish" value="2">
	                      No
	                    </label>
	                  </div>
	                </div>
	          </div>

	          </div>
	          
	          
	      </div>
	      <div class="modal-footer">
	        <button type="submit" name="submit" class="btn btn-primary">Add Brand</button>
	      </div>
	      </form>
		</div>
	</div>

	
	</div>

	</div>

</div>
</section>

<script type="text/javascript">
	$(function(){
		$('#form').validate();

		$(".sidebar-menu li:nth-child(4)").addClass('active');
		$(".sidebar-menu .treeview-menu li").removeClass('active');
		$(".sidebar-menu .treeview-menu li:first-child").addClass('active');
	});
</script>
