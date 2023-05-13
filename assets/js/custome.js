function init_ChangeStatus(data, valuex, uri, ini){
  swal({
    title: "",
    text: "Change status order",
    type: "",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ok",
    cancelButtonText: "Batal",
    closeOnConfirm: true,
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
            url: uri,
            type: "POST",
            data: {order:valuex, status:data},
            cache: false,
            dataType:'json',
            success: function(json){
                if(json.status == '1'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $('.status-alert-view span').html('');
                    location.reload();
                    next();
                    });
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
            }
        });
    }else{
    	ini.prop('selectedIndex',0);
    }
  });
}


function init_PaymentConfirm(form, value){
    swal({
    title: "",
    text: "Change status order",
    type: "",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ok",
    cancelButtonText: "Batal",
    closeOnConfirm: true,
  },
  function(isConfirm){
    if (isConfirm) {
         $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: {submitpay:value},
            cache: false,
            dataType:'json',
            success: function(json){
                if(json.status == '1'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $('.status-alert-view span').html('');
                    location.reload();
                    next();
                    });
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
            }
        });
    }
  });
}

