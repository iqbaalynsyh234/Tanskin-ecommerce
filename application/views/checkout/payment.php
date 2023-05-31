
<?php
  require 'vendor/autoload.php';

  use Xendit\Xendit;

  Xendit::setApiKey('xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3');

  $sql = "SELECT * FROM payment_xendit";

 ?>
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
    <form id="payment_midtrans" class="form-horizontal row" action="<?php echo base_url('snap/token') ?>" method="post" style="height: 100%;">
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
                <li>Login</li>
                <li><i class="fa fa-angle-right"></i> Shipping &amp; Payment</li>
                <li class="active"><i class="fa fa-angle-right"></i> Confirm</li>
            </ul>
        </div>

        <div class="box-cart">

        <div class="box-cart-head">
            <h1><b>Confirmation Order</b></h1>
        </div>
        <div class="box-cart-body">
        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">Alamat Pengiriman :</label>
            <div class="col-sm-9 col-md-6">
                <address class="text-capitalize">
                <?php 
                 if($this->session->has_userdata('ship_name')){ 
                    $namakrirm   = $this->session->userdata('ship_name');
                    $alamatkirim = $this->session->userdata('ship_addr');
                    $telpon      = $this->session->userdata('ship_telp');
                    $postcode    = $this->session->userdata('ship_post');
                 } else { 
                    $namakrirm   = $this->session->userdata('cBillName');
                    $alamatkirim = $this->session->userdata('cBillAddress');
                    $telpon      = $this->session->userdata('cBillPhone');
                    $postcode    = $this->session->userdata('cBillPostcode');
                 } 
                ?>
                <p><b><?php echo $namakrirm.' - (62+) '.$telpon; ?></b></p>
                <p><?php echo $alamatkirim; ?><br>
                <?php echo ucwords(strtolower($shipaddres->desa)).', '.ucwords(strtolower($shipaddres->kecamatan)).', '.ucwords(strtolower($shipaddres->kabupaten)).'<br>'.ucwords(strtolower($shipaddres->propinsi)).', '.$postcode.'<br></p>'; ?>
                </address>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 col-md-3 text-right"><b>Metode Pengiriman :</b></div>
            <div class="col-sm-9 col-md-6">
                <b><?php echo strtoupper($this->session->userdata('ship_ship')) ?></b>
            </div>
        </div>

        <?php if(strtoupper($this->session->userdata('ship_ship')) == "PRICE NOT FOUND.") { ?>
        <div class="form-group">
            <div class="col-sm-12">
                <p style="color: red">* Pembayaran tidak bisa dilakukan, kota pengiriman belum terjangkau.</p>
            </div>
        </div>
        <?php } ?>

        <?php if(count($dataalert) > 0){ 
            foreach ($dataalert as $key => $value) {
        ?>
            <div class="form-group">
            <div class="col-sm-12">
                <p style="color: red; text-transform: uppercase;"><?php echo $value['name'].' '.$value['stock'] ?></p>
            </div>
        </div>
        <?php } } ?>
        
        <div class="row">
        <div class="col-sm-12">
        
        </div>
        </div>
            
        <a href="<?php echo base_url().'checkout/shipping_method' ?>"><i class="fa fa-angle-left"></i> Back </a>
        </div>
        </div>

        </div>

        <div class="cil-xs-12 col-sm-5 col-md-4 head-checkout wrapside">
        <div class="box-cart">
        <span class="load-detail-order">
        </span>

        <tr>
      
        <div class="box-cart-footer">
        <hr>
        <?php if(strtoupper($this->session->userdata('ship_ship')) != "PRICE NOT FOUND.") { ?>
        <button id="paymentButton" type="button" name="confirm" value="confirm" class="btn btn-info" <?php echo $buybutton ?>>Pembayaran<span class="if-register"></span></button>
        <?php } ?>
        <a href="controller.php"></a>
        </div>
        </div>
        </div>
        </form>
</div>  
</div>
<form id="payment-form" method="post" action="<?php echo base_url('snap/finish') ?>">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<script>
  function GetVoucherlist(){
    
  }
</script>

<script>
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

</script>

<script>
  // Get the elements
 var voucherInput = document.querySelector('.input-group input');
 var useButton = document.getElementById('use');

 // Add event listener to the button
useButton.addEventListener('click', function() {
  // Get the voucher code entered by the user
  var voucherCode = voucherInput.value.trim();
  
  // Validate the voucher code (add your own validation logic here)
  if (voucherCode === '') {
    alert('Voucher Code fild in the blank.');
    return;
  }
  
  // Apply the voucher code and reduce the payment amount
  // Add your own logic here to calculate the discounted payment amount
  
  // Example: Assume the payment amount is stored in a variable called paymentAmount
  // and the voucher discount is stored in a variable called voucherDiscount
  
  // Calculate the new payment amount after applying the voucher discount
  var newPaymentAmount = paymentAmount - voucherDiscount;
  
  // Display the new payment amount to the user (replace this with your own code)
  alert('Payment amount after applying the voucher: ' + newPaymentAmount);
});

</script>

<script>
  $('body').on('click', '.have-voucher', function(){
        $('.yes-i-have-vou').toggleClass('use');
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
</script>
</script>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
$(function(){
$(".load-detail-order").load("<?php echo base_url();?>checkout/loadorder/payment-method");
$('body').on('click', '.have-voucher', function(){
        $('.yes-i-have-vou').toggleClass('hidden');
});
});
</script>

<!--<?php /*echo setting_value('midtrans_clientkey') */?>-->

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo setting_value('midtrans_clientkey') ?>"></script>
<script type="text/javascript">
    var form = $("payment_midtrans");

    $('#submitdata-01').click(function (event) {
      event.preventDefault();
      $(this).attr("disabled", "disabled");
    
    $.ajax({
      url: '<?php echo base_url('snap/token') ?>',
      cache: false,
      success: function(data) {
        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });
  });
</script>

<script>
  // Add an event listener to the "Pembayaran" button
  const paymentButton = document.getElementById('paymentButton');
  paymentButton.addEventListener('click', generateInvoice);

  // Function to generate the invoice URL
  function generateInvoice() {
    // Set up the invoice details
    const invoiceData = {
      external_id: '1', // Replace with your own external ID
      payer_email: 'iqbalalyansyah3@g', // Replace with the customer's email address
      description: 'tes', // Replace with a description of the invoice
    };

    // Construct the invoice URL with the invoice details
    const invoiceUrl = `https://checkout.xendit.co/web/invoice?external_id=${}&payer_email=${invoiceData.payer_email}&description=${invoiceData.description}`;

    // Redirect the user to the Xendit invoice URL
    window.location.href = invoiceUrl;
  }
</script>