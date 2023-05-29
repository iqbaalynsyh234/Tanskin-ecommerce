<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<section class="content-header">
      <h1>
        Barcode
        <small>Print label barcode voucher</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'entersite/' ?>">Admin</a></li>
        <li class="active">Barcode</li>
      </ol>
</section>

<section class="content">
<div class="row row-mar">
	<div class="col-sm-12 col-pad">
	<div class="box">
	<div class="box-header with-border">
	<h3 class="box-title">Print Barcode Label Voucher</h3>
	</div>
	<form action="<?php echo base_url('entersite/barcode') ?>" class="myform" method="post">
	<div class="box-body">
  <div class="row row-mar">
    <div class="col-sm-4 col-pad">
      <div class="form-group">
      <label>Code</label>
      
      <select name="code" class="form-control select2" style="width: 100%;">
        <!-- <option value="">Select Barcode</option> -->

      <?php
      foreach ($code as $key => $value) {
        $selected = ($row['voucher'].'-'.$row['vou_code'] == $value['barcode'].'-'.$value['vou_code']) ? 'selected' : '';
      ?>
          <option value="<?php echo $value['barcode'].'-'.$value['vou_code'] ?>" <?php echo $selected ?>>
          <?php echo $value['ItemCode'].' / '.$value['barcode'].' - '.strtoupper($value['ColorName']).' - '.strtoupper($value['Size']) ?>
          </option>
      <?php } ?>
      </select>
      </div>
    </div>

    <div class="col-sm-4 col-pad">
      <div class="form-group">
        <label>Quantity</label>
        <input type="number" class="form-control" name="qty" value="<?php echo ($for > 0) ? $for : ''; ?>" required>
      </div>
    </div>



  </div>  
	</div>
  <div class="box-footer text-right">
      <button class="btn btn-primary" type="submit" name="submitcategory" value="true">Submit</button>
  </div>
  </form>
	
	</div>
	</div>

	
</div>
</section>

<?php if(!empty($row)){ ?>
<section class="content">
<div class="row row-mar">
  <div class="col-sm-12 col-pad">
  <div class="box">
  <div class="box-header with-border">
  <button class="btn btn-primary print" type="button"><i class="fa  fa-print"></i> Print Barcode</button>
  </div>

  <div class="box-body text-center">
    <div class="row">
    <div class="bcs col-xs-12 bright" align="center">
    <style type="text/css">
      .bc {
          margin: 0px 15px;
          margin-top: 8px !important;
      }

      .bc * {
          font-size: 10px !important;
          margin: 0px;
          line-height: 11px;
      }
      .bc td {
          padding-bottom: 18px !important;
      }
    </style>
    <table border="0" class="bc" cellspacing="0" cellpadding="0" align="center">
      <tbody>
        <?php 
        $loop = $for;
        $page = 5;
        $loop_master = floor($loop / $page);
        $loop_rest   = abs($loop - ($loop_master * $page));

        $tag = ($row['ColorName'] == '') ? 'Size : '.strtoupper($row['Size']) : strtoupper($row['Size']).' '.$row['ColorName'];
        $size_on_barcode = (!empty($row['size']) && $row['size'] != 14) ? '-'.$row['size'] : '';

        for ($i=0; $i < $loop_master; $i++) { 
            echo '<tr>';
            for ($m=0; $m < $page; $m++) { 
              echo '<td width="155" valign="top" align="center">
                <p class="text-left">'.$row['ItemCode'].'<br>'.$row['ItemName'].'<br>'.$tag.'</p>
                <img src="'.base_url('entersite/generate-barcode/'.$row['barcode'].$size_on_barcode).'" width="90"> 
              </td>';
            }
            echo '</tr>';
        } 

        echo '<tr>';
        for ($r=0; $r < $loop_rest; $r++) { 
          echo '<td width="155" valign="top" align="center">
                <p class="text-left">'.$row['ItemCode'].'<br>'.$row['ItemName'].'<br>'.$tag.'</p>
                <img src="'.base_url('entersite/generate-barcode/'.$row['barcode'].$size_on_barcode).'" width="90"> 
              </td>';
          }
        echo '</tr>';
        ?>

      </tbody>
    </table>
  </div>
</div>

  </div>
  
  
  </div>
  </div>
</div>
</section>
<?php } ?>

<iframe id='print-iframe' name='print-frame-name' style="position:absolute; z-index:-1;"></iframe>
<script type="text/javascript">
  $(".print").click(function(event) {
    
       
    var myStyle = '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><title>POS | KAMNCO</title><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><link rel="stylesheet" href="<?php echo base_url().'assets/' ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php echo base_url().'assets/' ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php echo base_url().'assets/' ?>css/admin-custom.css"><style>body{font-size:12px; margin:15px 12px;} table th, table td{ padding:0px 10px !important;  font-size:11px; }.bc{margin-top:8px;} table{width: 100%;}</style>';
    var content = $(".bcs").html();
    var $iframe = $('#print-iframe');
    $iframe.ready(function() {
      $iframe.contents().find("body").html("");
      $iframe.contents().find("head").html("");
      $iframe.contents().find("head").append(myStyle);
        $iframe.contents().find("body").append(content);
        setTimeout(function () {
           $iframe.get(0).contentWindow.print();
        }, 1000);
       

    });
    
    
  });
</script>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">

$(function(){
  $(".select2").select2();
});
</script>