<link rel="stylesheet" href="<?php echo base_url().'assets/' ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
      <h1>
        Size
        <small>Lorem ipsum dolor sit amet.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Size</li>
      </ol>
</section>

<section class="content">
<div class="row row-mar">
	<div class="col-sm-6 col-pad">
	<div class="box">
	
	<form action="<?php echo base_url().'entersite/addcolor' ?>" method="post">
	<div class="box-header with-border">
	<h3 class="box-title">Added a new colors</h3>
	</div>
	<div class="box-body">
	
		<div class="row">
		<div class="form-group col-sm-12">
		<label>Color Code</label>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group my-colorpicker2">
	            	  <div class="input-group-addon">
	                    <i></i>
	                  </div>
	                  <input type="text" class="form-control" name="colorcode[]">
	            </div>
			</div>
			<div class="col-sm-6">
				<div class="input-group my-colorpicker2">
	            	  <div class="input-group-addon">
	                    <i></i>
	                  </div>
	                  <input type="text" class="form-control" name="colorcode[]">
	            </div>
			</div>
		</div>
            
        </div>
        <div class="form-group col-sm-12">
        <label>Color Name</label>
            <input type="text" class="form-control" name="colorname" required>
        </div>
        </div>
    <div class="text-right">
	<button class="btn btn-default" type="submit" name="submitcolor" value="true">Submit</button>
	</div>
	</div>
	</form>
	
	
	<div class="box-header with-border">
	<h3 class="box-title">List</h3>
	</div>
	<div class="box-body">
	<form action="<?php echo base_url('process_entersite/delete_batch/ID_color/color') ?>" method="post">
	<div class="form-group action-btn">
  	<button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
  	</div>
	<table id="table01" class="table table-bordered">
		<thead>
			<tr>
				<th class="no-sort" width="10">
					<input type="checkbox" class="selectAll" />
				</th>
				
				<th>Color</th>
				<th>No.</th>
				<th>Color Name</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$no = 1;
		foreach ($listcolor->result() as $color) {
		?>
		<tr>
			<td>
			<input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $color->ID_color; ?>">
			</td>
			
			<td class="text-uppercase"><button class="btn btn-xs" style="background-color: <?php echo $color->ColorCode ?> ;">&nbsp;&nbsp;&nbsp;</button>&nbsp;&nbsp; <?php echo $color->ColorCode ?></td>
			<td width="20px;"><?php echo $no ?></td>
			<td class="text-uppercase"><?php echo $color->ColorName ?></td>
		</tr>
		<?php $no ++; }  ?>
		</tbody>
	</table>
	</form>
	
	</div>
</div>

	
	</div>

	
	<div class="col-sm-6 col-pad">
	<div class="box">
	<form action="<?php echo base_url().'entersite/addsize' ?>" method="post">
	<div class="box-header with-border">
	<h3 class="box-title">Added a new size</h3>
	</div>
	<div class="box-body">
	
		<div class="form-group row">
        <div class="col-sm-12">
        <label>Size</label>
            <input type="text" class="form-control" name="size" required>
        </div>
        </div>
    <div class="text-right">
	<button class="btn btn-default" type="submit" name="submitsize" value="true">Submit</button>
	</div>
	</div>
	</form>
	
	<div class="box-header with-border">
	<h3 class="box-title">List</h3>
	</div>
	<div class="box-body">

	<form action="<?php echo base_url('process_entersite/delete_batch/ID_size/size') ?>" method="post">
	<div class="form-group action-btn hide">

  	<button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>

  	</div>
	<table id="table02" class="table table-bordered">
		<thead>
			<tr>
				<th class="no-sort" width="10">
					<input type="checkbox" class="selectAll" />
				</th>
				<th>Size</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($listsize->result() as $size) {
		?>
		<tr>
			<td>
			<input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $size->ID_size; ?>">
			</td>
			<td class="text-uppercase"><?php echo $size->Size ?></td>
		</tr>
		<?php }  ?>
		</tbody>
	</table>
	</form>
	
	</div>
	</div>
	</div>

</div>
</section>
<script src="<?php echo base_url() ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
function init_action(row, place){
  if(row > 0){
    place.removeClass('hide');
  }else{
    place.addClass('hide');
  }
}
$(function(){
	$(".my-colorpicker2").colorpicker();
	$('#table01, #table02').DataTable({
		"columnDefs": [{
		      "targets": 'no-sort',
		      "orderable": false,
		    }]
	});
	$('.selectAll').click(function (e) {
	    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
	    var chlength = $(this).closest('table').find('.checktbl:checked').length,
	    	place    = $(this).closest('form').find('.action-btn');
	    init_action(chlength, place);
	});

	$('body .checktbl').click(function(){
	var chlength = $(this).closest('table').find('.checktbl:checked').length,
	    tblength = $(this).closest('tabel').find('tbody tr').length,
	    place    = $(this).closest('form').find('.action-btn');
	    if(chlength == tblength){
	      $('.selectAll').prop('checked', this.checked);
	    }else{
	      $('.selectAll').prop('checked', false);
	    }
	    init_action(chlength, place);
	});
});
</script>