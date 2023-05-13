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
.box-wrapper{
    width: auto;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: auto;
    margin-bottom: 15px;
}
.box-color{
    border-radius: 6px;
    border: 1px solid #d5d5d5;
    padding: 20px;
    
}
</style>
<section class="content-header">
      <h1>
        Master Product <?php echo $row['item_name'] ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Edit Item</li>
      </ol>
</section>

<section class="content">
<form id="form" class="box" action="<?php echo base_url().'master/product-master/edit/'.$row['id'] ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
<div class="box-header with-border">
<h3 class="box-title">Form Edit Items</h3>
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
                <select name="brand" class="form-control select2" style="width: 100%;" required disabled>
                    <option value="">Select Option</option>
                    <option value="0001">No Brand</option>
                    <?php foreach ($brand as $key => $value) { 
                        $select = ($row['brand'] == $value['brand_code']) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $value['brand_code'] ?>" <?php echo $select ?>><?php echo $value['brand_name'] ?></option>
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
        <input type="text" class="form-control" name="itemcode" value="<?php echo $row['item_code'] ?>" required readonly>
    </div>
    </div>
    
    
    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Item Name</label>
    <input type="text" class="form-control" name="itemname" value="<?php echo $row['item_name'] ?>" required>
    </div>
    <div class="form-group">
    <label>Item Name Description</label>
    <input type="text" class="form-control" name="itemdesc" value="<?php echo $row['item_desc'] ?>">
    </div>
    </div>

    <?php if($all_hirarki->num_rows() > 0){ ?>
    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Category</label>
    
    <select name="category[]" class="form-control select2" style="width: 100%;" multiple="multiple" required>
    <?php
    $category = explode(',', $row['ItemSubcate']);

    foreach ($all_hirarki->result() as $cat) {
        
        if(in_array($cat->path, $category, false)){
            $select = 'selected';
        }else{
            $select = '';
        }
    ?>
        <option value="<?php echo $cat->path ?>" <?php echo $select ?>>
        <?php echo strtoupper($cat->name_level1.ol($cat->name_level2).ol($cat->name_level3).ol($cat->name_level4).ol($cat->name_level5)) ?>
        </option>
    <?php } ?>
    </select>
    </div>
    </div>
    <?php } ?>
    
    <div class="col-sm-4 col-pad">
    <div class="form-group">
    <label>Weight (gram)</label>
    <input type="number" class="form-control" name="weight" min="0" placeholder="Gram" value="<?php echo $row['weight'] ?>" required>
    </div>
    </div>

    <div class="col-sm-12 col-pad">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control textarea" rows="5" name="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $row['item_longdesc'] ?></textarea>
            </div>
            </div>


    
    
    </div>
    </div>

    <div class="col-sm-6">

        <div class="row row-mar">
            <?php if($row['ItemType'] == 2 || $row['ItemType'] == 4) { ?>
            <div class="col-sm-12 col-pad">
                

                <div class="form-group">
                    <label>Already Color</label>
                </div>
                <?php foreach ($row['color_ready'] as $key => $value) {  ?>
                    <div class="box-wrapper">
                        <div style="display: block;">
                        <div class="box-color">
                        <a href="<?php echo base_url('master/product_data/'.$value['ID_map']) ?>">
                          <label>
                            <?php echo strtoupper($value['ColorName']) ?>
                          </label>
                          <div><?php echo ($value['status'] == '11') ? 'active' : 'no-active'; ?></div>
                        </a>
                        </div>
                        
                        <div class="delete text-center">
                            <a href="<?php echo base_url('master/product-delete/'.$value['ID_map']) ?>" onclick="return confirm('Anda yakin akan menghapus warna ini ?');" class="btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        
                       </div>
                        
                    </div>
                <?php } ?>
            </div>

            <div class="col-sm-12 col-pad">
                <div class="form-group">
                <label>New Color</label>
                <select name="color[]" class="form-control select2" style="width: 100%;" multiple="multiple">
                    <?php foreach ($color as $key => $value) { 
                        if(in_array($value['ID_color'], $row['color'], false)){
                            $select = 'disabled';
                        }else{
                            $select = '';
                        }
                    ?>
                        <option value="<?php echo $value['ID_color'] ?>" <?php echo $select ?>><?php echo strtoupper($value['ColorName']) ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <?php } 
            if($row['ItemType'] == 3){ ?>
            
            <div class="col-sm-12 col-pad">

                <div class="form-group">
                    <label>Already Size</label>
                </div>
                <?php foreach ($row['size_ready'] as $key => $value) {  ?>
                    <div class="box-wrapper">
                        <a href="<?php echo base_url('master/product_data/') ?>">
                        <div class="box-color">
                          <label>
                            <?php echo strtoupper($value['Size']) ?>
                          </label>
                        </div>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="col-sm-12 col-pad">
                <div class="form-group">
                <label>New Size</label>
                <select name="size[]" class="form-control select2" style="width: 100%;" multiple="multiple">
                    <?php foreach ($size as $key => $value) { 
                        if(in_array($value['ID_size'], $row['size'], false)){
                            $select = 'disabled';
                        }else{
                            $select = '';
                        }
                    ?>
                        <option value="<?php echo $value['ID_size'] ?>" <?php echo $select ?>><?php echo strtoupper($value['Size']) ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <?php } ?>


            
        </div>
    </div>

  </div>
</div>


<div class="box-footer text-right">
    <button class="btn btn-success" type="submit">Edit Product Master</button>
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

    $(".select2").select2();
});
</script>


            