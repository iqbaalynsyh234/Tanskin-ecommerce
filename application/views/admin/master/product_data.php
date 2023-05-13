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
        <?php echo $produk['ItemName'] ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Add Item</li>
      </ol>
</section>

<section class="content">
<form class="box" action="<?php echo base_url().'master/product_data/'.$id ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="id_map" value="<?php echo $id ?>">
<div class="box-header with-border">
<h3 class="box-title">Form Data Items</h3>
</div>
<div class="box-body">
  <div class="row row-mar">

    <div class="col-sm-12 col-pad">
    <div class="title-form"><strong>Product Informations</strong></div>
    <hr class="mini-hr">
    </div>

    


    <div class="col-sm-12 col-pad">
    

    <div class="wrap-color--image form-group row row-mar">

    <div class="col-sm-12 col-pad">
        <div class="row row-mar">
            <div class="col-sm-4 col-pad">
            <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" value="<?php echo $produk['ItemName'] ?>" readonly>
            </div>
            </div>

            <?php if( $produk['ItemType'] == 2 ||   $produk['ItemType'] == 4) { ?>
            <div class="col-sm-4 col-pad">
            <div class="form-group">
            <label>Color</label>
            <input type="text" class="form-control" value="<?php echo ($produk['ItemType'] == 4) ? $produk['stock'][0]['ColorName'] : $produk['stock']['ColorName'] ?>" readonly>
            </div>
            </div>
            <?php } ?>

            <div class="col-sm-4 col-pad">
            <div class="form-group">
            <label>Item Code</label>
            <input type="text" class="form-control" value="<?php echo $produk['ItemCode'] ?>" readonly>
            </div>
            </div>
            

        </div>
    </div>

    

    <div class="col-sm-12 col-pad">
        <div class="row row-mar">
            <div class="col-sm-4 col-pad">
                <div class="form-group">
                <label>Publish Product</label>
                <p>
                    <label style="margin-bottom: 0px;">
                    <input type="radio" name="publish" value="11" <?php echo ($produk['publish'] == '11') ? 'checked' : ''; ?>>
                    Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="margin-bottom: 0px;">
                    <input type="radio" name="publish" value="01" <?php echo ($produk['publish'] == '01') ? 'checked' : ''; ?>>
                    No
                    </label>
                </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-pad">
        <div class="row row-mar">
            <?php /*/ ?>
            <div class="col-sm-4 col-pad">
                <div class="form-group">
                    <label>Size</label>
                    <select name="size[]" class="form-control select2" style="width: 100%;" required>
                        <option>-- Select Size --</option>
                        <?php foreach ($size as $key => $value) { 
                            $selected = ($value['ID_size'] == $produk['stock']['ID_size']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $value['ID_size'] ?>" <?php echo $selected ?>><?php echo strtoupper($value['Size']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php /*/ if( $produk['ItemType'] == 1 ||   $produk['ItemType'] == 2) { ?>

            <div class="col-sm-4 col-pad">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="text" class="form-control" name="stock" value="<?php echo $produk['stock']['stock'] ?>">
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php if( $produk['ItemType'] == 3 ||   $produk['ItemType'] == 4) { ?>
    <div class="col-sm-12 col-pad">
        <div class="row row-mar">
            <div class="col-sm-8 col-pad">
                <div id="wrap_size" class="row row-mar form-group">
                    <div class="col-sm-6 col-pad">
                        <label>Size</label>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <label>Stock</label>
                    </div>
                    <?php 
                    $array_size = array();
                    foreach ($produk['stock'] as $key => $value) { 
                        array_push($array_size, $value['ID_size']);
                        ?>
                       <div class="col-sm-6 col-pad">
                        
                        <input class="form-control" name="size[]" value="<?php echo $value['Size'] ?>" readonly>
                       </div>
                       <div class="col-sm-6 col-pad">
                        
                        <div class="form-inline">
                            <input class="form-control" name="stock[]" value="<?php echo $value['stock'] ?>">
                            <a href="<?php echo base_url('master/del_size/'.$value['ID_ms']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </div>
                       </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-8 col-pad">
                <div class="form-group">
                    <button id="btn-plus-size" type="button" class="btn btn-default " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Size</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="col-sm-12 col-pad">
        <div class="row row-mar">
        <div class="col-sm-4 col-pad">
            <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="price" placeholder="Rp" value="<?php echo $produk['ItemPrice'] ?>" required>
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
                <input type="number" max="100" min="0" name="disc" value="<?php echo $produk['ItemDisc'] ?>" class="form-control">
            </div>
            </div>
        </div>
        </div>
    </div>

    

    <div class="col-sm-12 col-pad">
      <div class="row row-mar">
      <?php for ($i=0; $i < 6; $i++) { 
        $image = ($produk['image'][$i] != "") ? 'background-image:url('.base_url('assets/image/product/'.$produk['image'][$i]).')' : '';
      ?>
      <div class="col-sm-2 col-pad image--preview">
        <div class="form-group">
            <div class="gbrupload" style="<?php echo $image ?>"><img src="<?php echo base_url().'assets/image/product/wrap.png' ?>" class="img-responsive"></div>
            <div class="custom-file-input">
                <span></span>
                <span>
                <i class="icon-picture"></i>&nbsp; &nbsp;Browse
                <input type="file" class="btn-img-prev" name="imagemain[]" <?php echo ($image != "") ? '' : ''; ?>>
                </span>
            </div>
        </div>
      </div>
      <?php } ?>
      </div>
    </div>

    <div class="col-sm-12 col-pad">
        <div class="form-group">
            <label>Url Video</label>
            <input type="text" class="form-control" name="video" value="<?php echo $produk['video'] ?>">
            <span>Youtube video ID</span>
        </div>
    </div>

    </div>

   
    </div>
    

    

  </div>
</div>


<div class="box-footer text-right">
    <button class="btn btn-success" type="submit">Add Product(s)</button>
</div>
</form>
</section>


<?php if( $produk['ItemType'] == 3 || $produk['ItemType'] == 4) { ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Size</h4>
      </div>
      <form action="<?php echo base_url('master/addsize') ?>" method="post">
        <input type="hidden" name="id_map" value="<?php echo $id ?>">
      <div class="modal-body row">
        <div class="col-sm-8">
            <div class="form-group">
                    <label>Size</label>
                    <select name="size" class="form-control select2" style="width: 100%;" required>
                        <option>-- Select Size --</option>
                        <?php foreach ($size as $key => $value) { 
                            if(in_array($value['ID_size'], $array_size, false)){
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
        <div class="col-sm-4">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="text" class="form-control" name="stock" value="" required>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>    
<?php } ?>


<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">

function selectReady(){
    $(".select2").select2({
        minimumResultsForSearch: -1
    });
}

$(function(){

selectReady();

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

});


</script>


            