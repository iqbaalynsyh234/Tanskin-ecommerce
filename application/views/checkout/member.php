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
<div id="my-wrapper-background">
<div class="container" style="height: 100%;">
    <form id="form-data-confirmations" class="form-horizontal row" action="<?php echo base_url().'checkout/data_checkout' ?>" method="post" style="height: 100%;">
        <div class="col-xs-12 col-sm-7 col-md-8 head-checkout">

        <div class="header-checkout">
        <label class="control-label">
            <div class="brand-head">
              <a href="<?php echo base_url() ?>">
                <img src="<?php echo base_url().'/assets/image/logo/'.get_data('store')['brand_logo'] ?>">
              </a>
            </div>
        </label>
            <ul class="nav-checkout">
                <li class="active">Login</li>
                <li><i class="fa fa-angle-right"></i> Shipping &amp; Payment</li>
                <li><i class="fa fa-angle-right"></i> Confirm</li>
            </ul>
        </div>

        <div class="box-cart">

        <div class="box-cart-head">
            <h1><b>Data Customer</b></h1>
        </div>
        <div class="box-cart-body">
        
        
            <div class="form-group">
            <div class="col-sm-12 col-md-offset-3 col-md-9">

    <ul class="nav nav-tabs button-reg" role="tablist">
    <li role="presentation" class="bt-log"><a href="#checklogin" aria-controls="checklogin" role="tab" data-toggle="tab">Have an account</a></li>
    <li role="presentation" class="bt-reg active"><a href="#guestandregist" aria-controls="guestandregist" role="tab" data-toggle="tab">Buy as guest or Register</a></li>
    </ul>
                
            </div>
            </div>
            
            <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="guestandregist">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9">
                    If you do not have an account yet, fill out the form below..
                </div>
            </div>
            <hr>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Name</label>
            <div class="col-sm-9 col-md-6">
                <input type="text" name="cname" class="form-control" autocomplete="false" placeholder="insert your name">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Email</label>
            <div class="col-sm-9 col-md-6">
                <input type="text" name="cemail" class="form-control" autocomplete="false" placeholder="insert your email">
            </div>
            </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9">
                    <div id="checkregister" class="checkbox">
                      <label>
                        <input type="checkbox" name="iregis" value="true"> Click to register
                      </label>
                    </div>
                  </div>
                </div>
            <div class="register-fild" style="display: none">
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Password</label>
            <div class="col-sm-8 col-md-5">
                <input type="password" name="cpass" class="form-control">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Retype Password</label>
            <div class="col-sm-8 col-md-5">
                <input type="password" name="crpass" class="form-control">
            </div>
            </div>
            <hr>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Address</label>
            <div class="col-sm-9 col-md-7">
                <textarea class="form-control" name="caddress" rows="3" placeholder="insert your address"></textarea>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Province</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showprov" name="cprov" onchange="init_getcity(this.value);" style="width: 100%;">
                  <option selected="selected" value="">-- choose a province --</option>
                  <?php foreach ($province as $i => $key) { ?>
                  <option value="<?php echo $key['propinsi'] ?>"><?php echo ucwords(strtolower($key['propinsi'])) ?></option>
                  <?php } ?>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">City</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showcity" name="ccity" onchange="init_getdistrict(this.value)" style="width: 100%;" disabled>
                  
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">District</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showdistrict" name="cdist" onchange="init_getsubdistrict(this.value)" style="width: 100%;" disabled>
                  <option selected="selected" value=""></option>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">SubDistrict</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showsubdistrict" name="csubdist" style="width: 100%;" disabled>
                  <option selected="selected" value=""></option>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Postcode</label>
            <div class="col-sm-5 col-md-3">
                <input type="number" name="cpost" class="form-control" autocomplete="false">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Phone Number</label>
            <div class="col-sm-9 col-md-6">
                <div class="input-group">
                <span class="input-group-addon">+62</span>
                <input type="number" name="cphone" class="form-control" autocomplete="false">
              </div>
            </div>
            </div>
                <div class="form-group register-fild" style="display: none">
                  <div class="col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="cpol" checked> *
                        By creating an account, you have read, understood &amp; agree to the<a href="#">Privacy Policy</a> and <a href="#">Terms &amp; Conditions</a>.
                      </label>
                    </div>
                  </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="checklogin">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9">
                    Login if you already have an account.
                </div>
            </div>
            <hr>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Email</label>
            <div class="col-sm-9 col-md-6">
                <input type="email" name="lemail" class="form-control" autocomplete="false">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Password</label>
            <div class="col-sm-9 col-md-6">
                <input type="password" name="lpassw" class="form-control">
            </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-6">
                   <button type="submit" class="btn btn-info" style="width: 100%"  name="pagedata" value="login"><span style="padding: 0px 15px;">Login</span></button>
                </div>
            </div>

            </div>
            <!-- end login -->
            </div>
            <!-- tab content -->
        
        </div>
        </div>

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 head-checkout wrapside">
        <div class="box-cart">
        <span class="load-detail-order">
        </span>
        <div class="box-cart-footer">
        <hr>
        <button id="submitdata-01" type="submit" name="pagedata" value="register" class="btn btn-info">Submit <span class="if-register"></span></button>
        </div>
        </div>
        </div>
        </form>
</div>  
</div>



<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/validate/jquery.validate.js"></script>
<script type="text/javascript">

function init_register(){
    if($('#checkregister input').is(':checked')){
        $('.register-fild').show(75);
        $('.if-register').html('& Register');
    }else{
        $('.register-fild').hide(75);
        $('.if-register').html('');
    }
}

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
    $(".load-detail-order").load("<?php echo base_url();?>checkout/loadorder/datacustomer");
    //Select
    $(".select2").select2();
    //Register
    $('#checkregister label').on('click', function(){
        init_register();
    });

    $(".showsubdistrict").on('change', function(){
        var zip = $(this).find(':selected').data('zip');
        $('input[name ="cpost"]').val(zip); 
    });

    $('.bt-log').on('click', function(){
        if($('.bt-log.active')){
            $('#submitdata-01').hide();
        }
    });
    $('.bt-reg').on('click', function(){
        if($('.bt-reg.active')){
            $('#submitdata-01').show();
        }
    });

    $('#form-data-confirmations').validate({
        rules:{
            cname: "required",
            cemail:{
                required:true,
                email:true,
            },
            caddress:{
                required:true,
                minlength: 10
            },
            cpass : "required",
            crpass: "required",
            cprov : "required",
            ccity : "required",
            cdist : "required",
            cphone: "required",
            lemail: {
                required:true,
                email:true
            },
            lpassw: "required",
            cpost : "required"
        },
        messages:{
            cemail:{
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"
                },
            caddress: 'Enter your full address to facilitate delivery'
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
                console.log(json);
                if(json.status == '1'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(1500).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    document.location.href=json.loc;
                    next();
                    });
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(5000).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
            }
        });
        }
    });
});
</script>
