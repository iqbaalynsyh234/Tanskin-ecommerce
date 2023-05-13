<?php
$segment = $this->uri->segment(3); 
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">


<section class="content-header">
      <h1>
        Setting
        <small>Pengaturan Informasi Toko.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
        <?php if($segment == null){ }else{ ?>
        <li class="active text-capitalize"><?php echo $segment;  ?></li>
        <?php } ?>
      </ol>
    </section>
<section class="content">
<div class="nav-tabs-custom">
    <?php $this->load->view('admin/setting/nav-settings') ?>
<div class="tab-content">
   <h3 class="box-title">Metode Pengiriman</h3>
  <form action="<?php echo base_url().'entersite/proses_ekspedisi' ?>" method="post">
   <ul class="ekspedisi-options">
   <?php 
  foreach ($ekspedisi->result() as $key) {
    if($key->publish == '11'){
      $checked = 'checked';
    }else{
      $checked = '';
    }
   ?>
          <li>
          <label>
            <div class="media">
            <div class="media-left">
               <span class="icon icon-<?php echo $key->icon_class ?>"></span>
            </div>
            <div class="media-body media-middle">
              <?php echo $key->nama_ex ?>
              <span><input type="checkbox" name="ekspedisi[]" value="<?php echo $key->id_ex ?>" <?php echo $checked ?>></span>
            </div>
          </div>
          </label>
          </li>
    <?php } ?>
    
          </ul>
          <div class="clearfix"></div>
          <hr style="margin-bottom: 10px; margin-top: 0px;">
          <div class="text-right">
          <button type="submit" name="shipping_publish" value="true" class="btn btn-default">Simpan Perubahan</button>
          </div>
        </form>
   

   <h3 class="box-title">Ongkos Kirim (dari Jakarta)</h3>
   <table id="table-01" class="table table-bordered table-shipping-cost table-responsive">
     <thead>
       <tr>
         <th width="5px">No</th>
         <th>Kota/Kabupaten</th>
         <th>Kecamatan</th>
         <?php  
         foreach ($eks_publish->result() as $val) { 
         if($val->id_ex == 1){
         ?>
         <th class="text-right" width="50px">JNE Reg</th>
         <th class="text-right" width="50px">JNE Oke</th>
         <th class="text-right" width="50px">JNE Yes</th>
         <?php } else { ?>
         <th class="text-right" width="50px"><?php if($val->nama_ex == 'POS Indonesia'){ echo 'POS'; }else{ echo $val->nama_ex; } ?></th>
         <?php } } ?>
         <th></th>
       </tr>
     </thead>
     <tbody>
      
     </tbody>
   </table>
</div>
</div>
</section>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/priceformat/jquery.priceformat.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script> -->
<script type="text/javascript">
function init_priceformat(sv){
  sv.priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
  });
}

function init_nocost(baris, ini){
  var valten;
  for (i = 0; i < baris; i++) { 
  valten = parseInt(ini.eq(i+3).find('input').val().replace(/,.*|\D/g,''),10);
  if(isNaN(valten)) { valten = 0 }
      if(valten == 0){
        ini.eq(i+3).find('input').val('-');
      }
  }
}

function init_savedcaost(datax, inputable, btnsave, baris, ini){
        $.ajax({
            url: "<?php echo base_url().'entersite/changedcost' ?>",
            type: "POST",
            data: datax,
            cache: false,
            dataType:'json',
            success: function(json){
                if(json.status == '1'){
                    inputable.attr('readonly', true);
                    btnsave.attr('disabled', true);
                    $('.status-alert-view span').html(json.message);
                    init_nocost(baris, ini);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
                if(json.status == '0'){
                    $('.status-alert-view span').html(json.message);
                    init_nocost(baris, ini);
                    $('.status-alert-view').addClass('open').delay(3000).queue(function(next){
                    $(this).removeClass('open');
                    $('.status-alert-view span').html('');
                    next();
                    });
                }
            }
        });

}

$(function(){
$(".select2").select2({
    minimumResultsForSearch: -1
});

$('#myModal').on('hidden.bs.modal', function (e) {
  document.getElementById("myForm").reset();
})

var table;
    //datatables
    table = $('#table-01').DataTable({ 
        "responsive": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('entersite/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    });

$('body').on('click', '.cost-btn', function(){
var idpengiriman = $(this).data('id'),
    baris        = $(this).closest('tr').find('td').length-4,
    ekspedisi    = [],
    inputable    = $(this).closest('tr').find('td').find('input'),
    btnsave      = $(this).closest('tr').find('td').find('button.cost-btn'),
    ini          = $(this).closest('tr').find('td'),
    konten, valten;
    ekspedisi.push({ name: "id", value: idpengiriman});
    for (i = 0; i < baris; i++) { 
        konten = $(this).closest('tr').find('td').eq(i+3).find('input').data('id');
        valten = $(this).closest('tr').find('td').eq(i+3).find('input').val();
        ekspedisi.push({ name : konten, value: valten});
    }
    init_savedcaost(ekspedisi, inputable, btnsave, baris, ini);
});

$('body').on('click', '.btn-edit', function(){
var inputable = $(this).closest('tr').find('td').find('input'),
    btnsave   = $(this).closest('tr').find('td').find('button.cost-btn');
    if (inputable.attr('readonly')) {
        inputable.removeAttr('readonly');
        btnsave.attr('disabled', false);
        init_priceformat(inputable);
    } else {
        inputable.attr('readonly', true);
        btnsave.attr('disabled', true);
    }    
});

});
</script>