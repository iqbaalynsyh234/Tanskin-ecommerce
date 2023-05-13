<div id="wrap-content">
<div class="container">
	<div class="row row-mar">
	<div class="col-sm-12 col-md-12 col-pad">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
	  <li class="active">My Password</li>
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
	<h3>Password</h3>
	<?php if($account->oauth_provider == "website"){ ?>
	<form id="ch-password" class="row" action="<?php echo base_url('processing/atlas_ch_password') ?>" method="post">
		<div class="col-sm-6">
		<div class="form-group">
            <label>Password</label>
            <input type="password" name="pass_old" class="form-control">
        </div>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" id="nps-r" name="pass_new" class="form-control" minlength="5">
        </div>
        <div class="form-group">
            <input type="password" name="pass_new_r" class="form-control" placeholder="Retype New Password">
        </div>
		</div>
		<div class="col-sm-12">
		<hr>
		<button type="submit" name="submit" class="btn btn-main-black">Change Password</button>
		</div>
	</form>
	<?php } else { ?>
	Akun Anda masuk dari <?php echo $account->oauth_provider ?>.<br>
	<a href="<?php echo $logoutUrl ?>">Keluar dari Facebook.</a>
	<?php } ?>
	</div>
	</div>
	</div>
	</div>
	</div>

</div>
</div>	

<script type="text/javascript">
$(function(){
	$('#ch-password').validate({
		rules:{
			pass_old: 'required',
			pass_new: 'required',
			pass_new_r:{
				equalTo:'#nps-r',
				required:true
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
            		$('.status-alert-view span').append(json.message);
                	$('.status-alert-view').addClass('open');
                	document.getElementById("ch-password").reset();
            }
		 });
		}
	});
});
</script>
