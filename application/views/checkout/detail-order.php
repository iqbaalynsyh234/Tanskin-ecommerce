 <?php
 if($this->cart->total_items() > 0){ 
    if($this->session->userdata('ship_area')){
        
    }else{

    }
 ?>
 <div class="box-cart-head">
            <h1><b>Detail Order</b> ( <span><?php echo $this->cart->total_items() ?></span> item(s) )<small>* All the prices are in IDR</small></h1>
        </div>
        <div class="box-cart-body">
        <table class="table-item-list">
            <thead>
                <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($this->cart->contents() as $items):
            ?>
                <tr>
                <td>
                <?php echo $items['name'].'</br>';
                if ($this->cart->has_options($items['rowid']) == TRUE):
                    foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value):
                        if($option_value != ''){
                        echo '<span>'.$option_name.' : <span class="text-capitalize">'.$option_value.'</span><span><br/>';
                        }
                    endforeach;
                endif;
                ?>
                </td>
                <td><?php echo $items['qty'].' x '.rupiah($items['price']) ?></td>
                <td><?php echo rupiah($items['qty']*$items['price']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="one-border"></th></tr>
                <tr><th colspan="3" height="5px"></th></tr>

                <tr>
                <th colspan="2" class="text-right">Subtotal</th>
                <th class="text-right"><?php echo rupiah($this->cart->total()); ?></th>
                </tr>
                <tr>
                <th colspan="2" class="text-right">Shipping</th>
                <th class="text-right">0</th>
                </tr>
                <tr>
                <th colspan="3">
                    
                    <label><a href="javascript:void(0);" class="have-voucher">Have voucher code ?</a></label>
                    <div class="input-group hidden yes-i-have-vou" style="width: 100%">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat">Use the voucher klik here!</button>
                    </span>
                    </div>                   
                     
                </th>
                </tr>
                <tr><th colspan="3" class="one-border"></th></tr>
                <tr><th colspan="3" height="5px"></th></tr>
                <tr>
                <th colspan="2">Total</th>
                <th class="text-right"><?php echo rupiah($this->cart->total()); ?></th>
                </tr>
            </tfoot>
        </table>
        </div>
<script type="text/javascript">
$(function(){
$('body').on('click', '.have-voucher', function(){
    $('.yes-i-have-vou').toggleClass('hidden');
});
});
</script>
<?php } else { redirect(base_url().'shop/cart'); } ?>
