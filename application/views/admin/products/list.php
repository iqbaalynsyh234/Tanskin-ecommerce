<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
  .btn-status{
    padding: 10px 8px;
  }
</style>
<section class="content-header">
      <h1>
        List Products
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Product</li>
        <li class="active">Add Item</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <form class="form-inline" action="<?php echo base_url('entersite/product/list') ?>" method="get">
    <div class="form-group">
    <input type="text" class="form-control" name="itemcode" placeholder="Item Code" value="<?php echo (!empty($item_code)) ? $item_code : ''; ?>">
  </div>
  <button type="submit" class="btn btn-default">Group Product</button>
  <?php if(!empty($item_code)){ ?>
  <a href="<?php echo base_url('entersite/product/clear') ?>" class="btn btn-warning"><i class="fa fa-close"></i></a>
  <?php } ?>
  </form>
        
    <div class="box-tools">

      <a href="<?php echo base_url().'master/stock_produk' ?>" class="btn btn-info"><i class="fa fa-download"></i> Download</a>
      <a href="<?php echo base_url().'master/product' ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Product</a>          
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="box-body">
   <table id="table01" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Item Code</th>
                    <th>Name Product</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Uploader</th>
                    <th>Publish</th>
                  </tr>
                </thead>
                <tbody>
                 <?php 
                 foreach ($list_produk as $key => $list) { 
                  $color = ($list['stock']['ColorName'] != "") ? ' ('.$list['stock']['ColorName'].')' : '';
                 ?>
                 <tr class="text-uppercase" <?php echo ($list['image'] == "") ? 'style="background: antiquewhite;"' : ''; ?>>
                 <td><?php echo $key + 1 ?></td>
                 <td><a href="<?php echo base_url().'master/product_data/'.$list['ID_item'] ?>"><?php echo $list['ItemCode'] ?></a></td>
                 <td><?php echo $list['ItemName'].$color ?></td>
                 <td><?php echo $list['barcode'] ?></td>
                 <td><?php if(count($list['ItemSubcate']) > 0) { foreach ($list['ItemSubcate'] as $key => $value) {
                   $slash = ($key < (count($list['ItemSubcate']) - 1)) ? ' / ' : '';
                   echo $value['kategori'].$slash;
                 } } ?></td>      
                 <td align="center">
                  <?php /*/ ?>
                  <button class="btn btn-default" data-name="<?php echo $list['ItemName'].$color ?>" data-whatever="<?php echo $list['barcode'] ?>" data-stock="<?php echo $list['stock']['total_stock'] ?>" data-toggle="modal" data-target="#myStock">
                  <?php echo $list['stock']['total_stock'] ?>
                  </button>
                    <?php /*/ ?>
                    <?php echo $list['stock']['total_stock'] ?>
                  </td>  
                 <td><?php echo 'Rp. '.rupiah($list['ItemPrice']) ?></td>
                 <td><?php echo $list['adm_name'] ?></td>
                 <td><?php 
                 if($list['image'] == ""){
                  echo 'UPLOAD GAMBAR';
                 }else{
                  if($list['publish'] == '11'){
                    $btncolor = 'success';
                  }elseif($list['publish'] == '12'){
                    $btncolor = 'warning';
                  }else{
                    $btncolor = 'default';
                  }
                  echo '<button type="button" class="btn btn-xs btn-'.$btncolor.' btn-status btn-block" data-toggle="modal" data-target="#myModal" data-whatever="'.$list['ID_item'].'" data-type="'.$list['ItemType'].'" data-status="'.$list['publish'].'" data-name="'.$list['ItemName'].$color.'"></button>';
                 }
                 ?></td>
                 
                 </tr>
                 <?php } ?>
                </tbody>
              </table>
  </div>
  </div>
  
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <form action="<?php echo base_url('entersite/status_produk') ?>" method="post">
      <input type="hidden" name="id" value="">
      <div class="modal-body">
      <div class="radio">
        <label>
          <input type="radio" name="optionsRadios" id="optionsRadios1" value="11" checked>
          Tampilkan produk
        </label>
      </div>
      <div id="variant" class="radio">
        <label>
          <input type="radio" name="optionsRadios" id="optionsRadios2" value="12">
          Produk Tampil pada varian Warna
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="optionsRadios" id="optionsRadios3" value="01">
          Produk disembunyikan
        </label>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php /*/ ?>
<div class="modal fade" id="myStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myStockLabel"></h4>
      </div>
      <form action="<?php echo base_url('entersite/stok_produk') ?>" method="post">
      <input type="hidden" name="id" value="">
      <div class="modal-body">
     
        <div class="form-group row">
          <label class="col-md-4">Stock</label>
          <div class="col-md-8">
            <input type="number" name="stock" class="form-control">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php /*/ ?>

<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script type="text/javascript">
  $(function(){
    $('#table01').DataTable({
        pageLength : 100,
    });

    <?php /*/ ?>
    $('#myStock').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      modal.find('.modal-title').text(button.data('name'));
      modal.find('input[name="id"]').val(button.data('whatever'));
      modal.find('input[name="stock"]').val(button.data('stock'));

    });
    <?php /*/ ?>


    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      modal.find('.modal-title').text(button.data('name'));
      modal.find('input[name="id"]').val(button.data('whatever'));
      if(button.data('type') == '2' || button.data('type') == '4'){
        modal.find('#variant').show();
      }else{
        modal.find('#variant').hide();
      }
      
      if(button.data('status') == '11'){
        modal.find('#optionsRadios1').prop('checked', true);
      }else if(button.data('status') == '12'){
        modal.find('#optionsRadios2').prop('checked', true);
      }else{
        modal.find('#optionsRadios3').prop('checked', true);
      }

    });

  });
</script>