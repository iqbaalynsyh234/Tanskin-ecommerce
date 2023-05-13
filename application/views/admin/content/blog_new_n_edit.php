<?php 
$uri = $this->uri->segment(3);
if($uri == 'edit') {
  $edit = $edit->row();
  $title = 'Edit Blog / '.$edit->title;
  $brdcm = 'Edit';
  if($edit->publish == '11'){
    $yes = 'checked';
    $no  = '';
  }else{
    $yes = '';
    $no  = 'checked';
  }
  $urilink = base_url('process_entersite/blog_action/edit/'.$this->uri->segment(4));
}else{
  $title = 'New Blog';
  $brdcm = 'New';
  $yes   = 'checked';
  $no    = '';
  $urilink = base_url('process_entersite/blog_action/new');
}
?>
<!-- bootstrap-wysiwyg -->
<link href="<?php echo base_url(); ?>assets/plugins/summernote-master/dist/summernote.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">


<section class="content-header">
      <h1>
        Blog Content
        <small>Halaman Static Website.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Blog</li>
        <li class="active"><?php echo $brdcm; ?></li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title"><?php echo $title ?></h3>
  </div>

<form id="obj-form" action="<?php echo $urilink; ?>" method="post" enctype="multipart/form-data">
    <div class="box-body">
    <div class="row">

    <div class="col-sm-8">
      <div class="form-group">
      <label>Judul</label>
      <input type="text" name="title" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->title.'"'; } ?> >
      </div>
    </div>

    <div class="col-sm-12">
    <div class="form-group">
    <label>Content</label>
     <textarea name="deskripsi" id="summernote">
     <?php if($uri == 'edit'){ echo $edit->content; } ?> 
     </textarea>
     </div>
    </div>

    <div class="col-sm-8">
      <div class="form-group">
      <label>Tags</label>
      <input type="text" name="tags" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->tags.'"'; } ?> data-role="tagsinput" />
      </div>
    </div>


    <div class="col-sm-12">
    <div class="judul-batas">
    SEO
    </div>
    </div>

    <div class="col-sm-8">
    <div class="form-group">
      <label>Page Title</label>
      <input type="text" name="seo1" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->meta_title.'"'; } ?>>
    </div>
    <div class="form-group">
      <label>Meta Description</label>
      <input type="text" name="seo2" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->meta_keyword.'"'; } ?>>
    </div>
    <div class="form-group">
      <label>Meta Keywords</label>
      <input type="text" name="seo3" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->meta_deskripsi.'"'; } ?>>
    </div>
    </div>

    <div class="col-sm-12">
    <div class="judul-batas">
    Visibility
    </div>
    <div class="form-group">
        <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="yes" <?php echo $yes ?>>
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="no" <?php echo $no ?>>
                      No
                    </label>
                  </div>
                </div>
    </div>

    </div>
     
    </div>
    <div class="box-footer text-right">
    <a href="<?php echo base_url('entersite/static-page') ?>" class="btn btn-default">Batal</a>
    <button type="submit" name="submit" value="true" class="btn btn-success">Simpan</button>
    </div>
   </form>

</div>
</section>




<!-- bootstrap-wysiwyg -->
<script src="<?php echo base_url() ?>assets/plugins/summernote-master/dist/summernote.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/data.content.js"></script>


<script type="text/javascript">

$(function(){
    $('#summernote').summernote({
      tabsize: 2,
      height: 350,
      fontNames: ['Arial', 'Arial Black', 'Courier New', 'Helvetica', 'Helvetica Neue', 'Impact', 'Lucide Grande', 'Tahoma', 'Times New Roman', 'Verdana']
    });
});
</script>