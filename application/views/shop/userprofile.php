<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.min.css">
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #555;
    line-height: 34px;
}
.select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #ccc;
}
</style>

<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
    <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">My Account</li>
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
	<div class="page-side-box">
	<h3>My Account</h3>
	<form id="userprofile-form" action="<?php echo base_url().'shop/userprofile-edit' ?>" method="post">
		<div class="row">
			<div class="col-sm-6">
      <div class="form-group">
                  <label>Email address</label>
                  <input type="email" class="form-control" value="<?php echo $account->email ?>" disabled>
            </div>
			<div class="form-group row row-mar">

				<div class="col-sm-6 col-pad">
                  <label>First Name</label>
                  <input type="text" name="fname" class="form-control" value="<?php echo $account->first_name ?>">
                </div>
                <div class="col-sm-6 col-pad">
                <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" value="<?php echo $account->last_name ?>">
                </div>
            </div>
            
            <div class="form-group">
                  <label>Phone</label>
                  <div class="input-group">
	                <span class="input-group-addon">+62</span>
	                <input type="text" name="phone" class="form-control" value="<?php echo $account->phone ?>" autocomplete="false">
	              </div>
            </div>
			</div>
			<div class="col-sm-6">
			<div class="form-group">
                  <label>Address</label>
                  <textarea name="address" class="form-control" rows="3"><?php echo $account->address ?></textarea>
            </div>
            <div class="form-group">
            <label class="control-label">Province&nbsp;&nbsp; </label>
                <select class="form-control select2 showprov" name="cprov" onchange="init_getcity(this.value);" style="width: 100%;">
                  <?php if($account->propinsi == '') { ?>
                  <option selected="selected" value="">-- choose a province --</option>
                  <?php } else { ?>
                  <option selected="selected" value="<?php echo $account->propinsi ?>"><?php echo ucwords(strtolower($account->propinsi)) ?></option>
                  <?php } foreach ($province as $i => $key) { ?>
                    <option value="<?php echo $key['propinsi'] ?>"><?php echo ucwords(strtolower($key['propinsi'])) ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
            <label class="control-label">City&nbsp;&nbsp;</label>
                <select class="form-control select2 showcity" name="ccity" onchange="init_getdistrict(this.value)" style="width: 100%;" disabled>
                  <?php if($account->kabupaten != ''){
                    echo '<option selected="selected" value="'.$account->kabupaten.'">'.ucwords(strtolower($account->kabupaten)).'</option>';
                  } ?>
                </select>
            </div>
            <div class="form-group">
            <label class="control-label">District&nbsp;&nbsp;</label>
                <select class="form-control select2 showdistrict" name="cdist"  onchange="init_getsubdistrict(this.value)" style="width: 100%;" disabled>
                  <?php if($account->kecamatan != ''){
                    echo '<option selected="selected" value="'.$account->kecamatan.'">'.ucwords(strtolower($account->kecamatan)).'</option>';
                  } ?>
               
                </select>
            </div>

            <div class="form-group">
            <label class="control-label">SubDistrict</label>
                <select class="form-control select2 showsubdistrict" name="csubdist" style="width: 100%;" disabled required>
                  
                  <?php if($account->desa != ''){
                    echo '<option selected="selected" value="'.$account->ID.'">'.ucwords(strtolower($account->desa)).'</option>';
                  } ?>

                </select>
            </div>

            <div class="form-group row">
                  <div class="col-sm-6">
                  <label class="control-label">Post Code</label>
                  <input type="text" name="postc" class="form-control" value="<?php echo $account->postcode ?>">
                  </div>
            </div>
			</div>
			<div class="col-sm-12">
			<hr>
			<button class="btn btn-main-black" type="submit" name="edituser" value="<?php echo $account->ID ?>"><i class="fa fa-edit"></i>  Edit Profile </button>
			</div>
		</div>
	</form>
	</div>
	</div>
  </div>
  </div>
  </div>

</div>
</div>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/validate/jquery.validate.js"></script>
<script type="text/javascript">
function init_getcity(prov){
    $.ajax({
        url: "<?php echo base_url().'checkout/getcity' ?>",
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
        url: "<?php echo base_url().'checkout/getdistrict' ?>",
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
        url: "<?php echo base_url().'checkout/getsubdistrict' ?>",
        type: "POST",
        cache: false,
        data:'prov=' + prov + '&city=' + city + '&district=' + district,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '2'){
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

$(function(){
	//Select
  $(".select2").select2();

  $(".showsubdistrict").on('change', function(){
      var zip = $(this).find(':selected').data('zip');
      $('input[name ="postc"]').val(zip); 
  });


  $('#userprofile-form').validate({
        rules:{
            fname: "required",
            phone:{
                required:true,
                number: true
            },
            address:{
                required:true,
                minlength: 10
            },
            cprov : "required",
            ccity : "required",
            cdist : "required",
            postc :{
                required:true,
                number: true
            }
        },
        messages:{
            address: 'Enter your full address to facilitate delivery'
        },
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            dataType:'json',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            success: function(json){
                alert_notification(json.alert, json.message);
            }
        });
        }
    });
});
</script>