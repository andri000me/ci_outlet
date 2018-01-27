<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Detail Mutasi</h3>
				</div>
				<div class="box-body">
					<table class="table">
            <tbody>
              <tr>
                <td width="120">Tanggal</td>
                <td>: <?php if(empty($listdata->row()->tanggal)) {echo '-';} else echo $listdata->row()->tanggal;?>
                </td>
                <td width="120"></td>
                <td></td>
              </tr>
              <tr>
                <td>Product</td>
                <td>: <?php if(empty($listdata->row()->product)) {echo '-';} else echo $listdata->row()->product;?></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Lokasi Awal</td>
                <td>: <?php if(empty($listdata->row()->lokasi_awal)) {echo '-';} else echo $listdata->row()->lokasi_awal;?></td>
                <td>Lokasi Akhir</td>
                <td>: <?php if(empty($listdata->row()->lokasi_akhir)) {echo '-';} else echo $listdata->row()->lokasi_akhir;?></td>
              </tr>
            </tbody>
          </table>
          <br>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th width="1">#</th>
                  <th>Barcode Stock Product</th>
                  <!-- <th>Expired</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($listdetailstock->result()) {
                    foreach ($listdetailstock->result() as $key) {
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$key->kode_stock.'</td>';
                      // echo '<td></td>';
                      echo '</tr>';
                      $no++;
                    }
                  }
                  else {
                    echo '<tr><td colspan="2" class="center bg-red">Data Kosong</td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div>
				</div>
				<div class="box-footer clearfix">
          <div class="pull-left">
            <?php echo anchor('mutasi','Kembali', array('class'=>'btn btn-primary'))?>
          </div>
          <div class="pull-right">
            <?php if(@$pagination) echo $pagination;
            else echo '&nbsp;'; ?>
          </div>
          <div class="clearfix"></div>
        </div>
			</div>
		</div>
	</div>
</section>