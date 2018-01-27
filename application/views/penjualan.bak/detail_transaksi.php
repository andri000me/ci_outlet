<section class="content">
  <form method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Penjualan</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Print" data-content="<?php echo $id_faktur;?>"><i class="fa fa-print"></i></a>
          	<?php echo anchor('penjualan','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Kode</label>
              <?php echo '<h3>Nota. '.$no_faktur.'</h3>'; ?>
              <!-- <input type="text" name="kode" class="form-control" value="" placeholder="Kode"> -->
            </div>
            <!-- <div class="form-group">
              <label class="sr-only" for="inputEmail">Quantity</label>
              <input type="text" name="quantity" class="form-control" value="" placeholder="Quantity">
            </div> -->
            <!-- <div class="form-group">
              <input type="submit" class="btn btn-default btn-flat" name="cek_kode" value="Go">
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
                <!-- <th rowspan="2" width="100" class="text-center">Opsi</th> -->
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
                          <td class="text-right">'.$key->quantity.'</td>
                          <td class="text-right">'.$key->harga.'</td>
                          <td class="text-right">'.$total.'</td>
                        </tr>';
                  $no++;
                }
                echo '<tr>
                        <td colspan="5" class="text-right">Sub Total</td>
                        <td class="text-right">'.$totalbelanja_awal.'</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">'.anchor('penjualan/discount/'.$id_faktur,'Discount').'</td>
                        <td class="text-right">'.$total_disc.'</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td class="text-right">'.$totalbelanja_akhir.'</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">Tunai</td>
                        <td class="text-right">'.$tunai.'</td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-right">Kembali</td>
                        <td class="text-right">'.$kembali.'</td>
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
          <!-- <input type="submit" name="batal" value="Batal" class="btn btn-sm btn-default btn-flat pull-left" data-toggle="tooltip" data-placement="top" title="Batal"> -->
          <!-- <input type="submit" name="selesai_transaksi" value="selesai_transaksi" class="btn btn-sm btn-info btn-flat pull-right" data-toggle="tooltip" data-placement="top" title="Selesai Transaksi"> -->
        </div>
			</div>
		</div>
	</div>
  </form>
</section>