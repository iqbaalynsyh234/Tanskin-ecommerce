<section class="content-header">
      <h1>
       Invoice
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Invoice Label</li>
      </ol>
</section>



<section class="content">
<div class="row row-mar">
  <div class="col-sm-12 col-pad">
  <div class="box">
    <div class="box-header with-border">
    <h3 class="box-title">Invoice Label</h3>


    <button style="float: right;" class="btn btn-info" id="print-inv" type="button"><i class="fa fa-print"></i> Print</button>
    </div>
    <div class="box-body">
      
<div id="print-invoice" class="page-side-box">

<style type="text/css">
.fot-print { display: none; }
.print-header{
  border-bottom: 1px solid #d5d5d5;
  margin-bottom: 15px;
  padding: 10px 0px;
}
.print-header h1{
  font-size: 23px;
  font-weight: bold;
  color: #000000;
  margin-top: 0px;
}
@media print {
  #print-invoice { padding: 10px 15px; width: 100%; font-size: 12px; }
  table{
     width: 100%;
  }
  table.table-bordered>thead>tr{
    background-color: #d5d5d5;
  }
  .col-sm-8 {
      width: 66.66666667% !important;
      float: left;
  }
  .col-sm-4 {
      width: 33.33333333% !important;
      float: left;
  }
  .col-sm-6 {
      width: 50% !important;
      float: left;
  }
  #print-iframe{position: absolute; visibility: hidden; z-index: -1; height: 0px;}
  .h-print { display: none; }
  .fot-print { display: block !important; }


  .fot-print span{
    display: block
  }
}
</style>

  <div class="print-header">
    <div class="row row-mar">
      <div class="col-sm-6 col-md-6 col-pad">
        <img src="<?php echo base_url('assets/image/logo/'.get_data('store')['brand_logo']) ?>" alt="<?php echo get_data('store')['nama_toko'] ?>" width="150px;">
      </div>
      <div class="col-sm-6 col-md-6 col-pad text-right">
        <h1>INVOICE</h1>
      </div>
    </div>
  </div>

  <div class="row row-mar">
  <div class="col-sm-6 col-md-6 col-pad">
  <table>
    <tbody>
    <tr valign="top">
      <td>Alamat Pengiriman :</td>
      <td style="padding-left: 15px;">
        <address style="text-transform: capitalize;">
        <?php echo '<p><b>'.$orders['ShipName'].' - (62+) '.$orders['ShipPhone'].'</b></p>'; ?>
          <p><?php echo $orders['ShipAddress'] ?><br>
          <?php echo $orders['kecamatan'].', '.$orders['kabupaten'].'<br>'.$orders['propinsi'].', '.$orders['ShipPostcode']; ?>.</p>
          </address>
      </td>
    </tr>
    </tbody>
  </table>
  </div>
  <div class="col-sm-6 col-md-6 col-pad">
  <table class="fit-right">
    <tbody>
    <tr valign="top">
      <td style="text-align: right">No.Order :</td>
      <td style="padding-left: 15px;"><b><?php echo $orders['No_Orders'] ?></b></td>
    </tr>
    <tr valign="top">
      <td style="text-align: right">Metode Pengiriman :</td>
      <td style="padding-left: 15px;"><?php echo strtoupper($orders['ShippingMet']); ?></td>
    </tr>
    <tr valign="top">
      <td style="text-align: right">Metode Pembayaran :</td>
      <td style="padding-left: 15px; text-transform: capitalize;"><?php echo $orders['PaymentMet'].' / '.$orders['transaction_status']; ?></td>
    </tr>
    <tr valign="top">
      <td style="text-align: right">Status :</td>
      <?php 
      if($orders['OrderStatus'] == 0){
        $status = 'Kadaluarsa';
      }elseif($orders['OrderStatus'] == 1){
        $status = 'Menunggu Pembayaran';
      }elseif($orders['OrderStatus'] == 2){
        $status = 'Diproses';
      }elseif($orders['OrderStatus'] == 3){
        $status = 'Dikirim';
      }elseif($orders['OrderStatus'] == 4){
        $status = 'Selesai';
      }else{
        $status = 'Kadaluarsa';
      }
      ?>
      <td style="padding-left: 15px;"><?php echo $status ?></td>
    </tr>
    </tbody>
  </table>
  <br>
  </div>
  <div class="col-sm-12 col-pad">
  <div class="text-right"><small>Dihitung dalam satuan Rupiah (Rp)</small></div>
  <table class="table table-bordered">
    <thead>
      <tr>
      <th>Item</th>
      <th class="text-center">Qty</th>
      <th class="text-right">Price</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    foreach ($orders['list_order'] as $key) {
      $color = ($key->color != '') ? ' / '.get_color_name($key->color) : '';
      $size = ($key->size != '') ? ' / '.get_size_name($key->size) : '';
    ?>
      <tr>
      <td><?php echo $key->ItemName.$color.$size; ?></td>
      <td style="text-align: center;"><?php echo $key->qty ?></td>
      <td style="text-align: right;"><?php echo rupiah($key->PriceSell) ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr>
      <th class="text-right">Shipping Cost</th>
      <th class="text-right">Voucher</th>
      <th class="text-right">Code</th>
      <th class="text-right" style="background: #d5d5d5">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td style="text-align: right;"><?php echo rupiah($orders['ShippingCost']) ?></td>
      <td style="text-align: right;">(0)</td>
      <td style="text-align: right;"><?php echo rupiah($orders['UnikCode']) ?></td>
      <td style="text-align: right;"><?php echo rupiah($orders['Subtotal']) ?></td>
      </tr>
    </tbody>
  </table>

  <div class="fot-print text-center">
    <span>TERIMA KASIH TELAH BERBELANJA DI KAM&CO</span>
    <span>BUTUH BANTUAN? HUBUNGI KAMI DICUSTOMER SERVICE <?php echo get_data('store')['no_telp'] ?></span>
  </div>

  
  
  </div>

  </div>
  

  </div>

    </div>
  </div>
  </div>
</div>
</section>

<iframe id="print-iframe" frameborder="0" class="hidden"></iframe>

<script type="text/javascript">
function printpop(){
  var myStyle = '<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">',
    content = myStyle + $("#print-invoice").html(),
    $iframe = $('#print-iframe');
    $iframe.ready(function() {
    $iframe.contents().find("body").html("");
    $iframe.contents().find("body").append(content);
        setTimeout(function () {
           $iframe.get(0).contentWindow.print();
        }, 500);
    });
}
$(function(){
  $('#print-inv').on('click', function(){
    printpop();
  });
});
</script>