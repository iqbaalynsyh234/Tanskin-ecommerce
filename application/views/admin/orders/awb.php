<section class="content-header">
      <h1>
        AWB
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Shipping Label</li>
      </ol>
</section>



<section class="content">
<div class="row row-mar">
  <div class="col-sm-12 col-pad">
  <div class="box">
    <div class="box-header with-border">
    <h3 class="box-title">Shipping Label</h3>


    <button style="float: right;" class="btn btn-info" id="print-inv" type="button"><i class="fa fa-print"></i> Print</button>
    </div>
    <div class="box-body">
      <div class="row" id="print-awb">
      <style type="text/css">
      .awb-box{
        border: 1px solid #333333;
        padding: 15px;
         margin-bottom : 15px;
      }
      .awb-box table{
        width: 100%;
      }
      .awb-box table td{
        padding: 10px 0px;
        vertical-align: top;
      }
      .awb-box table.table_head tr:first-child td img{
        width: 60%;
      }
      .awb-box table.table_head tr:nth-child(2) td:first-child img{
        width: 100%;
      }
      .awb-box table.table_head tr:nth-child(2) td:last-child img{
        width: 100%;
      }
      .awb-box table.table_head tr:nth-child(4) td{
        width: 50%;
        border-bottom: 1px solid #333333;
        vertical-align: top;
      }
      .awb-box table.table_head thead tr:first-child td{
        border-bottom: 1px solid #333333;
        padding-bottom: 10px;
        padding-top: 0px;
      }
      .awb-box table.table_body{
          margin-top: 10px;
      }
      .awb-box table.table_body tbody tr td, .awb-box table.table_body tbody tr th{
        padding-right: 3px;
        padding-left: 3px;
      }
      .awb-box table.table_body tbody tr td:first-child, .awb-box table.table_body tbody tr th:first-child{
        padding-left: 0px;
      }
      .awb-box table.table_body tbody tr td:last-child, .awb-box table.table_body tbody tr th:last-child{
        padding-right: 0px;
        text-align: right;
        width: 10%;
      }
      .boxtablewrapper{
          display: table;
      }
      .boxtablewrapper .boxtable{
          width: 50%;
          display: table-cell;
      }
      .boxtablewrapper .boxtable span{
          padding-left: 15px;
          display: block;
          text-align: center;
      }
      .box_notif{
          padding: 4px 10px;
          border: 1px solid #000;
      }
      @media print {
      .col-sm-6 {
          width: 100% !important;
          float: left;
      }
      .awb-box{
        border: 0px solid #333333;
        padding: 0px;
        height: 7in;
        margin-top: 15px;
        font-size: 10px;
      }
      .boxtablewrapper .boxtable span{
          font-size: 12px;
      }
      #print-iframe{position: absolute; visibility: hidden; z-index: -1; height: 0px;}
      }
    </style>
          <?php foreach ($awb as $key => $value) { ?>
          <div class="col-sm-6">
              <div class="awb-box">
                <table class="table_head">
                  <thead>
                  <tr>
                    <td colspan="3">
                      <img src="<?php echo base_url('assets/image/logo/'.get_data('store')['brand_logo']) ?>">
                    </td>
                    <td colspan="3" align="center">
                      No Order:<?php echo $value['No_Orders'] ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                        <div class="boxtablewrapper">
                            <div class="boxtable">
                                <img src="<?php echo base_url('assets/image/logo/New_Logo_JNE.png') ?>">
                            </div>
                            <div class="boxtable">
                                <span><?php echo 'JNE<br><b>'.$value['ShippingMet'].'</b>' ?></span>
                            </div>
                        </div>
                      <div>Berat <b><?php echo $value['total_weight'].' Kg' ?></b></div>
                      <div>Ongkir <b style="text-decoration: line-through;"><?php echo 'Rp.'.rupiah($value['ShippingCost']) ?></b></div>
                    </td>
                   
                    <td colspan="3" align="center">
                      <img src="<?php echo base_url('entersite/generate-barcode-awb/'.$value['cnote_no']) ?>">
                    </td>
                  </tr>
                  
                  <tr>
                      <td colspan="6">
                        <div class="box_notif">
                            <i>Penjual <b>tidak perlu</b> bayar apapun ke kurir, sudah dibayarkan otomatis</i>
                        </div>  
                      </td>
                  </tr>
                  
                  <tr class="detailist">
                    <td colspan="3">
                      Kepada : <br>
                      <b><?php echo $value['ShipName'] ?></b><br>
                      <?php echo $value['ShipAddress'].'<br>'.$value['kecamatan'].', '.$value['kabupaten'] ?><br>
                      <?php echo $value['propinsi'].', '.$value['ShipPostcode'] ?>
                      <?php echo $value['ShipPhone'] ?>
                    </td>
                    <td colspan="3">
                      Dari : <br>
                      <b>Kamnco</b><br>
                      <?php echo get_data('store')['alamat_toko'].'<br>'.get_data('store')['no_telp'] ?>
                    </td>
                  </tr>
                  </thead>
                  </table>
                  <table class="table_body">
                  <tbody>
                    <tr>
                      <th colspan="3">Produk</th>
                      <th>Variant</th>
                      <th>SKU</th>
                      <th>Jumlah</th>
                    </tr>
                    <?php foreach ($value['orderlist'] as $key => $list) { ?>
                    <tr>
                      <td colspan="3"><?php echo $list['ItemName'] ?></td>
                      <td><?php echo $list['ColorName'] ?></td>
                      <td><?php echo $list['ItemCode'] ?></td>
                      <td><?php echo $list['qty'] ?> pcs</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
          </div>
          <?php } ?>

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
    content = myStyle + $("#print-awb").html(),
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