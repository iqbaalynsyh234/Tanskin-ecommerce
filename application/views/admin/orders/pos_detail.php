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
    <h3 class="box-title"><?php echo $detail['meth'].' - '.$detail['Note'] ?></h3>
    </div>
    <div class="box-body">
      
<div id="print-invoice" class="page-side-box">

  
  <div class="print-header">
    <div class="row row-mar">
      <div class="col-sm-6 col-md-6 col-pad">
        <img src="<?php echo base_url('assets/image/logo/'.get_data('store')['brand_logo']) ?>" alt="<?php echo get_data('store')['nama_toko'] ?>">
      </div>
      <div class="col-sm-6 col-md-6 col-pad">
      </div>
    </div>
  </div>

  <div class="row row-mar">
  <div class="col-sm-6 col-md-6 col-pad">
  <table>
    <tbody>
    <tr valign="top">
      <td>Alamat:</td>
      <td style="padding-left: 15px;">
        <address style="text-transform: capitalize;">
          <b><?php echo $detail['name'].' - '.$detail['phone'] ?></b><br>
          <?php echo $detail['address'] ?>
          </address>
      </td>
    </tr>
    </tbody>
  </table>
  </div>
  <div class="col-sm-6 col-md-6 col-pad">
  <table class="fit-right" style="margin-left: auto;">
    <tbody>
      <tr valign="top">
        <td style="text-align: right">No.Order :</td>
        <td style="padding-left: 15px;"><b><?php echo $detail['Note'] ?></b></td>
      </tr>

      <tr valign="top">
        <td style="text-align: right">Packing :</td>
        <td style="padding-left: 15px;"><b><?php echo (!empty($detail['packing'])) ? date('d M Y H:i:s', strtotime($detail['packing'])) : ''; ?></b></td>
      </tr>

      <tr valign="top">
        <td style="text-align: right">Table :</td>
        <td style="padding-left: 15px;"><b><?php echo $detail['table_packing'] ?></b></td>
      </tr>

      <tr valign="top">
        <td style="text-align: right">Admin :</td>
        <td style="padding-left: 15px;"><b><?php echo $detail['user_admin'] ?></b></td>
      </tr>
    
  
   
    
    </tbody>
  </table>
  <br>
  </div>
  <div class="col-sm-12 col-pad">
  <div class="text-right"><small>Dihitung dalam satuan Rupiah (Rp)</small></div>
  <table id="main_table" class="table table-bordered">
    <thead>
      <tr>
      <th class="no-sort" width="10">
      <input type="checkbox" id="selectAll" />
      </th>
      <th width="10px">No</th>
      <th>Item</th>
      <th>Color/Size</th>
      <th class="text-center">Qty</th>
      <th class="text-right">Price</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $jumlah = 0;
    foreach ($detail['detail'] as $key => $value) { 
      $jumlah = $jumlah + ($value['qty'] * $value['price']);
      $size   = ($value['type'] == 1) ? '' : get_size_name($value['size']);
      $color  = get_color_name($value['color']);
      
    ?>
      
      <tr>
      <td><input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $value['id']; ?>"></td>
      <td><?php echo $key + 1 ?></td>
      <td><?php echo '['.$value['item_code'].'] '.$value['ItemName'] ?></td>
      <td><?php echo $color.' / '.$size; ?></td>
      <td style="text-align: center;"><?php echo $value['qty']; ?></td>
      <td style="text-align: right;"><?php echo rupiah($value['price']) ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr>
      <th class="text-right">Shipping Cost</th>
      <th class="text-right">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td style="text-align: right;"><?php echo rupiah($detail['cost']) ?></td>
      <td style="text-align: right;"><?php echo rupiah($jumlah + $detail['cost'])  ?></td>
      </tr>
    </tbody>
  </table>

  
  
  </div>

  </div>
  

  </div>

    </div>
    <?php if($this->session->has_userdata('table') && ($detail['table_packing'] == '' || $detail['table_packing'] == '0')) { ?>
    <div class="box-footer text-right hide">
      <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-success">Packing Order</button>
      </form>
    </div>
    <?php } ?>

  </div>
  </div>
</div>
</section>

<script type="text/javascript">
  function init_action(row){
    var list_product = $('.checktbl').length;
    if(list_product === row){
      $('.box-footer').removeClass('hide');
    }else{
      $('.box-footer').addClass('hide');
    }
  }

  $(function(){

  $('#selectAll').click(function (e) {
      $(this).closest('#main_table').find('td input:checkbox').prop('checked', this.checked);
      var chlength = $('.checktbl:checked').length;
      init_action(chlength);
  });

  $('.checktbl').click(function(){
  var chlength = $('.checktbl:checked').length;
  var tblength = $('#main_table tbody tr').length;
      if(chlength == tblength){
        $('#selectAll').prop('checked', this.checked);
      }else{
        $('#selectAll').prop('checked', false);
      }
      init_action(chlength);
  });

  });
</script>