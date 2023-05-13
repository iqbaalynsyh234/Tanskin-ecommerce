<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
.gbrupload {
    background-image: url('<?php echo base_url() ?>assets/image/logo/wrap-slide.png');
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

    font: normal normal 13px/30px Helmet,FreeSans,Sans-Serif;
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
</style>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Slide</h4>
      </div>
      <form id="myForm" action="<?php echo base_url().'process_entersite/banner' ?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
         <label>Title</label>
         <input type="text" name="name" class="form-control">
        </div>

        <div class="row" style="display: none;">
          <div class="col-sm-6">
          <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control" required>
              <option> -- Select Option --</option>
              <option value="1">Image</option>
              <option value="2">Video</option>
            </select>
          </div>
          </div>
          <div class="col-sm-6">
          <div class="form-group">
            <label>Side</label>
            <select name="side" class="form-control" required>
              <option> -- Select Option --</option>
              <option value="1">Left</option>
              <option value="2">Right</option>
            </select>
          </div>
          </div>
        </div>

        <div class="form-group image--preview type-image" style="display: none">
         <label>Image *</label>
         <div class="gbrupload"><img src="<?php echo base_url().'assets/image/view/slider.png' ?>" class="img-responsive"></div>
        <div class="custom-file-input">
            <span></span>
            <span>
            <i class="icon-picture"></i>&nbsp; &nbsp;Browse
            <input type="file" class="btn-img-prev" name="imagemain">
            </span>
        </div>
        </div>

        <div class="type-video" style="display: none;">
          <div class="form-group">
            <label>Video</label>
            <input type="text" name="video" class="form-control" placeholder="code embed youtube">
          </div>
        </div>

        <div class="row">
        <div class="col-sm-12">
        <div class="form-group">
          <label>Url</label>
          <input type="url" name="url" class="form-control">
        </div>
        </div>

        

        <div class="col-sm-12">
        <div class="form-group">
        <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" class="yes" value="yes" checked="">
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" class="no" value="no">
                      No
                    </label>
                  </div>
                </div>
        </div>
        
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="submit" value="true" class="btn btn-primary">Tambah Slide</button>
      </div>
      </form>
    </div>
  </div>
</div>


<section class="content-header">
      <h1>
        Image Home
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Image Home</li>
     </ol>
</section>
<section class="content">
<div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Image Home</h3>
  <div class="box-tools">
      
  </div>
  
  
  </div>
  <div class="box-body">
  <form action="<?php echo base_url('process_entersite/slide_action'); ?>" method="post">
    <input type="hidden" name="table" value="banner">
    <input type="hidden" name="urlback" value="banner">
  <div class="form-group action-btn hide">

  <button type="submit" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
  
  <button type="submit" name="action" value="publish" class="btn btn-sm btn-default"><i class="fa  fa-eye"></i>&nbsp;Publish</button>

  <button type="submit" name="action" value="unpublish" class="btn btn-sm btn-default"><i class="fa fa-eye-slash"></i>&nbsp;Unpublish</button>

  </div>
  <table id="table-01" class="table table-bordered">
    <thead>
      <tr>
        <th width="10" class="no-sort"><input type="checkbox" id="selectAll" /></th>
        <th>Title</th>
        <th>Link</th>
        <th width="120px" class="text-center">Publish</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    foreach ($slider->result() as $key) {
      if($key->publish == '11')
      {
        $publish = 'yes';
      }else
      {
        $publish = 'no';
      }
    ?>
    <tr>
    <td><input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $key->id; ?>"></td>
    <td>
      <a href="#" data-name="<?php echo $key->name; ?>" data-image="<?php echo $key->image; ?>" data-id="<?php echo $key->id; ?>" data-publish="<?php echo $publish; ?>" data-url="<?php echo $key->url; ?>" data-video="<?php echo $key->video; ?>" data-type="<?php echo $key->type; ?>" data-side="<?php echo $key->side; ?>" class="update_banner_modal"><?php echo $key->name ?></a></td>
    <td><?php echo (!empty($key->url)) ? $key->url : '#'; ?></td>
    <td style="text-align: center"><?php echo $publish ?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  </form>
  <br><br>
  </div>
   

</div>
</section>

<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
function init_action(row){
  if(row > 0){
    $('.action-btn').removeClass('hide');
  }else{
    $('.action-btn').addClass('hide');
  }
}

$(function(){
$('#myModal').on('hide.bs.modal', function (e) {
  document.getElementById("myForm").reset();
  $('#myForm').attr('action', '<?php echo base_url().'process_entersite/image' ?>');
  $('#myForm .gbrupload').css('background-image', '');
  $('#myForm .gbrupload img').attr('src', '<?php echo base_url().'assets/image/view/slider.png' ?>');
  $("#myForm button[name='submit']").text('Tambah');
});

$(".update_banner_modal").on('click', function(){
  $('#myModal').modal('show');
    $('#myModal h4#myModalLabel').text('Edit');
        var id  = $(this).data('id'),
        name    = $(this).data('name'),
        image   = $(this).data('image'),
        url     = $(this).data('url'),
        side    = $(this).data('side'),
        type    = $(this).data('type'),
        video   = $(this).data('video'),
        publish = $(this).data('publish');

    if(type === 1){
      $('.type-image').show();
      $('.type-video').hide().find('input').prop('required', false);
    }else{
      $('.type-image').hide();
      $('.type-video').show().find('input').prop('required', true);
    }

    $('#myForm').attr('action', '<?php echo base_url().'process_entersite/image_edit/' ?>'+id);
    $('#myForm input[name="name"]').val(name);
    $('#myForm input[name="url"]').val(url);
    $('#myForm input[name="video"]').val(video);
    $('#myForm select[name="side"]').val(side);
    $('#myForm select[name="type"]').val(type);
    $('#myForm .gbrupload').css('background-image', 'url(<?php echo base_url().'assets/image/slideshow/' ?>'+image+')');
    $("#myForm button[name='submit']").text('Ubah');
});

$('#table-01').DataTable({
  "columnDefs": [{
      "targets": 'no-sort',
      "orderable": false,
    }]
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

$('#selectAll').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    var chlength = $('.checktbl:checked').length;
    init_action(chlength);
});

$('.checktbl').click(function(){
var chlength = $('.checktbl:checked').length;
var tblength = $('#table-01 tbody tr').length;
    if(chlength == tblength){
      $('#selectAll').prop('checked', this.checked);
    }else{
      $('#selectAll').prop('checked', false);
    }
    init_action(chlength);
});

$('select[name="type"]').on('change', function(){
    var type = $(this).val();
    if(type === "1"){
      $('.type-image').show().find('input').prop('required', true);
      $('.type-video').hide().find('input').prop('required', false);
    }else{
      $('.type-image').hide().find('input').prop('required', false);
      $('.type-video').show().find('input').prop('required', true);
    }
});

});

</script>