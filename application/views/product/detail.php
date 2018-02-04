<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Detail Product</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('product','<i class="fa fa-close"></i>', array('class'=>'btn btn-box-tool','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
				</div>
				<div class="box-body">
          <?php
            $msg=validation_errors();
            if($msg!=NULL)
            echo msg_warning($msg);
          ?>
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
                <td>Harga Pcs</td>
                <td>: <?php if(empty($listdata->row()->harga_jual)) {echo '-';} else echo $listdata->row()->harga_jual;?></td>
              </tr>
              <tr>
                <td>Harga Grosir</td>
                <td>: <?php if(empty($listdata->row()->harga_akhir)) {echo '-';} else echo $listdata->row()->harga_akhir;?></td>
              </tr>
            </tbody>
          </table>
          <br>
            <?php 
            echo anchor('product/tambah-stock-product/'.$kode, 'Tambah Stock', array('class'=>"btn btn-flat btn-primary"));
            echo ' ';
            echo anchor('product/update-stock/'.$kode, 'Import Stock', array('class'=>"btn btn-flat btn-primary"));?>
          <br><br>
          <table class="table no-margin table-bordered" for="stock">
            <thead>
              <tr>
                <th width="1">#</th>
                <th>Barcode Stock Product</th>
                <th>msisdn</th>
                <th>Expired</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($listdetailstock->result()) {
                  foreach ($listdetailstock->result() as $key) {
                    echo '<tr>';
                    echo '<td>'.$no.'</td>';
                    echo '<td>'.$key->kode.'</td>';
                    echo '<td>'.$key->msisdn.'</td>';
                    echo '<td>'.$key->exp.'</td>';
                    echo '</tr>';
                    $no++;
                  }
                }
                else {
                  echo '<tr><td colspan="5" class="center bg-red">Data Kosong</td></tr>';
                }
              ?>
            </tbody>
          </table>
				</div>
				<div class="box-footer clearfix">
          <?php 
          if (my_level()!='Seles') {
            echo anchor('product','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
          }
          else {
            echo anchor('product/stock-product','Kembali', array('class'=>'btn btn-sm btn-default btn-flat pull-left','title'=>'Kembali', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
          }
          ?>
          <?php if(@$pagination) echo $pagination;?>
        </div>
			</div>
		</div>
	</div>
</section>