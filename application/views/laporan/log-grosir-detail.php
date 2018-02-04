<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Barang</h3>
				</div>
				<div class="box-body">
          <div class="form-inline">
            <table>
              <tr>
                <td><b>Tanggal Transaksi</b>&nbsp;</td>
                <td>: <?php echo $transaksi->row()->tanggal; ?></td>
              </tr>
              <tr>
                <td><b>No. Faktur</b></td>
                <td>: <?php echo $transaksi->row()->no_faktur; ?></td>
              </tr>
              <tr>
                <td><b>Kasir</b></td>
                <td>: <?php echo get_name_of_user($transaksi->row()->id_user); ?></td>
              </tr>
            </table>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th width="1">#</th>
                  <th>Barcode</th>
                  <th>Product</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($listdata->result()) {
                  $no = 1;
                  foreach ($listdata->result() as $val) {
                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->kode_stock.'</td>
                    <td>'.$val->product.'</td>
                    <td class="text-right">'.$val->hargasatuan.'</td>
                    <td>'.$val->keterangan.'</td>
                    </tr>';
                    $no++;
                  }
                }
                else echo '<tr><td colspan="5" class="center bg-red">Data Kosong</td></tr>';
                ?>
              </tbody>
              <tbody>
                <tr>
                  <td colspan="3" class="text-right">Total Belanja</td>
                  <td class="text-right"><?php echo $transaksi->row()->total; ?></td>
                  <td rowspan="5"></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">Potongan</td>
                  <td class="text-right"><?php echo $transaksi->row()->potongan; ?></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">Total Akhir</td>
                  <td class="text-right"><?php echo $transaksi->row()->total_akhir; ?></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">Bayar</td>
                  <td class="text-right"><?php echo $transaksi->row()->bayar; ?></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">Kembalian</td>
                  <td class="text-right"><?php echo $transaksi->row()->kembalian; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
				</div>
				<div class="box-footer clearfix">
          <?php
            echo anchor('laporan/log-grosir','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
          ?>
        </div>
			</div>
		</div>
	</div>
</section>