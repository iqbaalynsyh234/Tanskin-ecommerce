<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Voucher</h4>
      </div>
      <form id="new-voucher" action="<?php echo base_url().'entersite/addvoucher' ?>" method="post">
      <div class="modal-body">
          <div class="row row-mar">
          <div class="col-sm-12 col-pad">
            <div class="form-group">
                <label>Voucher Code</label>
                <input type="text" name="coupon" class="form-control">
            </div>
          </div>
          
          <div class="col-sm-6 col-pad">
          <div class="form-group">
           <label>Potongan</label>
                <div class="input-group">
                  <div class="input-group-addon">
                  <span>Rp</span>
                  </div>
                  <input type="text" name="potongan" class="form-control priceformat potongan">
                </div>                
          </div>
          <div class="max-disc form-group hidden">
           <label>Maksimal</label>
                <div class="input-group">
                  <input type="text" name="potongan-max" min="1" class="form-control priceformat" placeholder="Rp">
                </div>                
          </div>
          </div>
          <div class="col-sm-6 col-pad">
          <div class="form-group">
          <label>Min. Belanja</label>
                <input type="text" name="mintagihan" class="form-control priceformat">
          </div>
          </div>
          
          <div class="col-sm-12 col-pad">
          <div class="form-group">
          <label>Tgl. Berlaku</label>
                <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="sortdate" class="form-control pull-right" id="reservation0">
                </div>
          </div>
          </div>
          
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kuota</label>
                <input type="text" name="kuota" class="form-control">
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Kategori</label>
                <select class="form-control select2" name="kategori" style="width: 100%" required>
                  <option value="">-- select options --</option>
                  <option value="1">Ongkos Kirim</option>
                  <option value="2">Total Belanja</option>
              </select>
              <div class="error"></div>
          </div>
          </div>
          <div class="col-sm-4 col-pad">
          <div class="form-group">
          <label>Publish</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="publish" value="1" checked="">
                      Yes
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label>
                      <input type="radio" name="publish" value="2">
                      No
                    </label>
                  </div>
                </div>
          </div>

          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="new-voucher" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>


<section class="content-header">
      <h1>
        Voucher
        <small>Lorem ipsum dolor sit amet.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Admin</a></li>
        <li class="active">Voucher</li>
      </ol>
</section>

<section class="content">
  <div class="box">
  <div class="box-header with-border">
  <h3 class="box-title">Voucher List</h3>
    <div class="box-tools">
    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">New Voucher</a>          
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="box-body">
    <form action="<?php echo base_url('process_entersite/voucher_action'); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group action-btn hide">

    <button type="submit" onclick="return confirm('Anda yakin ingin menghapus item yang dipilih?')" name="action" value="del" class="btn btn-sm btn-default"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
    
    <button type="submit" name="action" value="publish" class="btn btn-sm btn-default"><i class="fa  fa-eye"></i>&nbsp;Publish</button>

    <button type="submit" name="action" value="unpublish" class="btn btn-sm btn-default"><i class="fa fa-eye-slash"></i>&nbsp;Unpublish</button>

    </div>
   <table id="table01" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="no-sort" width="10">
                    <input type="checkbox" id="selectAll" />
                    </th>
                    <th width="20px">No.</th>
                    <th>Voucher Code</th>
                    <th class="text-right">Kuota (Terpakai)</th>
                    <th class="text-right">Potongan</th>
                    <th class="text-right">Min. Belanja</th>
                    <th class="text-center">Tgl. Mulai - Tgl. Berakhir</th>
                    <th class="text-center">Tgl. Input</th>
                    <th class="text-center">Voucher</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $no = 1;
                foreach ($list_voucher as $key) { 
                  $potongan = ($key->vou_for == "1") ? "Ongkos Kirim" : "Total Belanja";
                  ?>
                <tr>
                  <td><input class="checktbl" type="checkbox" name="pages[]" value="<?php echo $key->ID_vou; ?>"></td>
                  <td><?php echo $no ?></td>
                  <td><?php echo '<a href="'.base_url('entersite/voucher/edit/'.$key->ID_vou).'">'.$key->vou_code.'</a>' ?></td>
                  <td style="text-align: right"><?php echo $key->usage_vou ?></td>
                  <td style="text-align: right"><?php echo rupiah($key->Disc).' / '.$potongan; ?></td>
                  <td style="text-align: right"><?php echo $key->min_amount ?></td>
                  <td style="text-align: center"><?php echo $key->start_voucher.' - '.$key->end_voucher ?></td>
                  <td style="text-align: center"><?php echo $key->input_vou ?></td>
                  <td style="text-align: center"><?php if($key->publish == 1){ echo 'Yes'; }else{ echo 'No';} ?></td>
                  <td>
                </tr>
                <?php $no++; } ?>
                </tbody>
              </table>
  </form>
  </div>
  </div>
  
</section>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.flash.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/datatables/buttons.print.min.js"></script>

<script src="<?php echo base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url().'assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/priceformat/jquery.priceformat.min.js"></script>
<script type="text/javascript">
  function init_action(row){
    if(row > 0){
      $('.action-btn').removeClass('hide');
    }else{
      $('.action-btn').addClass('hide');
    }
  }
  $(function(){

    $('#selectAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        var chlength = $('.checktbl:checked').length;
        init_action(chlength);
    });

    $('.checktbl').click(function(){
    var chlength = $('.checktbl:checked').length;
    var tblength = $('#table-01 tbody tr').length;
        if(chlength == tblength){
          $('#selectAll').prop('checked', this.checked);
        }else{
          $('#selectAll').prop('checked', false);
        }
        init_action(chlength);
    });
    // $('input.potongan').on('keyup keydown', function(){
    //   var value = parseInt($(this).val().replace(/,.*|\D/g,''),10),
    //       place = $('.input-group-addon span');
    //   if(isNaN(value)){ value = 0; }
    //   if(value == 0){
    //     place.text('');
    //     $('.max-disc').addClass('hidden');
    //     $('.max-disc input').attr('required', false);
    //   }
    //   else if(value > 100){
    //     place.text('Rp');
    //     $('.max-disc').addClass('hidden');
    //     $('.max-disc input').attr('required', false);
    //   }else{
    //     place.text('%');
    //     $('.max-disc').removeClass('hidden');
    //     $('.max-disc input').attr('required', true);
    //   }
    // });

    $('#table01').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    });

    $('.priceformat').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      centsLimit: 0
    });

    $(".select2").select2({
          minimumResultsForSearch: -1
    });
    $('#reservation0').daterangepicker({
          locale: {
            format: 'YYYY/MM/DD'
          },
          startDate: '<?php echo date('Y/m/d'); ?>',
          endDate: '<?php echo date('Y/m/d'); ?>'
    });

    $('#new-voucher').validate({
        rules:{
            coupon: "required",
            potongan:{
                required:true,
                number: true
            },
            mintagihan:{
                required:true,
                number: true
            },
            sortdate : "required",
            kuota:{
                required:true,
                number: true
            },
            publish : "required"
        },
        errorPlacement: function(){
            return false;  // suppresses error message text
        }
    });
  });
</script>