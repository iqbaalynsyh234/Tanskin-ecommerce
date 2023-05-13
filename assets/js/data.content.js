$('#obj-form').validate({
	rules:{
		'title':'required',
		'deskripsi' : 'required',
		'category' : 'required',
	},
	errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

});

$('#cat_form').validate({
	submitHandler: function(form) {
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            dataType:'json',
            success: function(json){
                if(json.status == '1'){
                   $('#kategori').html(json.data);
                   document.getElementById("cat_form").reset();
				   $('#myModal').modal('hide');
                }
                if(json.status == '0'){
                   alert(json.message);
                }
            }
        });
        }
});

function uploadImage(image) {
  var data = new FormData();
  data.append("image", image);
  $.ajax({
        url: base_url + "process_entersite/summernote_add_image",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        success: function(url) {
          $('#summernote').summernote("insertImage", url);
        },
        error: function(data) {
          console.log(data);
        }
  });
}
 
function deleteImage(src) {
  $.ajax({
        data: {src : src},
        type: "POST",
        url: base_url + "process_entersite/summernote_del_image",
        cache: false,
        success: function(response) {
          console.log(response);
        }
  });
}