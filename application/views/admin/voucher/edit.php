<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

<section class="content-header">
      <h1>
        Voucher
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Voucher</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Add Voucher</h3>
    <div class="clearfix"></div>
  </div>
  <div class="box-body">
   <form id="new-voucher" action="<?php echo base_url().'entersite/editvoucher/'.$list_voucher['ID_vou'] ?>" method="post">
      <div class="modal-body">
          <div class="row row-mar">
          <div class="col-sm-12 col-pad">
            <div class="form-group">
                <label>Voucher Code</label>
                <input type="text" name="coupon" class="form-control" value="<?php echo $list_voucher['vou_code'] ?>" required>
            </div>
          </div>
          
          <div class="col-sm-6 col-pad">
          <div class="form-group">
           <label>Potongan</label>
                <div class="input-group">
                  <div class="input-group-addon">
                  <span>Rp</span>
                  </div>
                  <input type="text" name="potongan" class="form-control priceformat potongan" value="<?php echo $list_voucher['Disc'] ?>" required>
                </div>                
          </div>
          
          </div>
          <div class="col-sm-6 col-pad">
          <div class="form-group">
          <label>Min. Belanja</label>
                <input type="text" name="mintagihan" class="form-control priceformat" value="<?php echo $list_voucher['min_amount'] ?>" required>
          </div>
          </div>
          
          <div class="col-sm-12 col-pad">
          <div class="form-group">
          <label>Tgl. Berlaku</label>
                <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="sortdate" class="form-control pull-right" id="reservation0" required>
                </div>
          </div>
          </div>
          
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kuota</label>
                <input type="text" name="kuota" class="form-control" value="<?php echo $list_voucher['usage_vou'] ?>" required>
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kategori</label>
                <select class="form-control select2" name="kategori" style="width: 100%" required>
                  <option value="">-- select options --</option>
                  <option value="1" <?php echo ($list_voucher['vou_for'] == 1) ? 'selected' : ''; ?>>Ongkos Kirim</option>
                  <option value="2" <?php echo ($list_voucher['vou_for'] == 2) ? 'selected' : ''; ?>>Total Belanja</option>
              </select>
              <div class="error"></div>
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="1" <?php echo ($list_voucher['publish'] == 1) ? 'checked' : ''; ?>>
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="2" <?php echo ($list_voucher['publish'] == 2) ? 'checked' : ''; ?>>
                      No
                    </label>
                  </div>
                </div>
          </div>

          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" value="new-voucher" class="btn btn-primary">Edit</button>
      </div>
      </form>
  </div>
  </div>
  
</section>

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/priceformat/jquery.priceformat.min.js"></script>
<script type="text/javascript">
$(function(){
    $('.priceformat').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
    });

    $('#reservation0').daterangepicker({
          locale: {
            format: 'YYYY/MM/DD'
          },
          startDate: '<?php echo ($list_voucher['start_voucher'] != "") ? date('Y/m/d', strtotime($list_voucher['start_voucher'])) : date('Y/m/d'); ?>',
          endDate: '<?php echo ($list_voucher['end_voucher'] != "") ? date('Y/m/d', strtotime($list_voucher['end_voucher'])) : date('Y/m/d'); ?>'
    });

    $('#new-voucher').validate({
        rules:{
            coupon: "required",
            potongan:{
                required:true,
                number: true
            },
            mintagihan:{
                required:true,
                number: true
            },
            sortdate : "required",
            kuota:{
                required:true,
                number: true
            },
            publish : "required"
        },
        errorPlacement: function(){
            return false;  // suppresses error message text
        }
    });
});
</script>
