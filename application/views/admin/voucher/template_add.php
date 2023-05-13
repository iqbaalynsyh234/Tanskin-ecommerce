<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<style type="text/css">
.gbrupload {
    width: 100%;
    height: 200px;
    margin-right: 10px;
    background-position: center center;
    background-size: contain;
    background-repeat: no-repeat;
    position: relative;
    z-index: 10;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #d5d5d5;
}
.gbrupload span{
    font-weight: bold;
    font-size: 26px;
    color: #d5d5d5;
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
<section class="content-header">
      <h1>
        Template
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Template</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Add Template Voucher</h3>
    <div class="clearfix"></div>
  </div>
  <div class="box-body">
   <form id="new-voucher" action="" method="post" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="row row-mar">
          
          
          
          <div class="col-sm-4 col-pad">
            <div class="form-group image--preview">
              <label>Template Image</label>
             
              <div class="gbrupload">
                <span>1280 X 902</span>
              </div>
              <div class="custom-file-input">
                  <span></span>
                  <span>
                  <i class="icon-picture"></i>&nbsp; &nbsp;Browse
                  <input type="file" class="btn-img-prev" name="image">
                  </span>
              </div>
              <small>JPG format only.</small>
            </div>
          </div>

          <div class="col-sm-4 col-pad">
            <div class="form-group">
              <label>Discount Value</label>
              <input type="text" class="priceformat form-control" name="disc" required>
            </div>

            <div class="form-group">
            <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="1" checked>
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="0">
                      No
                    </label>
                  </div>
                </div>
          </div>
          

          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" value="new-voucher" class="btn btn-primary">Submit</button>
      </div>
      </form>
  </div>
  </div>
  
</section>

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/priceformat/jquery.priceformat.min.js"></script>
<script type="text/javascript">
$(function(){
    $('.priceformat').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
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
                ini.find("span").hide();
                }
            }
    });
});
</script>
