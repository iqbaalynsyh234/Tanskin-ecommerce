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
	 <div class="col-sm-8">
  <form id="contact-form">
    <div class="form-group row row-mar">
      <div class="col-sm-6 col-pad">
        <label>Name</label>
        <input type="text" name="fname" id="fname" class="form-control" value="">
      </div>
      <div class="col-sm-6 col-pad">
        <label>Email</label>
        <input type="email" name="lname" id="lname" class="form-control" value="">
      </div>
    </div>
    <div class="form-group">
      <label>Subject</label>
      <input type="text" name="subject" id="subject" class="form-control" value="">
    </div>
    <div class="form-group">
      <textarea name="message" id="message" rows="5" class="form-control" placeholder="Messages"></textarea>
      <small id="errorMessage" class="text-danger"></small>
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
<script>
  document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form fields
    var fname = document.getElementById('fname').value;
    var lname = document.getElementById('lname').value;
    var subject = document.getElementById('subject').value;
    var message = document.getElementById('message').value;
    var errorMessage = document.getElementById('errorMessage');

    // Reset previous error message
    errorMessage.textContent = '';

    // Validate form fields
    if (fname.trim() === '') {
      errorMessage.textContent = 'Please enter your name.';
      return;
    }
    if (lname.trim() === '') {
      errorMessage.textContent = 'Please enter your email.';
      return;
    }
    if (subject.trim() === '') {
      errorMessage.textContent = 'Please enter the subject.';
      return;
    }
    if (message.trim() === '') {
      errorMessage.textContent = 'Please enter a message.';
      return;
    }

    // Simulate form submission success
    // Replace the code below with your actual form submission logic
    // For demonstration purposes, it shows an alert for success and failure
    var randomSuccess = Math.random() < 1;
    if (randomSuccess) {
      alert('Contact Us Hasbeen Succesfully!');
    } else {
      alert('Form submission failed. Please try again later.');
    }
    
    // Reset form fields
    document.getElementById('fname').value = '';
    document.getElementById('lname').value = '';
    document.getElementById('subject').value = '';
    document.getElementById('message').value = '';
  });
</script>
</div>
</div>