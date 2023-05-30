<section class="content-header">
      <h1>
        Stock
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Data Master</li>
        <li class="active">Stock</li>
      </ol>
</section>


<section class="content">
	<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Import Stock</h3>
              <div class="box-tools">
              <a href="<?php echo base_url('master/stock-produk') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Download Stock</a>          
              </div>
            </div>
            
            <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <input type="hidden" name="template" value="stock">
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="file" id="exampleInputFile">
                  <p class="help-block">xlsx, xls, csv allowed file extention</p>
                </div>
                
              </div>
              

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update Stock</button>
              </div>
            </form>
    </div>

    <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Stock</h3>
            </div>
            
            <!-- <form role="form" action="<?php echo base_url('master/adjustment_stock') ?>" method="post"> -->
              <div class="box-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Item Code</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Color</th>
                        <th style="white-space: nowrap;">Size</th>
                        <th style="white-space: nowrap;">Barcode</th>
                        <th style="white-space: nowrap;">Stock</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      if(count($preview) > 0){
                      $total = 0;
                      foreach ($preview as $key => $value) :
                      $barcode_size = ($value['size'] != 14) ? '-'.$value['size'] : ''; 
                      $total = $total + $value['stock'];
                      ?>
                      <tr>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $value['ItemCode'] ?>
                        </td>
                        <td>
                            <?php echo $value['ItemName'] ?>
                        </td>
                        <td>
                            <?php echo $value['color_name'] ?>
                        </td>
                        <td>
                            <?php echo $value['size_name'] ?>
                        </td>
                        <td>
                            <?php echo $value['barcode'].$barcode_size ?>
                          
                        </td>
                        <td style="white-space: nowrap;">
                            <?php echo $value['stock'] ?>
                        </td>
                      </tr>
                      <?php endforeach; } else {  ?>
                      <tr>
                          <td colspan="13" align="center">
                              No Data !
                          </td>
                      </tr>
                      <?php } ?>
                  </tbody>
                  <tfoot>
                      <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Item Code</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">Color</th>
                        <th style="white-space: nowrap;">Size</th>
                        <th style="white-space: nowrap;">Barcode</th>
                        <th style="white-space: nowrap;">Stock</th>
                      </tr>
                      <tr>
                        <th colspan="6">Total Stock</th>
                        <th style="white-space: nowrap;"><?php echo $total ?></th>
                      </tr>
                  </tfoot>
              </table>
              </div>
              </div>
              <!-- <div class="box-footer">
                
                
                <button id="sumbitorder-button" type="submit" class="btn btn-primary" >Submit</button>
              </div> -->
            <!-- </form> -->
    </div>
</section>