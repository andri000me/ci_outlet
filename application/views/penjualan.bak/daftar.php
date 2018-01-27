<section class="content">
  <form method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Penjualan</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('penjualan/transaksi_baru','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Transaksi Baru', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
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
            <?php echo anchor('penjualan/transaksi_baru','Transaksi Baru</i>', array('class'=>'btn btn-sm btn-primary btn-flat','title'=>'Batal', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th width="1">#</th>
                  <th width="100">No Faktur</th>
                  <th>Tanggal</th>
                  <th>total item</th>
                  <th>Nilai Trans</th>
                  <th width="150" class="center">Opsi</th>
                </tr>
                <?php 
                if($listdata->result())
                {
                  $no=1;
                  foreach ($listdata->result() as $key) 
                  { 
                    if($key->flag_transaksi==4){$status = 'NEW';}
                    else if($key->flag_transaksi==3){$status = 'ONGOING';}
                    else if($key->flag_transaksi==1){$status = 'PAYMENT';}
                    else if($key->flag_transaksi==0){$status = 'COMPLETE';}
                    echo '<tr>';
                    echo '<td>'.$no.'</td>';
                    echo '<td>'.$key->no_faktur.'</td>';
                    echo '<td>'.$key->tanggal.'</td>';
                    echo '<td>'.$key->totalitem.'</td>';
                    echo '<td>'.$key->totalbelanja_akhir.'</td>';
                    echo '<td class="center">';
                    if ($status=='COMPLETE') {
                      echo '<a href="javascript:void(0);" class="text-orange" data-content="'.$key->id_faktur.'" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>';
                    }
                    echo '&nbsp;&nbsp;';
                    echo anchor('penjualan/transaksi_barang/'.$key->id_faktur,'<i class="fa fa-fw fa-pencil"></i> '.$status, array('class'=>'text-blue','title'=>$status, 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
                    echo '</td>';
                    echo '</tr>';
                    $no++;
                  }
                }
                else
                {
                ?>
                <tr><td colspan="8" class="center bg-red">Data Kosong</td></tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
				</div>
				<div class="box-footer clearfix">
          &nbsp;
        </div>
			</div>
		</div>
	</div>
  </form>
</section>