<?php
$uri = $this->uri->segment(3); 
if($uri == 'edit'){
  $edit  = $dt_edit->row();
  $title = 'Edit Static Page';
  $brdcm = 'Edit';
  if($edit->publish == '11'){
    $yes = 'checked';
    $no  = '';
  }else{
    $yes = '';
    $no  = 'checked';
  }
  $urilink = base_url('process_entersite/static_page/edit/'.$this->uri->segment(4));
}else{
  $title   = 'New Static Page';
  $brdcm   = 'New';
  $yes     = 'checked';
  $no      = '';
  $urilink = base_url('process_entersite/static_page/new');
}
?>
<!-- bootstrap-wysiwyg -->
<link href="<?php echo base_url(); ?>assets/plugins/summernote/summernote.css" rel="stylesheet">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Kategori Baru</h4>
      </div>
      <form id="cat_form" action="<?php echo base_url().'process_entersite/category_page' ?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
         <input type="text" name="kategori_page" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="submit" value="true" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<section class="content-header">
      <h1>
        Static Page
        <small>Halaman Static Website.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Static Page</li>
        <li class="active"><?php echo $brdcm ?></li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Static Pages / <?php echo $title ?></h3>
  </div>

<form id="obj-form" action="<?php echo $urilink; ?>" method="post" enctype="multipart/form-data">
    <div class="box-body">
    <div class="row">

    <div class="col-sm-8">
      <div class="form-group">
      <label>Judul</label>
      <input type="text" name="title" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->section.'"'; } ?>>
      </div>
    </div>

    <div class="col-sm-12">
    <div class="form-group">
    <label>Content</label>
     <textarea name="deskripsi" id="summernote">
       <?php if($uri == 'edit'){ echo $edit->deskripsi; } ?>
     </textarea>
     </div>
    </div>

    <div class="col-sm-5">
    <div class="form-group">
    <label>Pilih Kategori</label>
      <div class="input-group">
          <select id="kategori" name="category" class="form-control">
            <?php 
            foreach ($kategori as $kat) {
              if($uri == 'edit'){
                if($edit->kategori == $kat->id){
                  $cho = 'selected';
                }else{
                  $cho = '';
                }
              }else{
                $cho = '';
              }
              echo '<option value="'.$kat->id.'" '.$cho.'>'.strtoupper($kat->title_kategori).'</option>';
            }
            ?>
          </select>
          <span class="input-group-btn">
          <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus"></i>
          </button>
          </span>
      </div>
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
      <input type="text" name="seo1" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->title.'"'; } ?>>
    </div>
    <div class="form-group">
      <label>Meta Description</label>
      <input type="text" name="seo2" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->meta_deskripsi.'"'; } ?>>
    </div>
    <div class="form-group">
      <label>Meta Keywords</label>
      <input type="text" name="seo3" class="form-control" <?php if($uri == 'edit'){ echo 'value="'.$edit->meta_keyword.'"'; } ?>>
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
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/data.content.js"></script>


<script type="text/javascript">
$(function(){
    $('#summernote').summernote({
      tabsize: 2,
      height: 350,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']],
      ],
      callbacks: {
          onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            document.execCommand('insertText', false, bufferText);
          },
          onImageUpload: function(image) {
            uploadImage(image[0]);
          },
          onMediaDelete : function(target) {
            deleteImage(target[0].src);
          }
      }
    });
});
</script>