<div id="wrap-content">
<div class="container">
<ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>">Home</a></li>
      <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
  <li class="active">Account</li>
</ol>

<div class="row">
	<div class="col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6">
	<div class="sign-in tab-content">
	
	<div role="tabpanel" class="tab-pane active" id="log-page">
	<h2 class="text-center">Sign In</h2>
	<form id="actionaccount0" action="<?php echo base_url().'shop/processlog' ?>" method="post" class="row">
		<div class="col-sm-12 col-md-12 side-border">
		<div class="form-group">
            <label>Email</label>
            <input type="email" name="emaillog" class="form-control">
        </div>
        <div class="form-group">
        <label>Password</label>
        <div class="input-group">
            <input type="password" name="passlog" class="form-control form-password1">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default showpass1 yes"><i class="fa fa-eye"></i></button>
            </div>
        </div>
        </div>
        <div class="form-group">
		<button class="btn btn-main btn-main-black" type="submit" name="submitaccount" value="weblogin">Sign In</button>
		</div>
		</div>			
	</form>
	<div class="clearfix"></div>
	<p class="text-center">Do not have an account yet? <a href="#reg-page" aria-controls="profile" role="tab" data-toggle="tab">Register here</a>.</p>
	</div>


	<div role="tabpanel" class="tab-pane row" id="reg-page">
	<h2 class="text-center">Register</h2>
	<form id="actionaccount1" action="<?php echo base_url().'shop/processlog' ?>" method="post">
	<div class="col-sm-12 col-md-12 side-border">
		<div class="form-group row row-mar">
			<div class="col-sm-12 col-pad">
            <label>Name</label>
            </div>
            <div class="col-sm-6 col-xs-6 col-pad">
            <input type="text" name="fname" class="form-control">
            </div>
            <div class="col-sm-6 col-xs-6 col-pad">
            <input type="name" name="lname" class="form-control">
            </div>
        </div>
		<div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
        <label>Password</label>
        <div class="input-group">
            <input type="password" name="passwreg" class="form-control form-password">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default showpass yes"><i class="fa fa-eye"></i></button>
            </div>
        </div>
        </div>
        <div class="form-group">
		<button class="btn btn-main btn-main-black" type="submit" name="submitaccount" value="webregis">Register</button>
		</div>
		</div>
		<div class="clearfix"></div>	
	</form>
	<p class="text-center">Already have an account? <a href="#log-page" aria-controls="profile" role="tab" data-toggle="tab">Sign in here</a>.</p>
	</div>
	</div>
	</div>
</div>
</div>
</div>

<script type="text/javascript">
$(function(){
$('body').on('click', '.showpass.yes', function(){
	$(this).removeClass('yes');
	$(this).addClass('no');
	$('.form-password').attr('type','text');

});
$('body').on('click', '.showpass.no', function(){
	$(this).removeClass('no');
	$(this).addClass('yes');
	$('.form-password').attr('type','password');
});
$('body').on('click', '.showpass1.yes', function(){
	$(this).removeClass('yes');
	$(this).addClass('no');
	$('.form-password1').attr('type','text');

});
$('body').on('click', '.showpass1.no', function(){
	$(this).removeClass('no');
	$(this).addClass('yes');
	$('.form-password1').attr('type','password');
});

$('#actionaccount0').validate({
        rules:{
            emaillog: {
                required:true,
                email:true
            },
            passlog: "required"
        },
        messages:{
            emaillog:{
                email: "Your email address must be in the format of name@domain.com"
                }
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
                if(json.status == '1'){
                    document.location.href=json.loc;
                }
            }
        });
        }
    });


$('#actionaccount1').validate({
        rules:{
            fname: "required",
            lname: "required",
            email:{
                required:true,
                email:true
            },
            passwreg: "required",
        },
        messages:{
            email:{
                email: "Your email address must be in the format of name@domain.com"
                },
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
                if(json.status == '1'){
                    document.location.href=json.loc;
                }
            }
        });
        }
    });


});
</script>