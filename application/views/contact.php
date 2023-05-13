<script src='https://www.google.com/recaptcha/api.js'></script>

<div id="wrap-content">
<div class="container">
<ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>">Home</a></li>
  <li class="active">Contact</li>
</ol>


<div class="item-content">
	<div class="row">
	<div class="col-sm-12">
	<div class="page-side-box">
	<h3>Contact</h3>
	<p>Ada pertanyaan? <br>Kami siap membantu. Isi form berikut dan akan kami respons dalam kurun waktu 24 jam.</p>
	<br>
	<div class="row">
	<div class="col-sm-4">
	<h4><b>Customer Service Hotline</b></h4>
	<address>
	Contact Numbers:	&nbsp;&nbsp;<br><b><?php echo  get_data('store')['no_telp'] ?></b><br>
	Operation Hours:	&nbsp;&nbsp;<br><b>Senin - Minggu 09.00 - 18.00 WIB</b>
	</address>
	<ul class="social-media" style="border-bottom: none;">
			<li class="mainli" style="background-color: #FFF; white-space: nowrap; width: auto;">Social Media</li>
			<?php foreach(get_data('social_media', array(), TRUE) AS $key => $value){ ?>
					<a href="<?php echo $value['url'] ?>" target="_blank"><li><i class="fab fa-<?php echo $value['socialmedia'] ?> inner-center"></i></li></a>
			<?php } ?>
		</ul>
	</div>
	<div class="col-sm-8">
	<form>
		<div class="form-group row row-mar">
				<div class="col-sm-6 col-pad">
                  <label>Name</label>
                  <input type="text" name="fname" class="form-control" value="">
                </div>
                <div class="col-sm-6 col-pad">
                <label>Email</label>
                  <input type="email" name="lname" class="form-control" value="">
                </div>
        </div>
        <div class="form-group">
        	<label>Subject</label>
        	<input type="text" name="fname" class="form-control" value="">
        </div>
        <div class="form-group">
        	<textarea name="message" rows="5" class="form-control" placeholder="Messages"></textarea>
        </div>

        <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6Le7wg4UAAAAABWkHIbSIKFhfLcRy1vGrNLa-25e"></div>
        </div>


        <button type="submit" class="btn btn-main-black">Send Messages</button>
	</form>
	</div>
	</div>
	

	</div>
	</div>
	</div>
</div>

</div>
</div>