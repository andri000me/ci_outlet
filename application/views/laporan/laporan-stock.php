<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Barang</h3>
          <div class="box-tools pull-right" style="display: -webkit-inline-box">
          	<?php echo anchor('barang/tambah','<i class="fa fa-plus"></i>', array('class'=>'btn btn-box-tool','title'=>'Tambah', 'data-toggle'=>'tooltip', 'data-placement'=>'top'))?>
            <a href="javascript:void(0);" class="btn btn-box-tool" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print"></i></a>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-database"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><?php echo anchor('barang/template','Download Template');?></li>
                <li><?php echo anchor('barang/import','Import Data');?></li>
                <li class="divider"></li>
                <li><?php echo anchor('barang/export','Export Data');?></li>
              </ul>
            </div>
          </div>
				</div>
				<div class="box-body">
          <div class="form-inline">
            <?php if(my_level()!='Seles') { ?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Lokasi</label>
              <select name="id_lokasi" id="id_lokasi" class="form-control">
                <option value="">-- Lokasi --</option>
                <?php if ($listlokasi->result()) {
                  foreach ($listlokasi->result() as $key) {
                    echo '<option value="'.$key->id_lokasi.'"';
                    if($this->session->userdata('id_lokasi')==$key->id_lokasi) echo 'selected="selected"';
                    echo '>'.$key->lokasi.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <!-- <div class="form-group">
              <label class="sr-only" for="inputEmail">User</label>
              <select name="id_user" id="id_user" class="form-control">
                <option value="">-- Seles --</option>
                <?php //if ($listuser->result()) {
                //   foreach ($listuser->result() as $key) {
                //     echo '<option value="'.$key->id_user.'"';
                //     if($this->session->userdata('id_user')==$key->id_user) echo 'selected="selected"';
                //     echo '>'.$key->nama.'</option>';
                //   }
                // }
                ?>
              </select>
            </div> -->j
            <?php } ?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Awal</label>
              <input type="text" class="form-control" name="tanggal_awal" id="datepicker1" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $this->session->userdata('tgl_awal')?>">
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Akhir</label>
              <input type="text" class="form-control" name="tanggal_akhir" id="datepicker2" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $this->session->userdata('tgl_akhir')?>">
            </div>
            <button class="btn btn-flat btn-primary" name="tampilkan">Tampilkan</button>
            
          </div>
          <br>
          <?php 
          
          ?>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th rowspan="2" style="line-height: 3em;" width="1">#</th>
                  <th rowspan="2" style="line-height: 3em;">Kode</th>
                  <th rowspan="2" style="line-height: 3em;">Product</th>
                  <th rowspan="2" style="line-height: 3em;">Harga @</th>
                  <th colspan="4" class="center">Stock</th>
                  <th colspan="2" class="center">Total</th>
                </tr>
                <tr>
                  <th width="1">Awal</th>
                  <th width="1">Masuk</th>
                  <th width="1">Jual</th>
                  <th width="1">Akhir</th>
                  <th width="1">Masuk(Rp)</th>
                  <th width="1">Jual(Rp)</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if ($listdata->result()) {
                  foreach ($listdata->result() as $val) {
                    if($val->qawal==null) $awal = 0;
                    else $awal = $val->qawal;

                    if($val->qtambah==null) $tambah = 0;
                    else $tambah = $val->qtambah;

                    if($val->qjual==null) $jual = 0;
                    else $jual = $val->qjual;

                    if($val->hmasuk==null) $masuk = 0;
                    else $masuk = $val->hmasuk;

                    if($val->hkeluar==null) $keluar = 0;
                    else $keluar = $val->hkeluar;

                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->kode.'</td>
                    <td>'.$val->product.'</td>
                    <td>'.$val->harga_satuan.'</td>
                    <td>'.$awal.'</td>
                    <td>'.$tambah.'</td>
                    <td>'.$jual.'</td>
                    <td>'.stock($val->id_product).'</td>
                    <td>'.$masuk.'</td>
                    <td>'.$keluar.'</td>
                    </tr>';
                    $no++;
                  }
                }
                else echo '<tr><td class="center bg-red" colspan="10">Data Kosong</td></tr>';
                ?>
              </tbody>
            </table>
            <div class="pull-right">
              <?php if(@$pagination) echo $pagination;
              else echo '&nbsp;'; ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" style="width: 30%;">
              <thead>
                <tr>
                  <th width="1" colspan="3" class="text-center">Rekap Penjualan</th>
                </tr>
                <tr>
                  <th width="1">#</th>
                  <th>Item</th>
                  <th>Omset</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Penjualan Perdana</td>
                  <td><?php 
                  if($total_jual==null) $total_jual = 0;
                  else $total_jual;
                  echo $total_jual;?></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Penjualan Pulsa</td>
                  <td><?php echo $total_pulsa = 0;?></td>
                </tr>
                <tr>
                  <th>3</th>
                  <th>Total Omset</th>
                  <th><?php 
                  echo $total_pulsa+$total_jual;?></th>
                </tr>
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
</section>
