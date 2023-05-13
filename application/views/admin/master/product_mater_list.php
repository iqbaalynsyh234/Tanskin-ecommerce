<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<section class="content-header">
      <h1>
        List Products
        <small>Lorem ipsum dolor sit amet.</small>
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
  <h3 class="box-title">List Products
        <small>Lorem ipsum dolor sit amet.</small></h3>
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
                    <th>No.</th>
                    <th>Item Code</th>
                    <th>Name Product</th>
                    <th>Category</th>
                    <th>Color</th>
                    <th>Uploader</th>
                    <?php if($this->session->userdata('del_akses') == '11') : ?>
                    <th class="text-center">Delete</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                 <?php foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo $value['item_code'] ?></td>
                        <td><a href="<?php echo base_url('master/product-master/edit/'.$value['id']); ?>"><?php echo $value['item_name'] ?></a></td>
                        <td><?php foreach ($value['ItemSubcate'] as $key => $list) {
                            $slash = ($key < (count($value['ItemSubcate']) - 1)) ? ' / ' : '';
                            echo $list['kategori'].$slash;
                        } ?></td>
                        <td><?php foreach ($value['color'] as $key => $list) {
                            $slash = ($key < (count($value['color']) - 1)) ? ' / ' : '';
                            echo $list['ColorName'].' ('.$list['stock'].' Pcs)'.$slash;
                        } ?></td>
                        <td><?php echo ucfirst($value['uploader']) ?></td>
                        <?php if($this->session->userdata('del_akses') == '11') : ?>
                        <td align="center"><a href="<?php echo base_url('master/del_product/'.$value['id']) ?>" onclick="return confirm('data akan dihapus permanen!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                        <?php endif; ?>
                    </tr>
                 <?php } ?>
                </tbody>
              </table>
  </div>
  </div>
  
</section>
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
  });
</script>