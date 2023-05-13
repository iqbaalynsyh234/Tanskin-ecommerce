<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<style type="text/css">

.select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 0px;
}
.select2-container .select2-selection--single, .select2-container .select2-selection--multiple{
    height: 34px;
}
.box-color{
    width: auto;
    height: 50px;
    border-radius: 6px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #d5d5d5;
    margin-right: 15px;
    padding: 0px 20px;
    margin-bottom: 15px;
}
</style>
<section class="content-header">
      <h1>
        Adding Master Product
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Add Item</li>
      </ol>
</section>

<section class="content">
<form id="form" class="box" action="<?php echo base_url().'master/product/' ?>" method="post" enctype="multipart/form-data">
<div class="box-header with-border">
<h3 class="box-title">Form Upload New Items</h3>
</div>
<div class="box-body">
  <div class="row row-mar">
    <div class="col-sm-12 col-pad">
    <div class="title-form"><strong>Product Informations</strong></div>
    <hr class="mini-hr">
    </div>

    <div class="col-sm-6 col-pad">
    <div class="row row-mar">
        <?php if(count($brand) > 0){ ?>
        <div class="col-sm-6 col-pad">
            <div class="form-group">
            <label style="display: block">Barcode Number</label>
                <select name="brand" class="form-control select2" style="width: 100%;" required>
                    <option value="">Select Option</option>
                    <option value="0001">No Brand</option>
                    <?php foreach ($brand as $key => $value) { ?>
                        <option value="<?php echo $value['brand_code'] ?>"><?php echo $value['brand_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php } else { ?>
            <input type="hidden" name="brand" value="0001">
        <?php } ?>

    <div class="col-sm-6 col-pad">
    <div class="form-group">
    <label style="display: block">Item Code</label>
        <input type="text" class="form-control" name="itemcode" required>
    </div>
    </div>
    
    
    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Item Name</label>
    <input type="text" class="form-control" name="itemname" value="" required>
    </div>
    <div class="form-group">
    <label>Item Name Description</label>
    <input type="text" class="form-control" name="itemdesc">
    </div>
    </div>

    <?php if($all_hirarki->num_rows() > 0){ ?>
    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Category</label>
    
    <select name="category[]" class="form-control select2" style="width: 100%;" multiple="multiple" required>
    <?php
    foreach ($all_hirarki->result() as $cat) {
    ?>
        <option value="<?php echo $cat->path ?>">
        <?php echo strtoupper($cat->name_level1.ol($cat->name_level2).ol($cat->name_level3).ol($cat->name_level4).ol($cat->name_level5)) ?>
        </option>
    <?php } ?>
    </select>
    </div>
    </div>
    <?php } ?>
    
    <div class="col-sm-4 col-pad">
    <div class="form-group">
    <label>Weight (gram) </label>
    <input type="number" class="form-control" name="weight" min="0" placeholder="Gram" value="400" required>
    </div>
    </div>

    <div class="col-sm-4 col-pad">
        <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control" name="price" placeholder="Rp" value="0" required="">
        </div>
    </div>

    <div class="col-sm-4 col-pad">
        <div class="form-group">
        <label>Discount</label>
        <div class="input-group input-group disc-panel">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default">
                <span id="disc_concept">%</span>
            </div>
            <input type="hidden" name="disc_param" value="%" id="disc_param">
            <input type="number" max="100" min="0" name="disc" value="0" class="form-control">
        </div>
        </div>
    </div>

    
    
    </div>
    </div>

    <div class="col-sm-6">

        <div class="row row-mar">

            <div class="col-sm-12 col-pad">
                <div class="form-group">
                    <label>Product Type</label>
                    <select id="product_type" name="product_type" class="form-control select2">
                      <option value="1">-- Only Stock --</option>
                      <option value="2">-- Product Color --</option>
                      <option value="3">-- Product Size --</option>
                      <option value="4">-- Product Color & Size --</option>
                    </select>
                </div>

                <div id="type_stock">
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" class="form-control" name="stock">
                    </div>
                </div>

                <div id="type_color">
                    <div class="form-group">
                    <label>Color</label>
                    <select name="color[]" class="form-control select2" style="width: 100%;" multiple="multiple">
                        <?php foreach ($color as $key => $value) { ?>
                            <option value="<?php echo $value['ID_color'] ?>"><?php echo strtoupper($value['ColorName']) ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>

                <div id="type_size">
                    <div class="form-group">
                    <label>Size</label>
                    <select name="size[]" class="form-control select2" style="width: 100%;" multiple="multiple">
                        <?php foreach ($size as $key => $value) { ?>
                            <option value="<?php echo $value['ID_size'] ?>"><?php echo strtoupper($value['Size']) ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>


                
            </div>

            <div class="col-sm-12 col-pad">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control textarea" rows="5" name="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            </div>
            <?php /* if($data_produk){ ?>
            <div class="col-sm-12 col-pad">
                <div class="form-group">
                    <label>Color Available</label>
                </div>
                <?php foreach ($data_produk['warna'] as $key => $value) { ?>
                <div class="box-color">
                    <input type="hidden" name="barcode[]" value="<?php echo $value['barcode'] ?>">
                    <input type="hidden" name="color[]" value="<?php echo $value['warnaid'] ?>">
                  <label>
                    <?php echo strtoupper($value['warna']) ?>
                  </label>
                </div>
                <?php } ?>
            </div>
            <?php } */ ?>
        </div>
    </div>

  </div>
</div>


<div class="box-footer text-right">
    <button class="btn btn-success" type="submit">Add Product Master</button>
</div>
</form>
</section>





<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">



$(function(){
    $(".textarea").wysihtml5({ 
       toolbar: {
            'font-styles': false,
            'blockquote': false,
            'image': false,
            'lists' : true
          },
    });

    $(".select2").select2({
         minimumResultsForSearch: -1
    });

    $("#type_color, #type_size").hide();
    $("#type_stock input").attr('required', true);

    $("#product_type").on('change', function(){
        var selected = $(this).val();
        $("#type_stock, #type_color, #type_size").hide();
        $("#type_stock").find('input').attr('required', false);
        $("#type_color, #type_size").find('select').attr('required', false);
        if(selected == 1){
            $("#type_stock").show();
            $("#type_stock input").attr('required', true);
        }
        else if(selected == 2 || selected == 4){
            $("#type_color").show();
            $("#type_color select").attr('required', true);
        }
        else if(selected == 3){
            $("#type_size").show();
            $("#type_size select").attr('required', true);
        }
        else{
            alert('Select Product Type');
        }
    });
    
});
</script>


            