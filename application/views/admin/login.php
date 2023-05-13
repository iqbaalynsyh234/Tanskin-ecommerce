<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin :: Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/image/logo/fav-icon.png">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url().'assets/' ?>css/admin-custom.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<style type="text/css">
body {
    background-color: #d5d5d5;
    min-height: 500px;
}
.login-box {
    width: 360px;
    margin: 0px;
    position: absolute;
    left: 50%;
    transform: translate(-50%);
    margin-top: 75px;
}
.notification {
    position: fixed;
    bottom: 0;
    right: 0;
    min-width: 250px;
    margin-right: 15px;
    margin-bottom: 20px;
    max-width: 100%;
    max-height: 200px;
    overflow: hidden;
    display: none;
}
.notification.active{
    display: block;
}
.notification .alert{
    padding: 5px 15px;
    margin-bottom: 10px;
    border: 1px solid transparent;
    border-radius: 0px;
    padding-right: 30px;
}
</style>
<body>
<div class="login-box">
  <div class="login-logo">
    <b>Admin</b>TANSKIN
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form id="gate_admin" action="<?php echo base_url().'entersite/admin_gate' ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="field_0994" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="field_0995" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        
        <div class="col-xs-12 text-right">
          <button type="submit" class="btn btn-primary btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  
  <!-- /.login-box-body -->
</div>

<div class="notification">
  
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url().'assets/' ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url().'assets/' ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/validate/jquery.validate.js"></script>
<script type="text/javascript">

function alert_notification(type, message){
  if(message == null){ }else{
  $(".notification").addClass('active');
  $(".notification.active").append('<div class="alert '+type+' alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+message+'</div>');
  }
}

$(function(){
  $("#gate_admin").validate({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    errorPlacement: function(error, element){},
    submitHandler: function(form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            dataType:'json',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            success: function(json){
                alert_notification(json.alert, json.message);
                if(json.status == '01'){
                  document.location.href=json.uri;
                }
            }
        });
        }
  });
});
</script>
</body>
</html>
