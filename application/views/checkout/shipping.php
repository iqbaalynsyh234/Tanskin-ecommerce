<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.min.css">
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #555;
    line-height: 34px;
}
.select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 30px;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #ccc;
}
</style>
<div id="my-wrapper-background">
<div class="container" style="height: 100%;">
    <form id="form-data-shippings" class="form-horizontal row" action="<?php echo base_url().'checkout/data_shipping' ?>" method="post" style="height: 100%;">
        <div class="col-xs-12 col-sm-7 col-md-8 head-checkout">

        <div class="header-checkout">
        <label class="control-label">
            <div class="brand-head">
              <a href="<?php echo base_url() ?>">
                <img src="<?php echo base_url().'/assets/image/logo/'.get_data('store')['brand_logo'] ?>" style: height:10px;>
              </a>
            </div>
        </label>
            <ul class="nav-checkout">
                <li>Login</li>
                <li class="active"><i class="fa fa-angle-right"></i> Shipping &amp; Payment</li>
                <li><i class="fa fa-angle-right"></i> Confirm</li>
            </ul>
        </div>

        <div class="box-cart">

        <div class="box-cart-head">
            <h1><b>Shipping Information</b></h1>
        </div>
        <div class="box-cart-body">
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Alamat Penerima</label>
            <div class="col-sm-9 col-md-6">
            <?php 
            $alamat = $address->row();
            ?>
                <address class="text-capitalize"><p><b><?php echo $this->session->userdata('cBillName'); ?></b></p><p><?php echo $this->session->userdata('cBillAddress'); ?>, <br>
                <?php echo ucwords(strtolower($alamat->desa)).', '.ucwords(strtolower($alamat->kecamatan)).', '.ucwords(strtolower($alamat->kabupaten)).'<br> '.ucwords(strtolower($alamat->propinsi)).' '.$this->session->userdata('cBillPostcode'); ?><br></p>
                <!-- <div><a href="#"><i class="fa fa-edit"></i> Ubah Alamat</a></div> -->
                </address>
                
                <div id="dropship" class="checkbox">
                      <label>
                        <input type="checkbox" onclick="init_dropship();" name="othershipping" <?php if($this->session->has_userdata('ship_area')){ echo 'checked'; } ?>> Dropship.
                      </label>
                </div>

            </div>
            </div>
            <hr>

            <div class="dropship" <?php if($this->session->has_userdata('ship_area')){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> >
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Name</label>
            <div class="col-sm-9 col-md-6">
                <input type="text" name="sip_name" class="form-control" value="<?php if($this->session->userdata('ship_area')){ echo $this->session->userdata('ship_name'); } ?>" autocomplete="false">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Address</label>
            <div class="col-sm-9 col-md-7">
                <textarea class="form-control" name="sip_address" rows="3" autocomplete="false"><?php if($this->session->has_userdata('ship_area')){ echo $this->session->userdata('ship_addr'); } ?></textarea>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Province</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showprov" name="sip_prop" onchange="init_getcity(this.value);" style="width: 100%;" autocomplete="false">
                  <?php if($this->session->has_userdata('ship_area')){ ?>
                  <option selected="selected" value="<?php echo $shipaddres->propinsi ?>"><?php echo ucwords(strtolower($shipaddres->propinsi)) ?></option>
                  <?php } else { ?>
                  <option selected="selected" value="">-- choose a province --</option>
                  <?php } foreach ($province as $i => $key) { ?>
                  <option value="<?php echo $key['propinsi'] ?>"><?php echo ucwords(strtolower($key['propinsi'])) ?></option>
                  <?php } ?>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">City</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showcity" name="sip_city" onchange="init_getdistrict(this.value)" style="width: 100%;" disabled>
                <?php if($this->session->has_userdata('ship_area')){ ?>
                  <option selected="selected" value="<?php echo $shipaddres->kabupaten ?>"><?php echo ucwords(strtolower($shipaddres->kabupaten)) ?></option>
                  <?php } ?>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">District</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showdistrict" name="sip_dist" onchange="init_getsubdistrict(this.value)" style="width: 100%;" disabled>
                  <?php if($this->session->has_userdata('ship_area')){ ?>
                  <option selected="selected" value="<?php echo $shipaddres->kecamatan ?>"><?php echo ucwords(strtolower($shipaddres->kecamatan)) ?></option>
                  <?php }?>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">SubDistrict</label>
            <div class="col-sm-8 col-md-6">
                <select class="form-control select2 showsubdistrict" name="sip_subdist" onchange="init_getNewcost(this.value);" style="width: 100%;" disabled required>
                  <?php if($this->session->has_userdata('ship_area')){ ?>
                  <option selected="selected" value="<?php echo $shipaddres->ID ?>"><?php echo ucwords(strtolower($shipaddres->desa)) ?></option>
                  <?php }?>
                </select>
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Postcode</label>
            <div class="col-sm-5 col-md-3">
                <input type="text" name="sip_post" class="form-control" value="<?php if($this->session->has_userdata('ship_area')){ echo $this->session->userdata('ship_post'); }?>" autocomplete="false">
            </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Phone Number</label>
            <div class="col-sm-9 col-md-6">
                <div class="input-group">
                <span class="input-group-addon">+62</span>
                <input type="number" name="sip_phone" class="form-control" value="<?php if($this->session->has_userdata('ship_area')){ echo $this->session->userdata('ship_telp'); }?>" autocomplete="false">
              </div>
            </div>
            </div>
            <hr>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Pengiriman</label>
            <div class="col-sm-9 col-md-6">
                <select class="form-control select2 shipping_option" name="sip_cost" style="width: 100%;" required>
                </select>
            </div>
            </div>
            </div>

            <div id="pengiriman-billing" <?php if($this->session->has_userdata('ship_area')){ echo 'style="display: none;"'; }else{ echo 'style="display: block;"'; } ?>>
            <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Pengiriman</label>
            <div class="col-sm-9 col-md-6">
                <select class="form-control select2 shipping_option2" name="bill_cost" style="width: 100%;" required>
                    
                </select>
            </div>
            </div>
            </div>
<hr>
        <?php if($this->session->userdata('login') == false){ ?>
        <a href="<?php echo base_url().'checkout' ?>"><i class="fa fa-angle-left"></i> &nbsp;Back</a>
        <?php }else{ ?>
        <a href="<?php echo base_url().'shop/cart' ?>"><i class="fa fa-angle-left"></i> &nbsp;Back</a>
        <?php } ?>
        </div>
        </div>

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 head-checkout wrapside">
        <div class="box-cart">
        <span class="load-detail-order">
        </span>
        <div class="box-cart-footer">
        <hr>
        <input type="hidden" name="shipping_cost" value="<?php echo ($this->session->has_userdata('cost_session')) ? $this->session->userdata('cost_session') : 0; ?>">
        <button id="btn-nxt" type="submit" name="shipping_page" value="next" class="btn btn-info <?php echo ($next || ($this->session->has_userdata('ship_ship') != 'Price Not Found')) ? '' : 'disabled'; ?>">Next</button>


        </div>
        </div>
        </div>
        </form>
</div>  
</div>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/priceformat/jquery.priceformat.min.js"></script>
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>"
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
              $('.showdistrict, .shipping_option').html('');
              $('.showdistrict, .shipping_option').prop('disabled', true);
            }
            if(json.status == '0'){
              $('.showcity, .showdistrict, .shipping_option').html('');
              $('.showcity, .showdistrict, .shipping_option').prop('disabled', true);
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
              $('.shipping_option').html('');
              $('.shipping_option').prop('disabled', true);
            }
            if(json.status == '0'){
              $('.showdistrict, .shipping_option').html('');
              $('.showdistrict, .shipping_option').prop('disabled', true);
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
                init_getNewcost(json.selected);
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

function init_getNewcost(newarea){
    $('.shipping_option').prop('disabled', true);
    $.ajax({
        url: base_url + "checkout/getdnewcost",
        type: "POST",
        cache: false,
        data:'area=' + newarea,
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
            if(json.next == 1){
                $('#btn-nxt').prop('disabled', false).removeClass('disabled');
            }
        }
    });
}

function init_priceformat(){
  $('.priceformat').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
  });
}

function init_dropship(){
    if($('#dropship input').is(':checked')){
        $('.dropship').show(75);
        $('#pengiriman-billing').hide(75);
        $('.shipping_option').prop('disabled', true);
        $('#btn-nxt').prop('disabled', true).addClass('disabled');
    }else{
        $('.dropship').hide(75);
        $('#pengiriman-billing').show(75);
        $('.showprov').val(null).trigger('change');
        var shipping = 0;
        <?php if($next){ ?>
            $('#btn-nxt').prop('disabled', true).addClass('disabled');
        <?php } ?>
    }
    // init_shippings(shipping);
}

function init_shippings(shipping, meth){
  $.post(base_url + "checkout/created_shipping",
  {
    shipping_cost: shipping,
    meth : meth
  },
  function(data){
    $("#loading").addClass('show');
    location.reload();
  });
  <?php /*/ ?>
    if(isNaN(parseInt(shipping))){
      shipping = 0;
    }
    var subtotal = parseInt($('.subtotalprice').html().replace(/,.*|\D/g,''),10);
    if(isNaN(parseInt(subtotal))){
      subtotal = 0;
    }
    var potongan = 0;
    var total = parseInt(shipping)+parseInt(subtotal);

    <?php if($this->cart->total() >= (int)setting_value('min_pembelanjaan')){ ?>
      var max_potongan = <?php echo (int)setting_value('max_potongan') ?>;
      var potongan = (shipping > max_potongan) ? max_potongan : shipping;
      var total = total - potongan;
      $('#potongan-pengiriman').removeClass('hide').find('.freeshipping').html(potongan);
    <?php } ?>

    $("input[type='hidden'][name='shipping_cost']").val(shipping);
    $('.costshipping').html(shipping);
    $('.totalprice').html(total);

    init_priceformat();
    <?php /*/ ?>
}

function init_voucher(vou){
  var err  = $('#value--vou-error');
    $.ajax({
        url: base_url + "checkout/getwhatis",
        type: "POST",
        cache: false,
        data: 'whatis=' + vou,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
            if(json.status == '1'){
              $("#loading").addClass('show');
              location.reload();
            }
            if(json.status == '0'){
              err.html(json.message)
            }
        }
    });
}

$(function(){

    $(".shipping_option2").load("<?php echo base_url().'checkout/getdoldcost/'.$this->session->userdata('cBillArea');?>");

    <?php if($this->session->has_userdata('ship_area')){ ?>
    $(".shipping_option").load("<?php echo base_url().'checkout/getdoldcost/'.$this->session->userdata('ship_area');?>");
    <?php } ?>

    $(".load-detail-order").load(base_url + "checkout/loadorder");

    $(".showsubdistrict").on('change', function(){
        var zip = $(this).find(':selected').data('zip');
        $('input[name ="sip_post"]').val(zip); 
    });

    $(".select2").select2({
        minimumResultsForSearch: -1,
    });

    // $('#dropship label').on('click', function(){
    //     init_dropship();
    // });

    $('body').on('click', '.have-voucher', function(){
        $('.yes-i-have-vou').toggleClass('hidden');
    });

    $('.shipping_option2').on('change', function(){
        var shipping = $(this).find(':selected').data('cost');
        var meth = $(this).val();
        init_shippings(shipping, meth);
    });

    $('.shipping_option').on('change', function(){
      var shipping = $(this).find(':selected').data('cost');
      console.log($('#form-data-shippings').serialize() + '&shipping_costnew=' + shipping);
       $.ajax({
            url: base_url + "checkout/created_dropship",
            type: "POST",
            cache: false,
            data: $('#form-data-shippings').serialize() + '&shipping_costnew=' + shipping,
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            success: function(json){
              console.log(json);
                $("#loading").addClass('show');
                  location.reload();
            }
        });
    });

    $('#form-data-shippings').validate({
        rules:{
            sip_name: "required",
            sip_address:{
                required:true,
                minlength: 10
            },
            sip_prop : "required",
            sip_city: "required",
            sip_dist : "required",
            sip_post : "required",
            sip_phone : "required",
            sip_cost: "required",
        },
        messages:{
            sip_address: 'Enter your full address to facilitate delivery'
        },
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });


    $('body').on('click', '#vou-sub', function(e){
        var code = $('.value--vou').val(),
            err  = $('#value--vou-error');
        if(! code){
            err.html('This field is required.');
        }else{
            init_voucher(code);
        }
        e.preventDefault();
    });

    $('body').on('click', '#vou-del', function(e){
        window.location.href = base_url + 'checkout/delete_voucher';
    });

    $('body').on('keyup keydown', '.value--vou', function(){
        var code = $(this).val(),
            err  = $('#value--vou-error');
        if(! code){
            err.html('This field is required.');
        }else{
            err.html('');
        }
    });
});
</script>


