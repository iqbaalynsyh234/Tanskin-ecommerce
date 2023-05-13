<style type="text/css">
    .icons{
        -webkit-transition: all .3s linear;
        -o-transition: all .3s linear;
        transition: all .3s linear;
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        color: rgba(0,0,0,0.15);
    }
</style>
<section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Dashboard</li>
      </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3><?php echo $order_today ?></h3>
                            <p>Pesanan Baru (<?php echo date('d M Y') ?>)</p>
                        </div>
                        <div class="icons">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $items_week['total'].' Pcs' ?></h3>
                            <p>Penjualan (<?php echo date("d M", strtotime(week_ago())) .' - '.date('d M Y') ?>)</p>
                        </div>
                        <div class="icons">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo 'Rp. '.rupiah($pay_week['penjualan']) ?></h3>
                            <p>Pembayaran (<?php echo date("d M", strtotime(week_ago())) .' - '.date('d M Y') ?>)</p>
                        </div>
                        <div class="icons">
                            <i class="ion ion-card"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Produk Terlaris <?php echo date("d M", strtotime(week_ago())) .' - '.date('d M Y') ?></h3>
                        </div>
                        <div class="box-body">
                            <table id="table01" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Code</th>
                                        <th>Product Name / Barcode</th>
                                        <th>Color / Size</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php 
                                    foreach ($produk as $key => $value) {
                                    $color = ($value['color'] != '') ? get_color_name($value['color']) : ''; 
                                    $size  = ($value['size'] != '') ? get_size_name($value['size']) : '';
                                    $spare = (!empty($color) && !empty($size)) ? '/' : '';
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $value['ItemCode'] ?></td>
                                        <td><?php echo $value['ItemName'].' ('.$value['barcode'].')'; ?></td>
                                        <td><?php echo $color.$spare.$size ?></td>
                                        <td><?php echo $value['total'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>

                
            </div>


            

        </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Warning Stock Products</h3>
                    </div>
                    <div class="box-body">
                        <table id="table01" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item Code</th>
                                    <th>Product Name / Barcode</th>
                                    <th>Color</th>
                                    <th>Stock</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php foreach ($warning_stock as $key => $value) { 
                                    $color = ($value['color'] != '') ? get_color_name($value['color']) : ''; 
                                    $size  = ($value['size'] != '') ? get_size_name($value['size']) : '';
                                    $spare = (!empty($color) && !empty($size)) ? '/' : '';
                                ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $value['ItemCode'] ?></td>
                                    <td><?php echo $value['ItemName'].' ('.$value['barcode'].')'; ?></td>
                                    <td><?php echo $color.$spare.$size ?></td>
                                    <td><?php echo $value['stock'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
        


    </div>
</section>

            