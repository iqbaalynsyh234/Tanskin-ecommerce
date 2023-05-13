<table>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Item Code</th>
                    <th>Name Product</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Barcode</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody>
                 <?php 
                 foreach ($list_produk as $key => $list) { 
                  $barcode_size = ($list['size'] != 14) ? '-'.$list['size'] : '';
                 ?>
                 <tr>
                 <td><?php echo $key + 1 ?></td>
                 <td><?php echo $list['ItemCode'] ?></td>
                 <td><?php echo $list['ItemName'] ?></td>
                 <td><?php echo $list['color_name'] ?></td>
                 <td><?php echo $list['size_name'] ?></td>
                 <td><?php echo '`'.$list['barcode'].$barcode_size ?></td>      
                 <td align="center"><?php echo $list['stock'] ?></td>  
                 </tr>
                 <?php } ?>
                </tbody>
              </table>