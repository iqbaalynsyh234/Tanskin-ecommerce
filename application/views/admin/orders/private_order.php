<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.min.css">
<section class="content-header">
      <h1>
        Private Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Order</li>
        <li class="active">Private Order</li>
     </ol>
</section>

<section class="content">
<div class="row">
	<div class="col-sm-6">
		<div class="box">
		  <div class="box-header with-border">
		  	<h3 class="box-title">Data Pembeli</h3>
		  </div>
		  <div class="box-body">
		  	<div class="row row-mar">
		  		<div class="col-sm-12 col-pad">
			    <div class="form-group">
			    <label style="display: block">Nama</label>
			        <input type="text" class="form-control" name="name" required>
			    </div>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
			    <label style="display: block">Email</label>
			        <input type="email" class="form-control" name="email">
			    </div>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
			    <label style="display: block">No. Telepon / Handphone</label>
			        <input type="number" class="form-control" name="telepon" required>
			    </div>
			    </div>

			    <div class="col-sm-12 col-pad">
			    <div class="form-group">
			    <label style="display: block">Alamat</label>
			        <textarea class="form-control" rows="3" name="alamat" required></textarea>
			    </div>
			    </div>

			    <div class="col-sm-12 col-pad">
			    <div class="form-group">
	            <label class="control-label">Provinsi</label>
	                <select class="form-control showprov select2" name="provinsi" onchange="init_getcity(this.value);" style="width: 100%;">
	                  <option selected="selected" value="">-- choose a province --</option>
	                  <?php foreach ($province as $i => $key) { ?>
	                    <option value="<?php echo $key['propinsi'] ?>"><?php echo ucwords(strtolower($key['propinsi'])) ?></option>
	                  <?php } ?>
	                </select>
	            </div>
			    </div>



			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
	            <label class="control-label">Kota / Kabupaten</label>
	                <select class="form-control showcity select2" name="kota" onchange="init_getdistrict(this.value)" style="width: 100%;" disabled>
	                </select>
	            </div>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
	            <label class="control-label">Kecamatan</label>
	                <select class="form-control showdistrict select2" name="kecamatan"  onchange="init_getsubdistrict(this.value)" style="width: 100%;" disabled>
	                </select>
	            </div>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
	            <label class="control-label">Desa</label>
	                <select class="form-control showsubdistrict select2" name="desa" style="width: 100%;" disabled required>
	                </select>
	            </div>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <div class="form-group">
			    <label style="display: block">Kode Pos</label>
			        <input type="text" class="form-control" name="zip_code">
			    </div>
			    </div>

		  	</div>
		  </div>

		  
		</div>
	</div>

	<div class="col-sm-6">
		<div class="box">
		  <div class="box-header with-border">
		  	<h3 class="box-title">Daftar Belanja</h3>
		  </div>

		  <div class="box-body">
		  	<table class="table table-bordered table-striped">
		  		<thead>
		  			<tr>
		  				<th>No.</th>
		  				<th>Item</th>
		  				<th>Qty</th>
		  				<th class="text-right">Price</th>
		  			</tr>
		  		</thead>
		  		<tbody id="load_list">
		  			
		  		</tbody>
		  	</table>
		  </div>
		  <div class="box-footer text-right">
		  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_product" disabled>Tambah</button>
		  </div>

		</div>
	</div>

	<div class="col-sm-6">
		<div class="box">
		  <div class="box-header with-border">
		  	<h3 class="box-title">Pengiriman</h3>
		  </div>

		  <div class="box-body">
		  	<div class="row row-mar">
		  		<div class="col-sm-12 col-pad">
			    <div class="form-group">
			        <select class="form-control select2 shipping_option" name="pengiriman" disabled required>
			        	
			        </select>
			    </div>
			    </div>
		  	</div>
		  </div>
		</div>
	</div>


	<div class="col-sm-6">
		<div class="box">
		  <div class="box-body">
		  	<div class="row row-mar">
		  		<div class="col-sm-6 col-pad">
			    <h2 class="box-title" style="margin: 10px 0px;"><b>TOTAL</b></h2>
			    </div>
			    <div class="col-sm-6 col-pad text-right">
			    <h2 id="total_amount" class="box-title" data-total="<?php echo $this->cart->total() ?>" style="margin: 10px 0px;"><b><?php echo rupiah($this->cart->total()) ?></b></h2>
			    </div>
		  	</div>
		  </div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="box">
		  <div class="box-body">
		  	<div class="row row-mar">
		  		<div class="col-sm-6 col-pad">
			    <button type="reset" class="btn btn-lg btn-danger btn-block">Reset</button>
			    </div>

			    <div class="col-sm-6 col-pad">
			    <button type="submit" class="btn btn-lg btn-success btn-block">Submit</button>
			    </div>
		  	</div>
		  </div>
		</div>
	</div>

</div>
</section>


<div class="modal fade" id="modal_product" tabindex="-1" role="dialog" aria-labelledby="modal_productLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_productLabel">Products</h4>
      </div>
      <form id="addtocart" action="<?php echo base_url('admin/private-order/addcart') ?>" method="post">
      <div class="modal-body">
      	<div class="row">
        	<div class="col-sm-10">
	        	<select class="form-control select2" name="item_id" style="width: 100%;" required>
	        		<option value="">--Pilih Produk--</option>
	        		<?php foreach ($item as $key => $value) { ?>
	        			<option value="<?php echo $value['ID_ms'] ?>"><?php echo $value['ItemCode'].' / '.$value['ItemName'].' / '.$value['colorname'].' / '.$value['sizename'] ?></option>
	        		<?php } ?>
	        	</select>
	        	<input type="hidden" name="id_return">
	        </div>
	        <div class="col-sm-2">
	        	<input type="number" name="qty" class="form-control" required placeholder="qty" min="1">
	        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/validate/jquery.validate.js"></script>
<script type="text/javascript">
function init_getcity(prov){
    $.ajax({
        url: base_url + "checkout/getcity",
        type: "POST",
        cache: false,
        data:'prov=' + prov,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '1'){
              $('.showcity').html(json.data);
              $('.showcity').prop('disabled', false);
              $('.showdistrict').html('');
              $('.showdistrict').prop('disabled', true);
            }
            if(json.status == '0'){
              $('.showcity, .showdistrict').html('');
              $('.showcity, .showdistrict').prop('disabled', true);
            }
        }
    });
}

function init_getdistrict(city){
    var prov = $('.showprov').val();
    $.ajax({
        url: base_url + "checkout/getdistrict",
        type: "POST",
        cache: false,
        data:'prov=' + prov + '&city=' + city,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '1'){
              $('.showdistrict').html(json.data);
              $('.showdistrict').prop('disabled', false);
            }
            if(json.status == '0'){
              $('.showdistrict').html('');
              $('.showdistrict').prop('disabled', true);
            }
        }
    });
}

function init_getsubdistrict(district){
    var prov = $('.showprov').val();
    var city = $('.showcity').val();
    $.ajax({
        url: base_url + "checkout/getsubdistrict",
        type: "POST",
        cache: false,
        data:'prov=' + prov + '&city=' + city + '&district=' + district,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '2'){
            	<?php if($this->cart->total_items() > 0) : ?>
            	init_getshipping_cost(json.selected);
            	<?php endif; ?>
                $('.showsubdistrict').html(json.data);
                $('.showsubdistrict').prop('disabled', false);
            }
            if(json.status == '1'){
              $('.showsubdistrict').html(json.data);
              $('.showsubdistrict').prop('disabled', false);
            }
            if(json.status == '0'){
              $('.showsubdistrict').html('');
              $('.showsubdistrict').prop('disabled', true);
            }
        }
    });
}

function init_getshipping_cost(area){
	$('.shipping_option').prop('disabled', true);
    $.ajax({
        url: base_url + "checkout/getdnewcost",
        type: "POST",
        cache: false,
        data:'area=' + area,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '1'){
              $('.shipping_option').html(json.data);
              $('.shipping_option').prop('disabled', false);
            }
            if(json.status == '0'){
              $('.shipping_option').html('');
              $('.shipping_option').prop('disabled', true);
            }
        }
    });
}

$(function(){
	$("#load_list").load(base_url + "admin/private-order/load_cart");
	$(".select2").select2();

	$(".showsubdistrict").on('change', function(){
	    var zip = $(this).find(':selected').data('zip');
	    $('input[name="zip_code"]').val(zip); 
	    <?php if($this->cart->total_items() > 0) : ?>
	    init_getshipping_cost($(this).val());
	    <?php endif; ?>
	});

	$("#addtocart").validate({
		errorPlacement: function(error, element) {},
		submitHandler: function (form) {
		$.ajax({
	        url: form.action,
	        type: form.method,
	        cache: false,
	        data: $(form).serialize(),
	        dataType: 'json',
	        headers: {'X-Requested-With': 'XMLHttpRequest'},
	        success: function(json){
	            if(json.status == '0'){
	            	$("#load_list").load(base_url + "admin/private-order/load_cart");
	            	$('#modal_product').modal('hide');
	            }
	        }
	    });
		}

	});

	$("body").on("click", ".delete_cart", function(){
		var rowid = $(this).closest('tr').data('rowid');
		$.ajax({
	        url: base_url + "admin/private-order/delete",
	        type: "POST",
	        cache: false,
	        data:'rowid=' + rowid,
	        dataType: 'json',
	        headers: {'X-Requested-With': 'XMLHttpRequest'},
	        success: function(json){
	            if(json.status == '1'){
	            	$("#load_list").load(base_url + "admin/private-order/load_cart");
	            }
	        }
	    });
	});

	$(".shipping_option").on("change", function(){
		var total_1 = $("#total_amount").data('total');
		var total_2 = $(this).val();

		$("#total_amount b").text(total_1 + total_2);
	});
});
</script>