<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">

<section class="content-header">
      <h1>
        Categories
        <small>Lorem ipsum dolor sit amet.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Category</li>
      </ol>
</section>

<section class="content">
<div class="row row-mar">
	<div class="col-sm-12 col-pad">
	<div class="box">
	<div class="box-header with-border">
	<h3 class="box-title">Kategori Produk</h3>
	<a href="<?php echo base_url().'entersite/product/categories/add' ?>" class="box-tools btn btn-success"><i class="fa fa-plus"></i> Tambah Kategori</a>
	</div>
	
	<div class="box-body">
	<form action="<?php echo base_url('process_entersite/categories_action'); ?>" method="post">
	<div class="form-group action-btn hide">

  	<button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
  
  	<button type="submit" name="action" value="publish" class="btn btn-sm btn-default"><i class="fa  fa-eye"></i>&nbsp;Publish</button>

  	<button type="submit" name="action" value="unpublish" class="btn btn-sm btn-default"><i class="fa fa-eye-slash"></i>&nbsp;Unpublish</button>

  	</div>
	<table id="table-01" class="table table-bordered">
		<thead>
			<tr>
				<th class="no-sort" width="10">
		        <input type="checkbox" id="selectAll" />
		        </th>
				<th>Categories</th>
				<th width="200px" class="text-center">Parents</th>
				<th width="200px" class="text-center">Special Type</th>
				<th width="100px" class="text-center">Publish</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$no = 1;
		foreach($list_categories->result() as $key){
		?>
			<tr>
				<td><input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $key->ID_cat; ?>"></td>
				<td><a href="<?php echo base_url('entersite/product/categories/edit/'.$key->ID_cat) ?>"><?php echo ucfirst($key->kategori) ?></a></td>
				<td><?php echo ucfirst($key->parent1) ?></td>
				<td><?php echo ucfirst($key->special_type) ?></td>
				<td align="center"><?php echo publish($key->publish) ?></td>
			</tr>
		<?php $no++; } ?>
		</tbody>
	</table>
	</form>

	<br><br>
	</div>
	
	</div>
	</div>


</div>
</section>

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