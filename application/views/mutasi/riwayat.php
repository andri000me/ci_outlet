<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Riwayat Mutasi</h3>
				</div>
				<div class="box-body">
					<table class="table">
            <tbody>
              <tr>
                <td width="120">Supplier</td>
                <td>: <?php if(empty($listdata->row()->supplier)) {echo '-';} else echo $listdata->row()->supplier;?></td>
              </tr>
              <tr>
                <td>Jenis</td>
                <td>: <?php if(empty($listdata->row()->jenis)) {echo '-';} else echo $listdata->row()->jenis;?></td>
              </tr>
              <tr>
                <td>Provider</td>
                <td>: <?php if(empty($listdata->row()->provider)) {echo '-';} else echo $listdata->row()->provider;?></td>
              </tr>
              <tr>
                <td>Lokasi</td>
                <td>: <?php if(empty($listdata->row()->lokasi)) {echo '-';} else echo $listdata->row()->lokasi;?></td>
              </tr>
              <tr>
                <td>Nama Product</td>
                <td>: <?php if(empty($listdata->row()->product)) {echo '-';} else echo $listdata->row()->product;?></td>
              </tr>
              <tr>
                <td>Kode</td>
                <td>: <?php if(empty($listdata->row()->kode)) {echo '-';} else echo $listdata->row()->kode;?></td>
              </tr>
              <tr>
                <td>Harga Awal</td>
                <td>: <?php if(empty($listdata->row()->harga_awal)) {echo '-';} else echo $listdata->row()->harga_awal;?></td>
              </tr>
              <tr>
                <td>Harga Jual</td>
                <td>: <?php if(empty($listdata->row()->harga_jual)) {echo '-';} else echo $listdata->row()->harga_jual;?></td>
              </tr>
              <tr>
                <td>Harga Akhir</td>
                <td>: <?php if(empty($listdata->row()->harga_akhir)) {echo '-';} else echo $listdata->row()->harga_akhir;?></td>
              </tr>
            </tbody>
          </table>
          <br>
          <table class="table no-margin table-bordered">
            <thead>
              <tr>
                <th width="1">#</th>
                <th>Tanggal</th>
                <th>Lok Awal</th>
                <th>Lok Akhir</th>
                <th>Jumlah</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($listmutasi->result()) {
                foreach ($listmutasi->result() as $val) {
                  echo '<tr>
                  <td>'.$no.'</td>
                  <td>'.$val->tanggal.'</td>
                  <td>'.$val->lokasi_awal.'</td>
                  <td>'.$val->lokasi_akhir.'</td>
                  <td>'.$val->jumlah.'</td>
                  <td>';
                  echo anchor('mutasi/riwayat/detail/'.encrypts($val->id_mutasi),'<i class="fa fa-fw fa-file-text"></i>', array('class'=>'text-blue','title'=>'Detail', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                      echo '&nbsp;&nbsp;&nbsp;';
                  echo '</td>
                  </tr>';
                  $no++;
                }
              }
              else {
                echo '<tr><td colspan="6" class="center bg-red">Data Kosong</td></tr>';
              }
              ?>
            </tbody>
          </table>
				</div>
				<div class="box-footer clearfix">
          <?php if(@$pagination) echo $pagination;
          else echo '&nbsp;'; ?>
          <?php echo anchor('mutasi','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
        </div>
			</div>
		</div>
	</div>
</section>