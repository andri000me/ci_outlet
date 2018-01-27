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
            <?php if (my_level()==null){?>
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
            <div class="form-group">
              <label class="sr-only" for="inputEmail">User</label>
              <select name="id_user" id="id_user" class="form-control">
                <option value="">-- Seles --</option>
                <?php if ($listuser->result()) {
                  foreach ($listuser->result() as $key) {
                    echo '<option value="'.$key->id_user.'"';
                    if($this->session->userdata('id_user')==$key->id_user) echo 'selected="selected"';
                    echo '>'.$key->nama.'</option>';
                  }
                }
                ?>
              </select>
            </div>
            <?php }?>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Awal</label>
              <input type="text" class="form-control" name="tanggal_awal" id="datepicker1" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
            </div>
            <div class="form-group">
              <label class="sr-only" for="inputEmail">Tanggal Akhir</label>
              <input type="text" class="form-control" name="tanggal_akhir" id="datepicker2" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
            </div>
            <button class="btn btn-flat" name="tampilkan">Tampilkan</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal Retur</th>
                  <th>Tanggal Transaksi</th>
                  <th>No Faktur</th>
                  <th>Kode Stock</th>
                  <th>Product</th>
                  <th>Harga @</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if ($listdata->result()) {
                  foreach ($listdata->result() as $val) {
                    echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->tanggal_retur.'</td>
                    <td>'.$val->tanggal_transaksi.'</td>
                    <td>'.$val->no_faktur.'</td>
                    <td>'.$val->kode_stock.'</td>
                    <td>'.product($val->id_product).'</td>
                    <td>'.$val->harga_satuan.'</td>
                    <td>'.$val->keterangan.'</td>
                    </tr>';
                    $no++;
                  }
                }
                else echo '<tr><td class="center bg-red" colspan="6">Data Kosong</td></tr>';
                ?>
              </tbody>
            </table>
          </div>
				</div>
				<div class="box-footer clearfix">
          <?php if(@$pagination) echo $pagination;
          else echo '&nbsp;'; ?>
        </div>
			</div>
		</div>
	</div>
</section>
