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
	<h3 class="box-title">List</h3>
	<a href="<?php echo base_url('master/brand/add') ?>" class="box-tools btn btn-success"><i class="fa fa-plus"></i> Tambah Brand</a>
	</div>
	<div class="box-body">
	<form action="<?php echo base_url('process_entersite/brand_action') ?>" method="post">
	<div class="form-group action-btn hide">

		<button type="submit" name="action" value="publish" class="btn btn-sm btn-default"><i class="fa  fa-eye"></i>&nbsp;Publish</button>

  		<button type="submit" name="action" value="unpublish" class="btn btn-sm btn-default"><i class="fa fa-eye-slash"></i>&nbsp;Unpublish</button>

		<button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>

  	</div>
	<table id="table01" class="table table-bordered">
		<thead>
			<tr>
				<th class="no-sort" width="10">
		        <input type="checkbox" id="selectAll" />
		        </th>
				<th>No.</th>
				<th>Brand</th>
				<th>Code Brand</th>
				<th>Publish</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $key => $value) { ?>
			<tr>
				<td><input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $value['ID_brand'] ?>"></td>
				<td><?php echo $key + 1 ?></td>
				<td><a href="<?php echo base_url('master/brand/edit/'.$value['ID_brand']) ?>"><?php echo $value['brand_name'] ?></a></td>
				<td><?php echo $value['brand_code'] ?></td>
				<td><?php echo ($value['publish'] == 1) ? 'Yes' : 'No'; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	</form>
	
	</div>
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
function init_action(row){
  if(row > 0){
    $('.action-btn').removeClass('hide');
  }else{
    $('.action-btn').addClass('hide');
  }
}

$(function(){
	$('#table-01').DataTable({
	    "columnDefs": [{
	      "targets": 'no-sort',
	      "orderable": false,
	    }]
	});

	$('#selectAll').click(function (e) {
	    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
	    var chlength = $('.checktbl:checked').length;
	    init_action(chlength);
	});

	$('.checktbl').click(function(){
	var chlength = $('.checktbl:checked').length;
	var tblength = $('#table-01 tbody tr').length;
	    if(chlength == tblength){
	      $('#selectAll').prop('checked', this.checked);
	    }else{
	      $('#selectAll').prop('checked', false);
	    }
	    init_action(chlength);
	});

});
</script>