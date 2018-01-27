<section class="content">
  <!-- <form method="post" enctype="multipart/form-data"> -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Penjualan</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('stock-product','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
				</div>
				<div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);

            $msg2=$this->session->flashdata('msg');
            if($msg2!=NULL)
            echo $msg2;
          ?>
          <div class="form-inline">
            <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Kode</label>
              <input type="text" name="kode" class="form-control" value="" placeholder="Kode">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-default btn-flat" name="cek_kode" value="Go">
            </div>
            <input type="submit" name="selesai_transaksi" value="Selesai Transaksi" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="Selesai Transaksi">
            </form>
            <!-- <div class="form-group">
              <label class="sr-only" for="inputEmail">Quantity</label>
              <input type="text" name="quantity" class="form-control" value="" placeholder="Quantity">
            </div> -->
          </div>
          <br>
          <table class="table table-bordered no-margin">
            <thead>
              <tr>
                <th rowspan="2" width="1" class="text-center">#</th>
                <th rowspan="2" width="100" class="text-center">Kode</th>
                <th rowspan="2" class="text-center">Product</th>
                <th rowspan="2" class="text-center">Quantity</th>
                <th colspan="2"  class="text-center">Harga</th>
                <th rowspan="2" width="100" class="text-center">Opsi</th>
              </tr>
              <tr>
                <th class="text-center">PCS(Rp)</th>
                <th class="text-center">Total(Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if($list_barang->result())
              {
                $no=1;
                foreach ($list_barang->result() as $key) 
                { 
                  $total = $key->quantity*$key->harga;
                  echo '<tr>
                          <td>'.$no.'</td>
                          <td>'.$key->kode.'</td>
                          <td>'.$key->product.'</td>
                          <td>';
                  ?>
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="kode" value="<?php echo $key->kode; ?>">
                                  <input class="btn btn-xs btn-default" type="submit" name="edit_qty" value="<?php echo $key->quantity; ?>">
                              </form>
                  <?php
                          // '<td class="text-right">'.$key->quantity.'</td>
                  echo   '</td>
                          <td class="text-right">'.$key->harga.'</td>
                          <td class="text-right">'.$total.'</td>
                          <td>';
                  ?>
                              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="kode" value="<?php echo $key->kode; ?>">
                                  <span onclick="return confirm('HAPUS BARANG: <?php echo $key->kode;?> ?')" title="HAPUS">
                                      <input type="submit" name="delete_qty" value="x" class="btn btn-xs btn-warning">
                                  </span>
                              </form>
                  <?php
                  echo   '</td>
                        </tr>';
                  $no++;
                }
                echo '<tr>
                        <td colspan="5" class="text-right">Total Awal</td>
                        <td class="text-right">'.$totalbelanja_awal.'</td>
                        <td rowspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">'.anchor('penjualan/discount/'.$id_faktur,'Discount').'</td>
                        <td class="text-right">'.$total_disc.'</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">Total Akhir</td>
                        <td class="text-right">'.$totalbelanja_akhir.'</td>
                      </tr>';
              }
              else
              {
              ?>
              <tr><td colspan="8" class="center bg-red">Data Kosong</td></tr>
              <?php } ?>
            </tbody>
          </table>
				</div>
				<div class="box-footer clearfix">
          &nbsp;
        </div>
			</div>
		</div>
	</div>
  <!-- </form> -->
</section>