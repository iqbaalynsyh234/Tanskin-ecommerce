<section class="content-header">
      <h1>
        Import Order
        <small>Import file orders <?php echo $marketplace; ?>.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Import</a></li>
        <li class="active"><?php echo $marketplace; ?></li>
      </ol>
</section>

<style>
    .error-data{
        background: red;
    }
</style>

<section class="content">
    <div class="box box-primary" style="border-top-color: black;">
            <div class="box-header with-border">
              <h3 class="box-title">Import Orders</h3>
            </div>
            
            <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="hidden" name="template" value="<?php echo $marketplace; ?>">
                  <input type="file" name="file" id="exampleInputFile">
                  <p class="help-block">xlsx, xls, csv allowed file extention</p>
                </div>
                
              </div>
              

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Preview</button>
              </div>
            </form>
    </div>
    
    <?php if(!empty($this->session->flashdata('preview'))) : ?>
    
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Preview Orders</h3>
            </div>
            
            <form role="form" action="<?php echo base_url('import/send') ?>" method="post">
              <input type="hidden" name="template" value="<?php echo $marketplace; ?>">
              <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Invoice</th>
                        <th style="white-space: nowrap;">Payment Date</th>
                        <th style="white-space: nowrap;">SKU</th>
                        <th style="white-space: nowrap;">Barcode</th>
                        <th style="white-space: nowrap;">Product Name</th>
                        <th style="white-space: nowrap;">Qty</th>
                        <th style="white-space: nowrap;">Price</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Phone</th>
                        <th style="white-space: nowrap;">Address</th>
                        <th style="white-space: nowrap;">Shipping Fee</th>
                        <th style="white-space: nowrap;">Total</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      if(count($preview) > 0){
                      foreach ($preview as $key => $value) : ?>
                      <tr class="<?php echo $value['error'] ?>">
                        <td>
                            <?php echo $value['count'] ?>
                        </td>
                        <td>
                            <?php echo $value['invoice'] ?>
                            <input type="hidden" name="inv[]" value="<?php echo $value['invoice'] ?>">
                        </td>
                        <td>
                            <?php echo $value['payment_date'] ?>
                            <input type="hidden" name="pd[]" value="<?php echo $value['payment_date'] ?>">
                        </td>
                        <td style="white-space: nowrap;">
                            <?php echo $value['sku'] ?>
                        </td>
                        <td class="<?php echo ($value['error'] == 'error') ? 'error-data' : ''; ?>">
                            <?php echo $value['barcode'] ?>
                            <input type="hidden" name="barcode[]" value="<?php echo $clean_barcode = str_replace(array("'", "/", "`", '"'), '', $value['barcode']) ?>">
                        </td>
                        <td>
                            <?php echo limitChar($value['product_name'], 10); ?>
                        </td>
                        <td>
                            <?php echo $value['qty'] ?>
                            <input type="hidden" name="qty[]" value="<?php echo $value['qty'] ?>">
                        </td>
                        <td style="white-space: nowrap;">
                            <?php echo $value['price'] ?>
                            <input type="hidden" name="price[]" value="<?php echo $value['price'] ?>">
                        </td>
                        <td>
                            <?php echo $value['customer_name'] ?>
                            <input type="hidden" name="name[]" value="<?php echo $value['customer_name'] ?>">
                        </td>
                        <td>
                            <?php echo $value['phone'] ?>
                            <input type="hidden" name="phone[]" value="<?php echo $value['phone'] ?>">
                        </td>
                        <td>
                            <?php echo limitChar($value['address'], 10); ?>
                            <input type="hidden" name="address[]" value="<?php echo $value['address'] ?>">
                        </td>
                        <td style="white-space: nowrap;">
                            <?php echo $value['shipping_fee'] ?>
                            <input type="hidden" name="shipping[]" value="<?php echo $value['shipping_fee'] ?>">
                        </td>
                        <td style="white-space: nowrap;">
                            <?php echo $value['total'] ?>
                            <input type="hidden" name="total[]" value="<?php echo $value['total'] ?>">
                        </td>
                      </tr>
                      <?php endforeach; } else {  ?>
                      <tr>
                          <td colspan="13" align="center">
                              All Invoice Numbers Already Exist!
                          </td>
                      </tr>
                      <?php } ?>
                  </tbody>
              </table>
              </div>
              </div>
              <div class="box-footer">
                <button id="sumbitorder-button" type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
    </div>
    <?php endif; ?>
</section>

<script>
    $(function(){
        var error = $('.error-data').length;
        if(error > 0){
            $('#sumbitorder-button').hide();
        }
    });
</script>
