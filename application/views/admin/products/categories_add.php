<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<section class="content-header">
      <h1>
        Categories
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().'entersite/' ?>">Admin</a></li>
        <li><a href="<?php echo base_url().'entersite/product/categories' ?>">Category</a></li>
        <li class="active">Add Category</li>
      </ol>
</section>

<section class="content">
<div class="row row-mar">
	<div class="col-sm-12 col-pad">
	<div class="box">
	<div class="box-header with-border">
	<h3 class="box-title">Tambah Kategori Produk</h3>
	</div>
	<form action="<?php echo base_url().'process_entersite/addcategory' ?>" class="myform" method="post">
	<div class="box-body">
  <div class="row row-mar">
  <div class="col-sm-8 col-pad">
      <div class="form-group">
            <label>Title *</label>
            <input type="text" name="category" maxlength="25" class="form-control">
      </div>

      <div class="form-group">
            <label>Description</label>
            <textarea name="deskripsi" class="textarea form-control"></textarea>
      </div>

      <div class="row row-mar">
        <div class="col-sm-6 col-pad">
        <div class="form-group">
              <label>Parent Category</label>
              <select name="parent_id" class="form-control select2" style="width: 100%">
                <option value="">-- Select Options --</option>
                <?php 
                foreach($all_hirarki->result() as $oy){
                  echo '<option value="'.$oy->ID_cat.'">'.strtoupper($oy->name_level1.ol($oy->name_level2).ol($oy->name_level3).ol($oy->name_level4).ol($oy->name_level5)).'</option>';
                } ?>
              </select>
        </div>
        </div>
      </div>
      
      <hr class="mini-hr">
      <div class="form-group">
          <label>This is a Special Category</label>
          <div class="checkbox">
            <label>
              <input class="confirm-sub" name="specials" type="checkbox" value="specials type">
            </label>
          </div>
      </div>
      <div class="row row-mar">
        <div class="col-sm-6 col-pad">
        <div class="subcategory" style="display: none">
        <div class="form-group">
          <label>Special Type</label>
          <select name="special" class="form-control select2" style="width: 100%">
             <option value="">-- Select Options --</option>
             <option value="new">New</option>
             <option value="sale">Sale</option>
          </select>
        </div>
        </div>
      </div>
      </div>
      <hr class="mini-hr">
      <div class="form-group">
        <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="yes" checked="">
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="no">
                      No
                    </label>
                  </div>
                </div>
  </div>
  </div>
  
    

      
	</div>
  <div class="box-footer text-right">
      <button type="reset" class="btn btn-default" data-dismiss="modal">Batal</button>
      <button class="btn btn-primary" type="submit" name="submitcategory" value="true">Tambah Kategori</button>
  </div>
  </form>
	
	</div>
	</div>

	
</div>
</section>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">

$(function(){
	$('.confirm-sub').on('click', function(){
	if($(this).is(':checked')){
        $('.subcategory').show(75);
        $('.subcategory input').attr('disabled', false);
    }else{
        $('.subcategory').hide(75);
        $('.subcategory input').attr('disabled', true);
    }
	});

  $(".textarea").wysihtml5();
  $(".select2").select2({
      minimumResultsForSearch: -1
  });

  $('.myform').validate({
    rules:{
      category : "required"
    },
    errorPlacement: function(error, element){}
  });
});
</script>