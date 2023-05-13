<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<style type="text/css">
.gbrupload {
    background-image: url('<?php echo base_url() ?>assets/image/product/762X1110.jpg');
    width: 100%;
    height: 100%;
    margin-right: 10px;
    background-position: center center;
    background-size: contain;
    background-repeat: no-repeat;
    position: relative;
    z-index: 10;
}
.custom-file-input {
    display: inline-block;
    position: relative;
    width: 100%;
    top: 0px;
    left: 0px;
    height: 30px;
    background-color: rgb(238, 238, 238);
    color: #333;
    border-radius: 4px;
    overflow: hidden;
    cursor: text;
    border: 1px solid #fff;
}
.custom-file-input span {
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 0 10px;
    overflow: hidden;
}
.custom-file-input span + span {
    text-align: center;
    font-weight: 600;
    background-color: rgb(238, 238, 238);
    border-radius: 0 4px 4px 0;
    padding: 0px 15px;
}
.custom-file-input input {
    opacity: 0;
    filter: alpha(opacity=0);
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 2000%;
    z-index: 4;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 0px;
}
.select2-container .select2-selection--single, .select2-container .select2-selection--multiple{
    height: 34px;
}
</style>
<section class="content-header">
      <h1>
        Adding items
        <small>Lorem ipsum dolor sit amet.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Add Item</li>
      </ol>
</section>

<section class="content">
<form class="box" action="<?php echo base_url().'process_entersite/additems' ?>" method="post" enctype="multipart/form-data">
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
    <div class="col-sm-5 col-pad">
    <div class="form-group">
    <label>Item Code</label>
    <input type="text" class="form-control" name="itemcode" required>
    </div>
    </div>
    <div class="col-sm-7 col-pad">
    <div class="form-group">
    <label>Publish Product</label>
    <p>
        <label style="margin-bottom: 0px;">
        <input type="radio" name="publish" value="11" checked>
        Yes
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label style="margin-bottom: 0px;">
        <input type="radio" name="publish" value="01">
        No
        </label>
    </p>
    </div>
    </div>
    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Item Name</label>
    <input type="text" class="form-control" name="itemname" required>
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
    
    <select name="category[]" class="form-control select2" style="width: 100%;" multiple="multiple">
    <?php
    foreach ($all_hirarki->result() as $cat) {
    ?>
        <option value="<?php echo my_slug($cat->name_level1.ol($cat->name_level2).ol($cat->name_level3).ol($cat->name_level4).ol($cat->name_level5)) ?>">
        <?php echo strtoupper($cat->name_level1.ol($cat->name_level2).ol($cat->name_level3).ol($cat->name_level4).ol($cat->name_level5)) ?>
        </option>
    <?php } ?>
    </select>
    </div>
    </div>
    <?php } ?>
    
    
    
    <div class="col-sm-4 col-pad">
    <div class="form-group">
    <label>Price</label>
    <input type="number" class="form-control" name="price" placeholder="Rp" required>
    </div>
    </div>
    <div class="col-sm-4 col-pad">
    <div class="form-group">
    <label>Discount</label>
    <div class="input-group input-group disc-panel">
        <div class="input-group-btn">
            <button type="button" class="btn btn-default">
            <span id="disc_concept">%</span>
            <span class="fa fa-caret-down"></span></button>
        </div>
        <input type="hidden" name="disc_param" value="%" id="disc_param">
        <!-- /btn-group -->
        <input type="number" max="100" min="0" name="disc" class="form-control">
    </div>
    </div>
    </div>
    <div class="col-sm-4 col-pad">
    <div class="form-group">
    <label>Weight</label>
    <input type="number" class="form-control" name="weight" min="0" placeholder="Gram" required>
    </div>
    </div>

    <div class="col-sm-12 col-pad">
    <div class="form-group">
    <label>Description</label>
    <textarea class="form-control textarea" rows="5" name="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
    </div>
    </div>
    </div>
    </div>

<?php
if($listcolor->num_rows() > 0){
    $type2 = '<option value="2">-- Color --</option>';
}else{
    $type2 = '';
}
if($listsize->num_rows() > 0){
    $type3 = '<option value="3">-- Size --</option>';
}else{ 
    $type3 = '';
}
if($listcolor->num_rows() > 0 && $listsize->num_rows() > 0){
    $type4 = '<option value="4">-- Size & Color --</option>';
}else{
    $type4 = '';
}
?>

    <div class="col-sm-6 col-pad">
    
    <div class="form-group">
        <label>Product Type</label>
        <select id="product_type" name="product_type" class="form-control">
          <option value="1">-- Normal --</option>
          <?php echo $type2 ?>
          <?php echo $type3 ?>
          <?php echo $type4 ?>
        </select>
    </div>
    <!-- TYPE 1 -->
    <div id="type_1" class="form-group row row-mar">
        <div class="col-sm-3 col-pad">
            <label>Stock</label>
            <input type="number" name="stock[]" class="form-control type1_rec" required>
        </div>
    </div>
    <?php if($listcolor->num_rows() > 0){ ?>
    <!-- TYPE 2 -->
    <div id="type_2" class="hide">
        <div class="form-group row row-mar">
            <div class="col-sm-12 col-pad text-right product-default">
            <label style="margin-bottom: 0px;">
            <input type="radio" name="defaultitem2" value="0" checked>
            Default Item
            </label>
        </div>
        </div>
        <div class="form-group row row-mar">
        <div class="col-sm-6 col-pad">
        <label>Color</label>
        <select name="color[]" class="select2 form-control color-select type2_rec">
          <option value="">-- Select Color --</option>
          <?php foreach ($listcolor->result() as $color) { ?>
          <option value="<?php echo $color->ID_color ?>"><?php echo strtoupper($color->ColorName) ?></option> 
          <?php } ?> 
        </select>
        </div>
        <div class="col-sm-3 col-pad">
            <label>Stock</label>
            <input type="number" name="stock[]" class="form-control type2_rec">
        </div>
        </div>
    </div>
    <?php } 
    if($listsize->num_rows() > 0){
    ?>
    <!-- TYPE 3 -->
    <div id="type_3" class="hide">
        <div class="form-group row row-mar">
            <div class="col-sm-12 col-pad text-right product-default">
                <label style="margin-bottom: 0px;">
                <input type="radio" name="defaultitem3" value="0" checked>
                Default Item
                </label>
            </div>
        </div>
        <div class="size_product">
        <div class="form-group row row-mar">
        <div class="col-xs-6 col-pad">
        <label>Size</label>
        <select name="size[]" class="form-control select2 disselectSize type3_rec" style="width: 100%">
        <option value="">-- Select Size --</option>
        <?php  
        foreach($listsize->result() as $size){
        ?>
        <option value="<?php echo $size->ID_size ?>"><?php echo strtoupper($size->Size) ?></option>
        <?php } ?>
        </select>
        </div>
        <div class="col-xs-3 col-pad">
            <label>Stock</label>
            <input type="number" name="stock[]" class="form-control type3_rec">
        </div>
        <div class="col-xs-3 col-pad text-right">
            <label style="display: block; visibility: hidden;">Button</label>
            <button type="button" class="btn btn-default btn-stock-plus"><i class="fa fa-plus"></i></button>
        </div>
        </div>

        <div class="next_size">
        
        </div>

        </div>
    </div>
    <?php } 
    if($listcolor->num_rows() > 0 && $listsize->num_rows() > 0){
    ?>
    <!-- TYPE 4 -->
    <div id="type_4" class="hide">
        <div class="form-group row row-mar">
        <div class="col-sm-6 col-pad">
        <label>Color</label>
        <select name="color[]" class="select2 form-control color-select type4_rec">
          <option value="">-- Select Color --</option>
          <?php foreach ($listcolor->result() as $color) { ?>
          <option value="<?php echo $color->ID_color ?>"><?php echo strtoupper($color->ColorName) ?></option> 
          <?php } ?> 
        </select>
        </div>
        <div class="col-sm-6 col-pad text-right product-default">
            <label style="display: block; visibility: hidden;">V</label>
            <label style="margin-bottom: 0px;">
            <input type="radio" name="defaultitem4" value="0" checked>
            Default Item
            </label>
        </div>
        </div>
        <div class="size_product">
        <div class="form-group row row-mar">
        <div class="col-xs-6 col-pad">
        <label>Size</label>
        <select name="size0[]" class="form-control select2 disselectSize type4_rec" style="width: 100%">
        <option value="">-- Select Size --</option>
        <?php  
        foreach($listsize->result() as $size){
        ?>
        <option value="<?php echo $size->ID_size ?>"><?php echo strtoupper($size->Size) ?></option>
        <?php } ?>
        </select>
        </div>
        <div class="col-xs-3 col-pad">
            <label>Stock</label>
            <input type="number" name="stock0[]" class="form-control type4_rec">
        </div>
        <div class="col-xs-3 col-pad text-right">
            <label style="display: block; visibility: hidden;">Button</label>
            <button type="button" class="btn btn-default btn-stock-plus"><i class="fa fa-plus"></i></button>
        </div>
        </div>
        <div class="next_size"> </div> 
        </div>
    </div>
    <?php } ?>

    

    <div class="wrap-color--image form-group row row-mar">
      <div class="col-sm-4 col-pad image--preview">
        <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imagemain[]" required>
            </span>
        </div>
      </div>
      <div class="col-sm-4 col-pad image--preview">
        <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imageseco[]" required>
            </span>
        </div>
      </div>
      <div class="col-sm-4 col-pad image--preview">
        <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imagethir[]" required>
            </span>
        </div>
      </div>
    </div>

    <div id="new-item-color">
    </div>

    <?php if($listcolor->num_rows() > 1){ ?>
    <div id="new_list_product" class="hide">
      <hr>
      <button type="button" class="btn btn-default add-color-item"><i class="fa fa-plus"></i>&nbsp;&nbsp; Product</button>
    </div>
    <?php } ?>
    </div>
    

    <div class="col-sm-12 col-pad">
    <br>
    <hr>
    <h4>SEO</h4>
    <br>
    <div class="form-group">
        <label>Page Title</label>
        <input type="text" class="form-control" name="seo_title">
    </div>
    <div class="form-group">
        <label>Meta Descriptions</label>
        <input type="text" class="form-control" name="seo_descriptions">
    </div>
    <div class="form-group">
        <label>Meta Keywords</label>
        <input type="text" class="form-control" name="seo_keywords">
    </div>
    </div>

  </div>
</div>


<div class="box-footer text-right">
    <button class="btn btn-success" type="submit" name="additems" value="true">Add Product(s)</button>
</div>
</form>
</section>





<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">
function init_DelNewStock(){
    var length = '<?php echo $listsize->num_rows() ?>';
}

function init_DeleteNewItem($def){
    var length = '<?php echo $listcolor->num_rows() ?>',
        newite = parseInt($('.new-item').length)+$def;
        //alert(newite+' '+length);
    if(newite == length){
        $('.add-color-item').addClass('hidden');
    }else{
        $('.add-color-item').removeClass('hidden');
    }
}

function selectReady(){
    $(".select2").select2({
        minimumResultsForSearch: -1
    });
}

function disselect(){
    $("body .select2.color-select").each(function(){
      var val = $(this).select2({
        minimumResultsForSearch: -1
    }).find(":selected").val();
      $('body .select2.color-select').not(this).find('option').filter(function() {
      return this.value === val;
      }).prop('disabled', true);
    });
}

function disselectSize(e){
    $("body").find(e.target).closest('.size_product').find(".select2.disselectSize").each(function(){
      var val = $(this).select2({
        minimumResultsForSearch: -1
    }).find(":selected").val();
      $("body").find(e.target).closest('.size_product').find('.select2.disselectSize').not(this).find('option').filter(function() {
      return this.value === val;
      }).prop('disabled', true);
    });
}

function size_product_html(place, number=''){
var size_product_html = '<div class="form-group  row row-mar add-new-stck"> <div class="col-xs-6 col-pad"> <select name="size'+number+'[]" class="form-control select2 disselectSize" style="width: 100%" required> <option value="">-- Select Size --</option> <?php foreach($listsize->result() as $size){?> <option value="<?php echo $size->ID_size ?>"><?php echo strtoupper($size->Size) ?></option> <?php } ?> </select> </div> <div class="col-xs-3 col-pad"> <div class="input-group input-group"> <input type="number" name="stock'+number+'[]" class="form-control" required> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-stck-remove btn-flat"><i class="fa fa-trash"></i></button> </span> </div> </div> </div>';
    place.append(size_product_html);
}


$(function(){

$('.disc-panel .dropdown-menu').find('a').click(function(e) {
    e.preventDefault();
    var param = $(this).attr("href").replace("#","");
    var concept = $(this).text();
    $('.disc-panel span#disc_concept').text(concept);
    $('#disc_param').val(param);
});

$("body").on('change', '.select2.color-select', function(e) {
   disselect();
});
$("body").on('change', '.select2.disselectSize', function(e) {
   disselectSize(e);
});

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

$("body").on('click', '.btn-stck-remove', function(){
var ini    = $(this).closest('.add-new-stck');
var length = '<?php echo $listsize->num_rows() ?>';
var newst  = $(this).closest('.size_product').find('.add-new-stck').length+2;
    if(newst <= length){
        $(this).closest('.size_product').find('.btn-stock-plus').removeClass('hide');
    }
    ini.remove();
});


$("body").on('click', '.btn-stock-plus', function(e){
    var type    = $("#product_type").val();
    var newname = parseInt($('.new-item').length);
    var ini     = $(this).closest('.size_product').find('.next_size');
    var length  = '<?php echo $listsize->num_rows() ?>';
    var newst   = $(this).closest('.size_product').find('.add-new-stck').length+2;
    if(newst <= length){
        if(type == 4){
            size_product_html(ini, newname);
        }else{
            size_product_html(ini);
        }
        selectReady();
        disselectSize(e);
    }else{
        $(this).addClass('hide');
    }

});

$('body').on('change', '.btn-img-prev', function(){
        var files = !!this.files ? this.files : [],
            ini   = $(this).parents('.image--preview').find('.gbrupload');
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                ini.css("background-image", "url("+this.result+")");
                }
            }
});

var copy;
$("#product_type").on('change', function(){
var type    = $(this).val(),
    newname = parseInt($('.new-item').length)+ 1;
    init_DeleteNewItem(1);
    $('#new-item-color').html('');
    if(type == 1){
        $(".type1_rec").attr({'required': true, 'disabled': false});
        $(".type2_rec, .type3_rec, .type4_rec").attr({'required': false, 'disabled':true});
        $("#type_1").removeClass('hide');
        $("#type_2, #type_3, #type_4").addClass('hide');
        <?php if($listcolor->num_rows() > 1){ ?>
        $("#new_list_product").addClass('hide');
        <?php } ?>
        copy = '';
    }else if(type == 2){
        $(".type2_rec").attr({'required': true, 'disabled': false});
        $(".type1_rec, .type3_rec, .type4_rec").attr({'required': false, 'disabled':true});
        $("#type_2").removeClass('hide');
        $("#type_2 .product-default input").prop('checked', true);
        $("#type_1, #type_3, #type_4").addClass('hide');
        <?php if($listcolor->num_rows() > 1){ ?>
        $("#new_list_product").removeClass('hide');
        <?php } ?>
        copy = '<div class="new-item"><hr><div class="form-group row row-mar"><div class="text-right col-sm-12"><button class="btn btn-default trash-color"><i class="fa fa-trash"></i></button></div> <div class="col-sm-12 col-pad text-right product-default"> <label style="margin-bottom: 0px;"> <input type="radio" name="defaultitem2" value="'+newname+'"> Default Item</label> </div> </div> <div class="form-group row row-mar"> <div class="col-sm-6 col-pad"> <label>Color</label> <select name="color[]" class="select2 form-control color-select" required> <option value="">-- Select Color --</option> <?php foreach ($listcolor->result() as $color) { ?> <option value="<?php echo $color->ID_color ?>"><?php echo strtoupper($color->ColorName) ?></option> <?php } ?> </select> </div> <div class="col-sm-3 col-pad"> <label>Stock</label> <input type="number" name="stock[]" class="form-control" required> </div> </div> <div class="wrap-color--image form-group row row-mar"> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imagemain[]" required> </span> </div> </div> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imageseco[]" required> </span> </div> </div> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imagethir[]" required> </span> </div> </div> </div></div>';
    }else if(type == 3){
        $(".type3_rec").attr({'required': true, 'disabled': false});
        $(".type2_rec, .type1_rec, .type4_rec").attr({'required': false, 'disabled':true});
        $("#type_3").removeClass('hide');
        $("#type_3 .product-default input").prop('checked', true);
        $("#type_2, #type_1, #type_4").addClass('hide');
        <?php if($listcolor->num_rows() > 1){ ?>
        $("#new_list_product").addClass('hide');
        <?php } ?>
        copy = '';
    }else if(type == 4){
        $(".type4_rec").attr({'required': true, 'disabled': false});
        $(".type2_rec, .type3_rec, .type1_rec").attr({'required': false, 'disabled':true});
        $("#type_4").removeClass('hide');
        $("#type_4 .product-default input").prop('checked', true);
        $("#type_2, #type_3, #type_1").addClass('hide');
        <?php if($listcolor->num_rows() > 1){ ?>
        $("#new_list_product").removeClass('hide');
        <?php } ?>
        copy = '<div class="new-item"><hr><div class="form-group row row-mar"><div class="text-right col-sm-12"><button class="btn btn-default trash-color"><i class="fa fa-trash"></i></button></div> <div class="col-sm-6 col-pad"> <label>Color</label> <select name="color[]" class="select2 form-control color-select" required> <option value="">-- Select Color --</option> <?php foreach ($listcolor->result() as $color) { ?> <option value="<?php echo $color->ID_color ?>"><?php echo strtoupper($color->ColorName) ?></option> <?php } ?> </select> </div> <div class="col-sm-6 col-pad text-right product-default"> <label style="display: block; visibility: hidden;">V</label> <label style="margin-bottom: 0px;"> <input type="radio" name="defaultitem4" value="'+newname+'"> Default Item </label> </div> </div> <div class="size_product"> <div class="form-group row row-mar"> <div class="col-xs-6 col-pad"> <label>Size</label> <select name="size'+newname+'[]" class="form-control select2 disselectSize" style="width: 100%" required> <option value="">-- Select Size --</option> <?php foreach($listsize->result() as $size){?> <option value="<?php echo $size->ID_size ?>"><?php echo strtoupper($size->Size) ?></option> <?php } ?> </select> </div> <div class="col-xs-3 col-pad"> <label>Stock</label> <input type="number" name="stock'+newname+'[]" class="form-control" required> </div> <div class="col-xs-3 col-pad text-right"> <label style="display: block; visibility: hidden;">Button</label> <button type="button" class="btn btn-default btn-stock-plus"><i class="fa fa-plus"></i></button> </div> </div> <div class="next_size"> </div> </div> <div class="wrap-color--image form-group row row-mar"> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imagemain[]" required> </span> </div> </div> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imageseco[]" required> </span> </div> </div> <div class="col-sm-4 col-pad image--preview"> <div class="gbrupload"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div> <div class="custom-file-input"> <span></span> <span> <i class="icon-picture"></i>&nbsp; &nbsp;Browse <input type="file" class="btn-img-prev" name="imagethir[]" required> </span> </div> </div> </div></div>';
    }else{
        $("#type_1").removeClass('hide');
        $("#type_2, #type_3, #type_4").addClass('hide');
        <?php if($listcolor->num_rows() > 1){ ?>
        $("#new_list_product").addClass('hide');
        <?php } ?>
        copy = '';
    }
    selectReady();
    init_DeleteNewItem(1);
});


<?php if($listcolor->num_rows() > 1){ ?>

$('.add-color-item').on('click', function(){
    $('#new-item-color').append(copy);
    selectReady();
    disselect();
    init_DeleteNewItem(1);
});

$('body').on('click', '.trash-color', function(){
    $(this).parents('.new-item').remove();
    init_DeleteNewItem(1);
});

<?php } ?>



});
</script>


            