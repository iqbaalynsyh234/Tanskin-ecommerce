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
   <form id="new-voucher" action="<?php echo base_url().'entersite/addvoucher' ?>" method="post">
      <div class="modal-body">
          <div class="row row-mar">
          <div class="col-sm-12 col-pad">
            <div class="form-group">
                <label>Voucher Code</label>
                <input type="text" name="coupon" class="form-control">
            </div>
          </div>
          
          <div class="col-sm-6 col-pad">
          <div class="form-group">
           <label>Potongan</label>
                <div class="input-group">
                  <div class="input-group-addon">
                  <span>Rp</span>
                  </div>
                  <input type="text" name="potongan" class="form-control priceformat potongan">
                </div>                
          </div>
          <div class="max-disc form-group hidden">
           <label>Maksimal</label>
                <div class="input-group">
                  <input type="text" name="potongan-max" min="1" class="form-control priceformat" placeholder="Rp">
                </div>                
          </div>
          </div>
          <div class="col-sm-6 col-pad">
          <div class="form-group">
          <label>Min. Belanja</label>
                <input type="text" name="mintagihan" class="form-control priceformat">
          </div>
          </div>
          
          <div class="col-sm-12 col-pad">
          <div class="form-group">
          <label>Tgl. Berlaku</label>
                <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="sortdate" class="form-control pull-right" id="reservation0">
                </div>
          </div>
          </div>
          
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kuota</label>
                <input type="text" name="kuota" class="form-control">
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kategori</label>
                <select class="form-control select2" name="kategori" style="width: 100%" required>
                  <option value="">-- select options --</option>
                  <option value="1">Ongkos Kirim</option>
                  <option value="2">Total Belanja</option>
              </select>
              <div class="error"></div>
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="yes" checked="">
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="no">
                      No
                    </label>
                  </div>
                </div>
          </div>

          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="new-voucher" class="btn btn-primary">Submit</button>
      </div>
      </form>
  </div>
  </div>
  
</section>
