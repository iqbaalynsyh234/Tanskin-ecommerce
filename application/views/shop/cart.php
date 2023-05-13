<div id="wrap-content">
<div class="container">
<ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>">Home</a></li>
      <li><a href="<?php echo base_url('shop/catalogue') ?>">Shop</a></li>
  <li class="active">Cart</li>
</ol>

<div class="cartlist-load" style="min-height: 250px;">

</div>


</div>
</div>

<script type="text/javascript">
function init_change(qty, rowid){
	$.ajax({
        url: "<?php echo base_url().'shop/update_cart' ?>",
        type: "POST",
        cache: false,
        data:'qty=' + qty + '&rowid=' +rowid,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
                $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
	            if(json.status == '1'){
                    $('.cartlist-load').load("<?php echo base_url();?>shop/cart_list");
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    $('.cartlist-load').load("<?php echo base_url();?>shop/cart_list");
                    $('.status-alert-view').addClass('open').delay(4000).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
        	}
    	});
}
function init_delCart(rowid){
	$.ajax({
        url: "<?php echo base_url().'shop/delete_cart' ?>",
        type: "POST",
        cache: false,
        data:'rowid=' + rowid,
        dataType:'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(json){
	            if(json.status == '1'){
                    $('.status-alert-view span').html(json.message);
                    $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
                    $('.cartlist-load').load("<?php echo base_url();?>shop/cart_list");
                    $('.status-alert-view').addClass('open').delay(1500).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    $('.int-cart span').load("<?php echo base_url();?>shop/badgecart");
                    $('.cartlist-load').load("<?php echo base_url();?>shop/cart_list");
                    $('.status-alert-view').addClass('open').delay(5000).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
        	}
    	});
}

$(function (){
$('.cartlist-load').load("<?php echo base_url();?>shop/cart_list");
$('body').on('click', '.number-spinner div', function () {    
	var btn  	 = $(this),
		rowid    = $(this).closest('tr').data('rowid'),
		oldValue = btn.closest('.number-spinner').find('input').val().trim(),
        max      = btn.closest('.number-spinner').data('max'),
		newVal   = 0;
	if (btn.attr('data-dir') == 'up') {
        if((parseInt(oldValue) + 1) <= max){
            newVal = parseInt(oldValue) + 1;
        }else{
            newVal = max;
        }
	} else {
		if (oldValue > 1) {
			newVal = parseInt(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	btn.closest('.number-spinner').find('input').val(newVal);
	init_change(newVal, rowid);
});


$('body').on('click', '.delete', function(){
	var rowid = $(this).closest('tr').data('rowid');
	init_delCart(rowid);
});
});
</script>